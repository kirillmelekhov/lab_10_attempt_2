@extends('layouts.app')

@section('title', $creativeType->name)

@section('content')
    <div class="main">
        <div class="row">
            <div class="hover"></div>
            <div class="title">{{ $creativeType->name }}</div>
            <div class="row--small grid between">
                <div class="content">
                    <img src="{{ asset($creativeType->image_path) }}" alt="{{ $creativeType->name }}" class="category-image">
                    <p>{{ $creativeType->description }}</p>
                </div>
                <ul class="menu">
                    @foreach($menuCreativeTypes as $menuType)
                        <li>
                            <a href="{{ route('creative-types.show', $menuType) }}">{{ $menuType->name }}</a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <div class="row shedule">
                <div class="row--small">
                    <h2>Расписание</h2>

                    @forelse($masterClasses as $masterClass)
                        <div class="driver grid driver-card">
                            <div class="driver-left grid">
                                <div class="driver-photo">
                                    <img src="{{ asset($masterClass->leader->photo_path ?? 'assets/img/driver1.png') }}" alt="{{ $masterClass->leader->name }}">
                                </div>
                                <div class="driver-text">
                                    <div class="driver-name">{{ $masterClass->leader->name }}</div>
                                    <div class="driver-desc">
                                        <strong>{{ $masterClass->title }}</strong><br>
                                        {{ $masterClass->description }}
                                        <div class="driver-meta">Стоимость: {{ number_format((float) $masterClass->price, 0, ',', ' ') }} ₽</div>
                                        <div class="driver-meta">Свободных мест: {{ $masterClass->getFreePlaces() }} из {{ $masterClass->max_participants }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="driver-right">
                                @auth
                                    @if(auth()->user()->isVisitor())
                                        @if($masterClass->participants->contains(auth()->id()))
                                            <button class="driver-btn" disabled>вы записаны</button>
                                        @elseif($masterClass->isFull())
                                            <button class="driver-btn" disabled>мест нет</button>
                                        @else
                                            <a href="{{ route('master-classes.confirm-booking', $masterClass) }}" class="driver-btn button-link">
                                                записаться
                                            </a>
                                        @endif
                                    @endif
                                @endauth
                                <div class="driver-time">
                                    {{ $masterClass->session_date->format('d.m.Y') }}<br>
                                    {{ str_replace(' - ', ' / ', $masterClass->getSlotLabel()) }}
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="empty-state">Пока нет запланированных мастер-классов.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
