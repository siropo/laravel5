@extends('layouts.app')

@section('content')
    <div class="panel-heading">Edit {!! $ads->title !!}</div>
    <div class="panel-body">
        {!! Form::model($ads, ['method' => 'PATCH', 'action' => ['AdsController@update', $ads->id]]) !!}
        {{--{!! Form::open(['method' => 'PATCH', 'url' => 'ads/' . $ads->id]) !!}--}}
        {!! Form::hidden('ads_id', $ads->id, ['id' => 'ads_id']) !!}
        @include('ads._form', ['submitBtn' => 'edit Ads'])
        {!! Form::close() !!}

        @include('errors.list')
    </div>
    <script>
        window.pictures = [<?php echo $ads->pictures; ?>];
    </script>
    <script src="{{ elixir('js/edit_ads.js') }}"></script>
@stop