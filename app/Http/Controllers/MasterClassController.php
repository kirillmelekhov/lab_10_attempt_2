<?php

namespace App\Http\Controllers;

use App\Models\CreativeType;
use App\Models\MasterClass;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MasterClassController extends Controller
{
    private const MAX_PRICE = 99999999.99;

    public function create(Request $request): View
    {
        $creativeTypes = CreativeType::query()->orderBy('name')->get();
        $occupiedSlots = $this->buildOccupiedSlotsMap($request->user()->ledMasterClasses()->get());

        return view('master-classes.create', [
            'creativeTypes' => $creativeTypes,
            'availableSlots' => MasterClass::AVAILABLE_SLOTS,
            'occupiedSlots' => $occupiedSlots,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'creative_type_id' => ['required', 'exists:creative_types,id'],
            'title' => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'session_date' => ['required', 'date', 'after_or_equal:today'],
            'slot_time' => ['required', Rule::in(array_keys(MasterClass::AVAILABLE_SLOTS))],
            'max_participants' => ['required', 'integer', 'min:1', 'max:50'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:'.self::MAX_PRICE],
        ], [
            'creative_type_id.required' => 'Выберите вид творчества.',
            'title.required' => 'Введите название мастер-класса.',
            'title.min' => 'Название мастер-класса должно содержать минимум 5 символов.',
            'description.required' => 'Введите описание мастер-класса.',
            'description.min' => 'Описание мастер-класса должно содержать минимум 20 символов.',
            'description.max' => 'Описание мастер-класса не должно превышать 2000 символов.',
            'session_date.required' => 'Выберите дату.',
            'session_date.after_or_equal' => 'Нельзя создать мастер-класс на прошедшую дату.',
            'slot_time.required' => 'Выберите временной слот.',
            'slot_time.in' => 'Можно использовать только слоты 09:00, 11:00, 13:00 или 15:00.',
            'max_participants.required' => 'Укажите количество мест в группе.',
            'price.required' => 'Укажите стоимость мастер-класса.',
            'price.min' => 'Стоимость мастер-класса должна быть больше 0.',
            'price.max' => 'Стоимость мастер-класса не должна превышать 99 999 999,99.',
        ]);

        $leader = $request->user();

        $alreadyTaken = $leader->ledMasterClasses()
            ->whereDate('session_date', $validated['session_date'])
            ->whereTime('slot_time', $validated['slot_time'])
            ->exists();

        if ($alreadyTaken) {
            return back()
                ->withErrors(['slot_time' => 'Этот слот уже занят другим вашим мастер-классом.'])
                ->withInput();
        }

        MasterClass::create([
            ...$validated,
            'leader_id' => $leader->id,
        ]);

        return redirect()->route('leader.cabinet')
            ->with('status', 'Мастер-класс успешно добавлен.');
    }

    public function edit(MasterClass $masterClass, Request $request): View
    {
        abort_unless($masterClass->leader_id === $request->user()->id, 403);

        $masterClass->load(['creativeType', 'leader']);

        return view('master-classes.edit', [
            'masterClass' => $masterClass,
        ]);
    }

    public function update(MasterClass $masterClass, Request $request): RedirectResponse
    {
        abort_unless($masterClass->leader_id === $request->user()->id, 403);

        $validated = $request->validate([
            'description' => ['required', 'string', 'min:20', 'max:2000'],
            'price' => ['required', 'numeric', 'min:0.01', 'max:'.self::MAX_PRICE],
        ], [
            'description.required' => 'Введите описание мастер-класса.',
            'description.min' => 'Описание мастер-класса должно содержать минимум 20 символов.',
            'description.max' => 'Описание мастер-класса не должно превышать 2000 символов.',
            'price.required' => 'Укажите стоимость мастер-класса.',
            'price.min' => 'Стоимость мастер-класса должна быть больше 0.',
            'price.max' => 'Стоимость мастер-класса не должна превышать 99 999 999,99.',
        ]);

        $masterClass->update($validated);

        return redirect()->route('leader.cabinet')
            ->with('status', 'Мастер-класс обновлен.');
    }

    private function buildOccupiedSlotsMap($masterClasses): array
    {
        return $masterClasses
            ->groupBy(fn (MasterClass $masterClass) => Carbon::parse($masterClass->session_date)->format('Y-m-d'))
            ->map(fn ($items) => $items
                ->map(fn (MasterClass $masterClass) => Carbon::parse($masterClass->slot_time)->format('H:i:s'))
                ->values()
                ->all())
            ->all();
    }
}
