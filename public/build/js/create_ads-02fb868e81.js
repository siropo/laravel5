$(function() {

    app.categories.init();
    var imagePrefix = app.helpers.getImageTitlePrefix();

    $('.upload-image').fileinput().on('filebatchuploadsuccess', function(event, data) {
            app.forms.submit(imagePrefix);
        }
    );

    $('.submit-btn').on('click', function(e) {
        $('.upload-image').fileinput('upload');
    });
});
//# sourceMappingURL=create_ads.js.map
