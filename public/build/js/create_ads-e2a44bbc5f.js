$(function() {

    app.categories.init();
    
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
            obj.clearTitle = app.helpers.getImageTitlePrefix();
            return obj;
        }
    }).on('change', function(event) {
        console.log("change");
    }).on('filepredelete', function(event, key) {
        console.log('Key = ' + key);
    }).on('filedeleted', function(event, key) {
        console.log('Key = ' + key);
    }).on('filecleared', function(event) {
        console.log("filecleared");
    }).on('fileclear', function(event) {
        console.log("fileclear");
    }).on('fileuploaded', function(event, data, previewId, index) {
        console.log('single ', data);
        console.log(previewId);
        console.log(index);
    }).on('filebatchuploadsuccess', function(event, data) {

            var files = [];
            $('.file-preview-image').each(function() {
                files.push($(this).attr('title'));
            });

            console.log(files);
            var formData = $('.create-form').serializeArray();
            var postData = {};
            formData.map(function(key) {
                postData[key.name] = key.value;
                
            });
            postData.pictures = [];
            for (var i = 0; i < files.length; i++) {
                postData.pictures.push(app.helpers.getImageTitlePrefix() + files[i]);
            }
            console.log(postData);
            $.ajax({
                type: "POST",
                url: '/ads',
                data: postData,
                success: function(data) {
                    console.log(data);
                },
                error: function(err) {
                    console.log(err)
                },
                dataType: 'JSON'
            });
            $('.create-form').submit();
        }
    );

    $('.submit-btn').on('click', function(e) {

        $('.upload-image').fileinput('upload');
        // console.log($('.create-form').serialize());

        /// $('.upload-image').fileinput('refresh');
        var files = $('.upload-image').fileinput('getFileStack');
        //console.log(files);
        //$('.create-form').submit();
    });
});
//# sourceMappingURL=create_ads.js.map
