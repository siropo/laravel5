@extends('layouts.app')

@section('content')
    {{ $first }}
    {{ $second }}

    @if ($first == 'Viktor')
        <h1>hi</h1>
    @else
        <h1>End</h1>
    @endif

    <ul>
        @foreach($people as $person)
            <li>{{ $person }}</li>
        @endforeach
    </ul>
@stop