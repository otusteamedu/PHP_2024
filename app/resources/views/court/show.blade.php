@extends('layouts.main')
@section('content')
<div>
    <div>
        ID: {{ $court->id }}
    </div>
    <div>
        Наименование: {{ $court->name }}
    </div>
    <div>
        Регион: {{ optional($court->region)->title }}
    </div>
    <div>
        Адрес: {{ $court->address }}
    </div>
    <div>
        Телефон: {{ $court->phone }}
    </div>
    <div>
        Email: {{ $court->email }}
    </div>
    <div>
        Сайт: <a class="nav-link d-inline" href="{{ $court->site }}">{{ $court->site }}</a>
    </div>
    <br>
    <div class="">

        <form action="{{ route('court.destroy', $court->id) }}" method="post">
            @csrf
            @method('delete')
            <a class="btn btn-primary d-inline" href="{{ route('court.index') }}">Назад</a>
            <a class="btn btn-primary d-inline" href="{{ route('court.edit', $court->id) }}">Редактировать</a>
            <button type="submit" class="btn btn-primary">Удалить</button>
        </form>
    </div>
</div>
@endsection