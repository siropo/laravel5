@extends('layouts.app')

@section('content')
    <div class="panel-heading">Create</div>
    <div class="panel-body">

        {!! Form::open(['url' => 'articles']) !!}
        @include('articles._form', ['submitBtn' => 'add Article'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>
@stop