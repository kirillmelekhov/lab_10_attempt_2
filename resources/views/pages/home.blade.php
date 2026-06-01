@extends('layouts.app')

@section('title', 'Главная')

@section('content')
    <div class="main">
        <div class="row">
            <div class="hover"></div>
            <div class="title">Мастер-классы для творчества и вдохновения</div>
            <div class="row--small grid between home-layout">
                <div class="content">
                    <h2>О сервисе</h2>
                    <p>
                        Сервис помогает посетителям находить творческие мастер-классы, а ведущим —
                        формировать собственное расписание занятий. Все занятия проводятся по фиксированным
                        слотам: <strong>09:00 - 11:00</strong>, <strong>11:00 - 13:00</strong>,
                        <strong>13:00 - 15:00</strong>, <strong>15:00 - 17:00</strong>.
                    </p>
                    <p>
                        Выберите интересующее направление в меню справа и перейдите к расписанию. Для записи
                        на мастер-класс нужно войти или зарегистрироваться как посетитель.
                    </p>

                    @auth
                        @if(auth()->user()->isVisitor())
                            <div class="bookings-panel">
                                <h2>Мои записи</h2>
                                @if($userBookings->isEmpty())
                                    <p>Пока вы не записаны ни на один мастер-класс.</p>
                                @else
                                    <table class="driver-page-table bookings-table">
                                        <tbody>
                                            @foreach($userBookings as $booking)
                                                <tr>
                                                    <td>{{ $booking->session_date->format('d.m.Y') }}<br>{{ $booking->getSlotLabel() }}</td>
                                                    <td>
                                                        <strong>{{ $booking->title }}</strong><br>
                                                        Вид творчества: {{ $booking->creativeType->name }}<br>
                                                        Ведущий: {{ $booking->leader->name }}<br>
                                                        Свободных мест сейчас: {{ $booking->getFreePlaces() }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                @endif
                            </div>
                        @endif
                    @endauth
                </div>

                <ul class="menu">
                    @foreach($creativeTypes as $creativeType)
                        <li>
                            <a href="{{ route('creative-types.show', $creativeType) }}">
                                {{ $creativeType->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    <div class="row row--nogutter">
        <div class="line"></div>
    </div>

    <div class="main">
        <div class="row">
            <div class="row--small info-grid">
                <div class="section-block">
                    <h2>Виды творчества</h2>
                    <div class="cards-grid">
                        @foreach($creativeTypes as $creativeType)
                            <a class="type-card" href="{{ route('creative-types.show', $creativeType) }}">
                                <img src="{{ asset($creativeType->image_path) }}" alt="{{ $creativeType->name }}">
                                <div class="type-card__body">
                                    <div class="type-card__title">{{ $creativeType->name }}</div>
                                    <div class="type-card__meta">
                                        Ближайших мастер-классов: {{ $creativeType->upcoming_master_classes_count }}
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="section-block">
                    <h2>Ближайшие занятия</h2>
                    <div class="cards-grid cards-grid--classes">
                        @foreach($featuredMasterClasses as $masterClass)
                            <div class="type-card type-card--class">
                                <div class="type-card__body">
                                    <div class="type-card__title">{{ $masterClass->title }}</div>
                                    <div class="type-card__meta">{{ $masterClass->creativeType->name }}</div>
                                    <p>
                                        {{ $masterClass->session_date->format('d.m.Y') }},
                                        {{ $masterClass->getSlotLabel() }}<br>
                                        Ведущий: {{ $masterClass->leader->name }}
                                    </p>
                                    <a class="btn type-card__button" href="{{ route('creative-types.show', $masterClass->creativeType) }}">
                                        К расписанию
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
