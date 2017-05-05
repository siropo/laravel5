@extends('layouts.app')

@section('content')
    <div class="panel-heading">Articles</div>
    <div class="panel-body">
        @foreach($articles as $article)
            <article>
                <h2><a href="{{ action('ArticleController@show', [$article->id]) }}">{{ $article->title }}</a></h2>
                <p>{{ $article->body }}</p>
            </article>
        @endforeach
    </div>
@stop