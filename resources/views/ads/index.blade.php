@extends('layouts.app')

@section('content')
    <div class="panel-heading">Ads</div>
    <div class="panel-body">
        @foreach($ads as $ad)
            <article>
                <h2><a href="{{ action('AdsController@show', [$ad->id]) }}">{{ $ad->title }}</a></h2>
                <p>{{ $ad->body }}</p>
            </article>
        @endforeach

    </div>
@stop