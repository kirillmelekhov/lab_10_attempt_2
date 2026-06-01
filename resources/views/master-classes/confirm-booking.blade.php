@extends('layouts.app')

@section('title', 'Подтверждение записи')

@section('content')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
    <div class="main">
        <div class="row">
            <div class="row--small confirm-wrapper">
                <div class="confirm-card">
                    <h2>Подтверждение записи</h2>
                    <p><strong>Посетитель:</strong> {{ $user->name }}</p>
                    <p><strong>Вид творчества:</strong> {{ $masterClass->creativeType->name }}</p>
                    <p><strong>Мастер-класс:</strong> {{ $masterClass->title }}</p>
                    <p><strong>Ведущий:</strong> {{ $masterClass->leader->name }}</p>
                    <p><strong>Дата:</strong> {{ $masterClass->session_date->format('d.m.Y') }}</p>
                    <p><strong>Время:</strong> {{ $masterClass->getSlotLabel() }}</p>

                    <div class="confirm-actions">
                        <form action="{{ route('master-classes.book', $masterClass) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn">Подтвердить</button>
                        </form>
                        <form action="{{ route('master-classes.cancel-booking', $masterClass) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn">Отменить</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
