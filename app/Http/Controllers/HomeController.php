<?php

namespace App\Http\Controllers;

use App\Models\CreativeType;
use App\Models\MasterClass;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __invoke(Request $request): View
    {
        $creativeTypes = CreativeType::query()
            ->withCount([
                'masterClasses as upcoming_master_classes_count' => function ($query): void {
                    $query
                        ->whereDate('session_date', '>=', now()->toDateString());
                },
            ])
            ->orderBy('name')
            ->get();

        $userBookings = collect();

        if ($request->user()?->isVisitor()) {
            $userBookings = $request->user()
                ->registeredMasterClasses()
                ->with(['creativeType', 'leader'])
                ->withCount('registrations')
                ->orderBy('session_date')
                ->orderBy('slot_time')
                ->get();
        }

        $featuredMasterClasses = MasterClass::query()
            ->with(['creativeType', 'leader'])
            ->withCount('registrations')
            ->whereDate('session_date', '>=', now()->toDateString())
            ->orderBy('session_date')
            ->orderBy('slot_time')
            ->limit(6)
            ->get();

        return view('pages.home', compact('creativeTypes', 'userBookings', 'featuredMasterClasses'));
    }
}
