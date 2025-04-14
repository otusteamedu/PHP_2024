@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card">
            @include('youtubechannels.blocks.header.index')
            <div class="card-body">
                @include('youtubechannels.blocks.list.index')
            </div>
        </div>
    </div>
@stop
