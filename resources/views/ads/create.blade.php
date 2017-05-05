@extends('layouts.app')

@section('content')
    <div class="panel-heading">Create</div>
    <div class="panel-body">
        {!! Form::open(['url' => 'ads', 'files'=> true, 'class' => 'create-form']) !!}
        @include('ads._form', ['submitBtn' => 'add Ads'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>
    <script src="{{ elixir('js/create_ads.js') }}"></script>
@stop


