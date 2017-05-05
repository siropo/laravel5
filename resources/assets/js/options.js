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