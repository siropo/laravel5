@extends('layouts.app')

@section('content')
    <div class="panel-heading">{{ $article->title }}</div>
    <div class="panel-body">
        <article>

            <p>{{ $article->body }}</p>
            <h5>tags</h5>
            <ul>
                @foreach($article->tags as $tag)
                    <li>{!! $tag->name !!}</li>
                @endforeach
            </ul>
        </article>
    </div>
@stop