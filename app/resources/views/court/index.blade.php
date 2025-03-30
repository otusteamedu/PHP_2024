@extends('layouts.main')
@section('content')
<div>
    <ol>
        @foreach($courts as $court)
        <li>
            <a class="nav-link" href="{{ route('court.show', $court->id) }}">{{ $court->name }}</a>
        </li>
        @endforeach

        <div class="mt-3">
            {{ $courts->withQueryString()->links() }}
        </div>
    </ol>
</div>

<style>
    ol {
        list-style-type: decimal !important;
        padding-inline-start: 40px !important;
    }
</style>

@endsection