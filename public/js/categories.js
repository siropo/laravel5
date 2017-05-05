/**
 * @globals selectpicker
 */
app.categories = {};

app.categories.init = function() {
    var _this = this;

    $.ajax('getcategories')
        .done(function(data) {
            console.log(data);
            _this.renderCategories(data);
        }).fail(function(err) {
        console.log(err);
    });
};

/**
 *
 * @param data
 */
app.categories.renderCategories = function(data) {
    var $categories = $('.categories-root');
    for (var root in data) {
        var option = $('<option value="' + data[root].id + '">' +
            data[root].name + '</option>');
        $categories.append(option);
    }
    $categories.selectpicker({
        size: 8
    });
}

//# sourceMappingURL=categories.js.map
