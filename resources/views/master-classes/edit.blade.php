@extends('layouts.app')

@section('title', 'Редактирование мастер-класса')

@section('content')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
    <div class="main">
        <div class="row">
            <div class="row--small">
                <form action="{{ route('master-classes.update', $masterClass) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <h2>Редактирование мастер-класса</h2>
                    <div class="form-group">
                        <label>Вид творчества</label>
                        <input type="text" value="{{ $masterClass->creativeType->name }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Название мастер-класса</label>
                        <input type="text" value="{{ $masterClass->title }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Дата и время</label>
                        <input type="text" value="{{ $masterClass->session_date->format('d.m.Y') }} / {{ $masterClass->getSlotLabel() }}" disabled>
                    </div>
                    <div class="form-group">
                        <label for="description">Описание мастер-класса</label>
                        <textarea id="description" name="description" minlength="20" maxlength="2000" required>{{ old('description', $masterClass->description) }}</textarea>
                        @error('description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Стоимость</label>
                        <input id="price" type="number" min="0.01" max="99999999.99" step="0.01" name="price" value="{{ old('price', $masterClass->price) }}" required>
                        @error('price')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn" type="submit">Сохранить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
