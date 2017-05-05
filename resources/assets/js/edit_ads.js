/**
 * @globals selectpicker, fileinput
 */
$(function() {
    //app.categories.init();

    var imagesPreview = [];
    var imagesConfig = [];
    var hash = app.helpers.hash();

    for (var i = 0; i < window.pictures[0].length; i++) {
        var image = '/uploads/' + window.pictures[0][i];
        imagesPreview.push(image);

        var obj = {};

        obj.key = window.pictures[0][i];
        obj.url = '/ads/imageDelete';
        obj.caption = window.pictures[0][i];
        imagesConfig.push(obj);
    }

    var editOptions = jQuery.extend(true, {}, app.options.getFileInputSettings(hash));
    editOptions.initialPreview = imagesPreview;
    editOptions.initialPreviewConfig = imagesConfig;
    editOptions.overwriteInitial = false;

    $('.upload-image').fileinput(editOptions)
        .on('filebatchuploadsuccess', function(event, data) {

            app.forms.submit(hash, 'PUT', '/ads/' + app.helpers.getAdsId());
        });

    $('.submit-btn').on('click', function(e) {
        $('.upload-image').fileinput('upload');
    });
});