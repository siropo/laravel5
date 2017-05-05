@extends('layouts.app')

@section('content')
    <div class="panel-heading">Edit {!! $article->title !!}</div>
    <div class="panel-body">
        {!! Form::model($article, ['method' => 'PATCH', 'action' => ['ArticleController@update', $article->id]]) !!}
        {{--{!! Form::open(['method' => 'PATCH', 'url' => 'articles/' . $article->id]) !!}--}}
        @include('articles._form', ['submitBtn' => 'edit Article'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>
@stop