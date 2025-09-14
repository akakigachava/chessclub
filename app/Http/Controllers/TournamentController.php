<?php

namespace App\Http\Controllers;

use App\Models\Tournament;
use App\Models\TournamentRegistration;
use Illuminate\Http\Request;

class TournamentController extends Controller
{
    public function register(Request $request, Tournament $tournament)
    {
        $user = $request->user();

        if ($tournament->isUserRegistered($user->id)) {
            return back()->withErrors(['message' => 'You are already registered for this tournament.']);
        }

        TournamentRegistration::create([
            'user_id' => $user->id,
            'tournament_id' => $tournament->id,
        ]);

        return back()->with('success', 'Successfully registered for the tournament!');
    }

    public function unregister(Request $request, Tournament $tournament)
    {
        $user = $request->user();

        $registration = TournamentRegistration::where([
            'user_id' => $user->id,
            'tournament_id' => $tournament->id,
        ])->first();

        if ($registration) {
            $registration->delete();
            return back()->with('success', 'Successfully unregistered from the tournament.');
        }

        return back()->withErrors(['message' => 'You are not registered for this tournament.']);
    }
}