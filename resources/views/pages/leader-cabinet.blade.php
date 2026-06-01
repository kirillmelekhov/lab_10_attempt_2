@extends('layouts.app')

@section('title', 'Личный кабинет')
@section('body_class', 'dp')

@section('content')
    <div class="main">
        <div class="row">
            <div class="hover"></div>
            <div class="title title--empty">&nbsp;</div>
            <div class="row--small grid between">
                <div class="content driver-page">
                    <div class="driver-page-photo">
                        <img src="{{ asset($leader->photo_path ?? 'assets/img/driver-page.png') }}" alt="{{ $leader->name }}">
                    </div>
                    <div class="driver-page-name">{{ $leader->name }}</div>
                    <div class="driver-page-text">
                        <div class="driver-page-my">Мои мастер-классы</div>
                        @if($masterClasses->isEmpty())
                            <p>Пока у вас нет созданных мастер-классов.</p>
                        @else
                            <table class="driver-page-table full-width-table">
                                <tbody>
                                    @foreach($masterClasses as $masterClass)
                                        <tr>
                                            <td>
                                                {{ $masterClass->session_date->format('d.m.Y') }}<br>
                                                {{ str_replace(' - ', ' / ', $masterClass->getSlotLabel()) }}
                                            </td>
                                            <td>
                                                <strong>{{ $masterClass->title }}</strong><br>
                                                <span class="cabinet-subtitle">{{ $masterClass->creativeType->name }}</span><br>
                                                <div class="cabinet-description">
                                                    {{ $masterClass->description }}
                                                </div>
                                                Стоимость: {{ number_format((float) $masterClass->price, 0, ',', ' ') }} ₽<br>
                                                Участников: {{ $masterClass->registrations_count }} / {{ $masterClass->max_participants }}<br>
                                                <div class="cabinet-actions">
                                                    <a href="{{ route('master-classes.edit', $masterClass) }}" class="btn cabinet-edit-link">Редактировать</a>
                                                </div>
                                                <div class="participants-list">
                                                    @forelse($masterClass->participants as $index => $participant)
                                                        {{ $index + 1 }}. {{ $participant->name }} ({{ $participant->email }})<br>
                                                        тел: {{ $participant->phone ?? 'не указан' }}<br>
                                                    @empty
                                                        Пока никто не записался.
                                                    @endforelse
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                    <div class="driver-page-btn-wrapper">
                        <a href="{{ route('master-classes.create') }}" class="driver-page-btn btn">
                            Добавить мастер-класс
                        </a>
                    </div>
                </div>
                <ul class="menu">
                    @foreach($menuCreativeTypes as $menuType)
                        <li>
                            <a href="{{ route('creative-types.show', $menuType) }}">{{ $menuType->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection
