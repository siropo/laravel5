<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Styles -->
    {!! Html::style('assets/bower_components/bootstrap/dist/css/bootstrap.min.css') !!}
    {!! Html::style('assets/bower_components/bootstrap-select/dist/css/bootstrap-select.min.css') !!}
    {!! Html::style('assets/bower_components/bootstrap-fileinput/css/fileinput.min.css') !!}
    <link rel="stylesheet" href="{{ elixir('css/all.css') }}">
    <!-- JavaScripts -->

    {!! Html::script('assets/bower_components/jquery/dist/jquery.min.js') !!}
    {!! Html::script('assets/bower_components/jquery-sortable/source/js/jquery-sortable-min.js') !!}
    {!! Html::script('assets/bower_components/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js') !!}
    {!! Html::script('assets/bower_components/bootstrap-fileinput/js/fileinput.min.js') !!}
    {!! Html::script('assets/bower_components/bootstrap/dist/js/bootstrap.min.js') !!}
    {!! Html::script('assets/bower_components/bootstrap-select/dist/js/bootstrap-select.min.js') !!}

    <script src="{{ elixir('js/app.js') }}"></script>
</head>
<body id="app-layout">
@include('particles.top_navigation')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                @include('particles.flash')
                @yield('content')
            </div>
        </div>
    </div>
</div>


<!-- JavaScripts -->

</body>
</html>
