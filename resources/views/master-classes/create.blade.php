@extends('layouts.app')

@section('title', 'Добавление мастер-класса')

@section('content')
    <div class="row row--nogutter top-line">
        <div class="line"></div>
    </div>
    <div class="main">
        <div class="row">
            <div class="row--small">
                <form action="{{ route('master-classes.store') }}" method="POST">
                    @csrf
                    <h2>Форма добавления мастер-класса</h2>
                    <div class="form-group">
                        <label for="creative_type_id">Вид творчества</label>
                        <select id="creative_type_id" name="creative_type_id" required>
                            <option value="">Выберите вид творчества</option>
                            @foreach($creativeTypes as $creativeType)
                                <option value="{{ $creativeType->id }}" @selected(old('creative_type_id') == $creativeType->id)>
                                    {{ $creativeType->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('creative_type_id')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="title">Название мастер-класса</label>
                        <input id="title" type="text" name="title" value="{{ old('title') }}" minlength="5" maxlength="255" required>
                        @error('title')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="description">Описание мастер-класса</label>
                        <textarea id="description" name="description" minlength="20" maxlength="2000" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="session_date">Дата</label>
                        <input id="session_date" type="date" name="session_date" min="{{ now()->toDateString() }}" value="{{ old('session_date') }}" required>
                        @error('session_date')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="slot_time">Время</label>
                        <select id="slot_time" name="slot_time" required>
                            <option value="">Выберите слот</option>
                            @foreach($availableSlots as $value => $label)
                                <option value="{{ $value }}" @selected(old('slot_time') === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                        <div class="form-note">
                            Слоты фиксированные: 09:00 - 11:00, 11:00 - 13:00, 13:00 - 15:00, 15:00 - 17:00.
                        </div>
                        @error('slot_time')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="max_participants">Количество человек в группе</label>
                        <input id="max_participants" type="number" min="1" max="50" name="max_participants" value="{{ old('max_participants') }}" required>
                        @error('max_participants')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="price">Стоимость</label>
                        <input id="price" type="number" min="0.01" max="99999999.99" step="0.01" name="price" value="{{ old('price') }}" required>
                        @error('price')
                            <div class="form-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <button class="btn" type="submit">Отправить</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        const occupiedSlots = @json($occupiedSlots);
        const dateInput = document.getElementById('session_date');
        const slotSelect = document.getElementById('slot_time');

        const refreshSlots = () => {
            const busySlots = occupiedSlots[dateInput.value] ?? [];

            Array.from(slotSelect.options).forEach((option) => {
                if (!option.value) {
                    return;
                }

                option.disabled = busySlots.includes(option.value);
            });

            if (busySlots.includes(slotSelect.value)) {
                slotSelect.value = '';
            }
        };

        dateInput.addEventListener('change', refreshSlots);
        refreshSlots();
    </script>
@endsection
