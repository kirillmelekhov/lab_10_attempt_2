<?php

namespace App\Http\Controllers;

use App\Models\MasterClass;
use App\Models\MasterClassRegistration;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function confirm(MasterClass $masterClass, Request $request): View|RedirectResponse
    {
        $user = $request->user();

        if (! $user || ! $user->isVisitor()) {
            return redirect()->route('login')
                ->with('status', 'Для записи нужно войти как посетитель.');
        }

        $masterClass->load(['creativeType', 'leader'])->loadCount('registrations');

        if ($masterClass->participants()->where('user_id', $user->id)->exists()) {
            return redirect()
                ->route('creative-types.show', $masterClass->creativeType)
                ->with('status', 'Вы уже записаны на этот мастер-класс.');
        }

        if ($masterClass->isFull()) {
            return redirect()
                ->route('creative-types.show', $masterClass->creativeType)
                ->with('status', 'Свободных мест больше нет.');
        }

        return view('master-classes.confirm-booking', compact('masterClass', 'user'));
    }

    public function store(MasterClass $masterClass, Request $request): RedirectResponse
    {
        $user = $request->user();
        abort_unless($user?->isVisitor(), 403);

        $masterClass->load('creativeType')->loadCount('registrations');

        if ($masterClass->participants()->where('user_id', $user->id)->exists()) {
            return redirect()
                ->route('creative-types.show', $masterClass->creativeType)
                ->with('status', 'Повторная запись на тот же мастер-класс невозможна.');
        }

        if ($masterClass->isFull()) {
            return redirect()
                ->route('creative-types.show', $masterClass->creativeType)
                ->with('status', 'Запись невозможна: свободных мест нет.');
        }

        MasterClassRegistration::create([
            'master_class_id' => $masterClass->id,
            'user_id' => $user->id,
        ]);

        return redirect()
            ->route('creative-types.show', $masterClass->creativeType)
            ->with('status', 'Запись подтверждена.');
    }

    public function cancel(MasterClass $masterClass): RedirectResponse
    {
        return redirect()
            ->route('creative-types.show', $masterClass->creativeType)
            ->with('status', 'Запись отменена.');
    }
}
