<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class LeaderCabinetController extends Controller
{
    public function __invoke(Request $request): View
    {
        $leader = $request->user();

        $masterClasses = $leader->ledMasterClasses()
            ->with(['creativeType', 'participants'])
            ->withCount('registrations')
            ->orderBy('session_date')
            ->orderBy('slot_time')
            ->get();

        return view('pages.leader-cabinet', compact('leader', 'masterClasses'));
    }
}
