<?php

namespace App\Http\Controllers;

use App\Models\CreativeType;
use Illuminate\Contracts\View\View;

class CreativeTypeController extends Controller
{
    public function show(CreativeType $creativeType): View
    {
        $creativeType->load([
            'masterClasses' => function ($query): void {
                $query
                    ->with(['leader', 'participants'])
                    ->withCount('registrations')
                    ->whereDate('session_date', '>=', now()->toDateString())
                    ->orderBy('session_date')
                    ->orderBy('slot_time');
            },
        ]);

        return view('pages.creative-type', [
            'creativeType' => $creativeType,
            'masterClasses' => $creativeType->masterClasses,
        ]);
    }
}
