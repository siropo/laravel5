<meta name="csrf-token" content="{{ csrf_token() }}"/>
<div class="form-group">
    <p class="bg-danger error-message">hfg</p>
    <div> {!! Form::label('title', 'Title') !!}</div>
    <div> {!! Form::text('title', null, ['class' => 'form-control']) !!}</div>
</div>
<div class="form-group wrapper-categories">
    <p class="bg-danger error-message">hfg</p>
    @if (isset($ads))
        <div id="cat-name">{!! $ads->category_name !!}</div>
        <button type="button" id="change-category" class="btn btn-primary">change</button>
        <input type="hidden" name="category_id" id="hidden-cat-field" value="{!! $ads->id !!}"/>
        <script>
            $(function() {
                $('#change-category').on('click', function() {
                    var $categories = $('<select name="category_id" class="categories-root level0"></select>');
                    $('#hidden-cat-field').remove();
                    $('#cat-name').remove();
                    $(this).remove();
                    $('.wrapper-categories').append($categories);
                    app.categories.init();
                });
            })
        </script>
    @else
        <select name="category_id" class="categories-root level0">

        </select>
    @endif
</div>
<div class="form-group">
    <br>
    <p class="bg-danger error-message error-category">hfg</p>
    <div>{!! Form::label('body', 'body') !!}</div>
    <div>{!! Form::textarea('body', null, ['class' => 'form-control']) !!}</div>
</div>
<div class="form-group">
    <p class="bg-danger error-message">hfg</p>
    <div> {!! Form::label('type_id', 'Type') !!}</div>
    <div> {!! Form::text('type_id', null, ['class' => 'form-control']) !!}</div>
</div>
<div class="form-group">
    <p class="bg-danger error-message error-upload">Please select a picture</p>
    <div>{!! Form::label('uploadImages', 'Select Image') !!}</div>
    <div><input id="uploadImages" name="uploadImages[]" type="file" multiple class="file-loading upload-image"></div>
</div>

<div class="form-group">
    {!! Form::hidden('published_at', date('Y-m-d'), ['class' => 'form-control']) !!}
    {!! Form::hidden('type_id', '1') !!}
    {!! Form::button($submitBtn, ['class' => 'btn btn-primary form-control submit-btn']) !!}
</div>

