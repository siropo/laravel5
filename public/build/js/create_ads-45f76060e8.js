$(function() {

    app.categories.init();
    var hash = app.helpers.hash();

    $('.upload-image').fileinput(app.options.getFileInputSettings(hash))
        .on('filebatchuploadsuccess', function(event, data) {
                app.forms.submit(hash, 'POST', '/ads');
            }
        );

    $('.submit-btn').on('click', function(e) {
        var pictures = app.helpers.getPictureData('file-footer-caption');
        var l;
        if (pictures.length === 0) {
            $('.error-upload').show();
            return;
        }

        $('.upload-image').fileinput('upload');
    });
});
//# sourceMappingURL=create_ads.js.map
