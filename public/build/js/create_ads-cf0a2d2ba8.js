$(function() {

    app.categories.init();
    var imagePrefix = app.helpers.getImageTitlePrefix();

    $('.upload-image').fileinput({
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
            obj.clearTitle = imagePrefix;
            return obj;
        }
    }).on('filebatchuploadsuccess', function(event, data) {
            
        app.forms.submit();
            
        }
    );

    $('.submit-btn').on('click', function(e) {
        $('.upload-image').fileinput('upload');
    });
});
//# sourceMappingURL=create_ads.js.map
