@extends('layouts.main')
@section('content')
<form action="{{ route('court.store') }}" method="post">
    @csrf
    <div class="container">
        <div class="row">
            <div class="col mb-3">
                <input type="text" class="form-control" id="courtName" name="name" value="{{ old('name') }}">
                <label for="courtName" class="form-label">Наименование суда</label>
                @error('name')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="mb-3">
                <input type="text" class="form-control" id="courtAddress" name="address" value="{{ old('address') }}">
                <label for="courtAddress" class="form-label">Адрес суда</label>
                @error('address')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <select class="form-select" aria-label="select for court region" id="courtRegion" name="region_id">
                    <option value="" selected>Выберите регион суда</option>
                    @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ old('region_id') == $region->id ? 'selected' : '' }}>{{ $region->title }}</option>
                    @endforeach
                </select>
                <label for="courtRegion" class="form-label">Регион суда</label>
                @error('region_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col mb-3">
                <select class="form-select" aria-label="select for court cassation region" id="courtCassRegion" name="cass_region" value="{{ old('cass_region') }}">
                    <option value="" selected>Выберите кассационный округ суда</option>
                    <option {{ old('cass_region') == '1КО' ? 'selected' : '' }}>1КО</option>
                    <option {{ old('cass_region') == '2КО' ? 'selected' : '' }}>2КО</option>
                    <option {{ old('cass_region') == '3КО' ? 'selected' : '' }}>3КО</option>
                    <option {{ old('cass_region') == '4КО' ? 'selected' : '' }}>4КО</option>
                    <option {{ old('cass_region') == '5КО' ? 'selected' : '' }}>5КО</option>
                    <option {{ old('cass_region') == '6КО' ? 'selected' : '' }}>6КО</option>
                    <option {{ old('cass_region') == '7КО' ? 'selected' : '' }}>7КО</option>
                    <option {{ old('cass_region') == '8КО' ? 'selected' : '' }}>8КО</option>
                </select>
                <label for="courtCassRegion" class="form-label">Кассационный округ</label>
                @error('cass_region')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col mb-3">
                <select class="form-select" aria-label="select for court general_type" id="courtGeneralType" name="general_type_id">
                    <option value="" selected>Выберите тип суда</option>
                    @foreach($general_types as $general_type)
                    <option value=" {{ $general_type->id }}" {{ old('general_type_id') == $general_type->id ? 'selected' : '' }}>{{ $general_type->title }}</option>
                    @endforeach
                </select>
                <label for="courtGeneralType" class="form-label">Тип суда</label>
                @error('general_type_id')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="row">
            <div class="col mb-3">
                <input type="text" class="form-control" id="courtPhone" name="phone" value="{{ old('phone') }}">
                <label for="courtPhone" class="form-label">Телефон суда</label>
                @error('phone')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col mb-3">
                <input type="text" class="form-control" id="courtEmail" name="email" value="{{ old('email') }}">
                <label for="courtEmail" class="form-label">Email суда</label>
                @error('email')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
            <div class="col mb-3">
                <input type="text" class="form-control" id="courtSite" name="site" value="{{ old('site') }}">
                <label for="courtSite" class="form-label">Сайт суда</label>
                @error('site')
                <p class="text-danger">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">Добавить</button>
        </div>
    </div>
</form>
@endsection