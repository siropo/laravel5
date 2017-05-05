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