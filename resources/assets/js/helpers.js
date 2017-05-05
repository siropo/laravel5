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