@extends('layouts.app')

@section('content')
    <div class="panel-heading">{{ $ads->title }}</div>
    <div class="panel-body">
        <article>

            <p>{{ $ads->body }}</p>
            @foreach($pictures as $picture)
                <img src="/uploads/{{ $picture }}" alt="">
            @endforeach
        </article>
    </div>
@stop