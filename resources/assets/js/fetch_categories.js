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

