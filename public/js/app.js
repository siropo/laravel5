
var app = {};
app.helpers = {
    /**
     *
     * @returns {number}
     */
    hash: function() {
        var date = Date.now();

        // Use 2 randoms to avoid same number ever re-occuring
        var random = Math.random() * Math.random();

        return Math.floor(date * random);
    },
    /**
     *
     * @returns {*|jQuery}
     */
    getAdsId: function() {
        return $('#ads_id').val();
    },
    /**
     *
     * @returns {string}
     */
    clearImageTitlePrefix: function() {
        var title = $('#title').val();

        return title.replace(/ /g, '_') + '_';
    },
    /**
     *
     * @returns {*|jQuery}
     */
    getCsrfToken: function() {
        return $('meta[name="csrf-token"]').attr('content')
    },
    /**
     *
     * @param imagePrefix
     * @returns {{}}
     */
    getFormData: function(hash) {
        var files = this.getPictureData('file-footer-caption');
        console.log(files);
        var formData = $('form').serializeArray();
        var postData = {};
        formData.map(function(key) {
            postData[key.name] = key.value;
        });
        postData.pictures = [];
        var title = app.helpers.clearImageTitlePrefix();
        for (var i = 0; i < files.length; i++) {
            console.log(files[i]);
            var imgLink = $('[title="' + files[i] + '"]').parents('.file-preview-frame');
            if (!imgLink.hasClass('file-preview-initial')) {
                postData.pictures.push(title + hash + files[i]);
            } else {
                postData.pictures.push(files[i]);
            }
        }
        console.log(postData);
        return postData;
    },
    /**
     *
     * @param className
     * @returns {Array}
     */
    getPictureData: function(className) {
        var files = [];
        $('.' + className).each(function() {
            files.push($(this).attr('title'));
        });
        return files;
    }
};
app.options = {
    getFileInputSettings: function(hash) {
        return {
            initialPreview: '',
            initialPreviewConfig: '',
            initialPreviewAsData: true,
            uploadUrl: '/ads/imageUpload', // server upload action
            uploadAsync: false,
            maxFileCount: 5,
            deleteUrl: "/ads/imageDelete",
            overwriteInitial: true,
            maxFileSize: 2000,
            showCaption: true,
            showPreview: true,
            showRemove: true,
            showUpload: true, // <------ just set this from true to false
            showCancel: true,
            showUploadedThumbs: true,
            allowedFileTypes: ['image'],
            allowedFileExtensions: ["jpg", "gif", "png"],
            initialCaption: 'pick image',
            uploadExtraData: function() {
                var obj = {_token: app.helpers.getCsrfToken()};
                obj.clearTitle = app.helpers.clearImageTitlePrefix() + hash;
                return obj;
            },
            deleteExtraData: function() {
                var obj = {
                    _token: app.helpers.getCsrfToken()
                };
                obj.imageData = JSON.stringify(app.helpers.getPictureData('file-footer-caption'));
                obj.id = app.helpers.getAdsId();
                return obj;
            }
        }
    }
};
/**
 * @globals selectpicker
 */
app.categories = {};

app.categories.init = function() {
    var _this = this;

    $.ajax('/ads/getcategories')
        .done(function(data) {
            console.log(data);
            _this.renderCategories(data);
        }).fail(function(err) {
        console.log(err);
    });
};

/**
 * Makes the root category
 * @param data
 */
app.categories.renderCategories = function(data) {
    var $categoriesRoot = $('.categories-root');
    var $categoriesWrapper = $('.wrapper-categories');
    var _this = this;
    this.appendSelectOption($categoriesRoot);
    for (var root in data) {
        var option = $('<option value="' + data[root].id + '">' +
            data[root].name + '</option>');
        $categoriesRoot.append(option);
    }
    $categoriesRoot.selectpicker({
        size: 8
    }).on('changed.bs.select', function(e) {
        var selected = e.currentTarget.value;
        var child = data[selected].children;
        _this.clearAttrCategoryId($categoriesRoot);

        var level = 0;
        var counterSelect = $categoriesWrapper.find('select').length - 1;

        // remove child categories
        _this.removeChildCategories(level, counterSelect);

        $categoriesWrapper.find('select').selectpicker('refresh');

        counterSelect = level + 1;

        if (child.length > 0) {
            _this.appendCategories(child, counterSelect);
        }
    });
};

app.categories.appendSelectOption = function($select) {
    var option = $('<option value="">Select</option>');
    $select.append(option);
};

/**
 *
 * @param level
 * @param counterSelect
 */
app.categories.removeChildCategories = function(level, counterSelect) {
    if (level < counterSelect) {
        for (var i = level + 1; i <= counterSelect; i++) {
            $('.bootstrap-select.level' + i).remove();
            $('select.level' + i).selectpicker('destroy');
        }
    }
};

app.categories.clearAttrCategoryId = function($select) {
    var $categories = $('.wrapper-categories');
    var $selectDropDown = $categories.find('select');
    $selectDropDown.attr('name', '');
    $select.attr('name', 'category_id');
};


/**
 * Makes the child categories
 * @param {Array} data Baum result
 * @param {string} counterSelect - level of deep
 */
app.categories.appendCategories = function(data, counterSelect) {
    var _this = this;
    var $categories = $('.wrapper-categories');
    var $select = $('<select data-level="' + counterSelect + '" class="level' + counterSelect + '">' +
        '</select>');
    this.appendSelectOption($select);
    for (var i = 0; i < Object.keys(data).length; i++) {
        var option = $('<option value="' + data[i].id + '" data-id="' + i + '">' +
            data[i].name + '</option>');
        $select.append(option);
    }

    $categories.append($select);

    $select.selectpicker({
        size: 8
    }).on('changed.bs.select', function(e) {

        var level = e.currentTarget.dataset.level;
        var $selectDropDown = $categories.find('select');
        _this.clearAttrCategoryId($select);

        var counterSelect = $selectDropDown.length - 1;
        level = +level;

        _this.removeChildCategories(level, counterSelect);

        $selectDropDown.selectpicker('refresh');

        counterSelect = level + 1;
        var selected = e.currentTarget.selectedOptions[0].dataset['id'];

        // case choose 'select' from drop down - return category_id to previous select
        if (!selected) {
            var $previousSelect = $('select.level' + (level - 1));
            $previousSelect.attr('name', 'category_id');
            _this.clearAttrCategoryId($previousSelect);
            return;
        }

        var child = data[+selected].children;

        if (child.length > 0) {
            _this.appendCategories(child, counterSelect);
        }
    });
};


app.forms = {};

app.forms.submit = function(hash, method, url) {
    var postData = app.helpers.getFormData(hash);
    $.ajax({
        type: method,
        url: url,
        data: postData,
        success: function(data) {
            console.log(data);
        },
        error: function(err) {
            console.log(err)
        },
        dataType: 'JSON'
    });
};
//# sourceMappingURL=app.js.map
