<?php
namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Tournament;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function dashboard()
    {
        $pendingUsers = User::where('status', 'pending')->get();
        $approvedUsers = User::where('status', 'approved')->get();
        $tournaments = Tournament::where('start_date', '>=', now())->get();

        return Inertia::render('Admin/Dashboard', [
            'pendingUsers' => $pendingUsers,
            'approvedUsers' => $approvedUsers,
            'tournaments' => $tournaments,
        ]);
    }

    public function approve(User $user)
    {
        $user->update(['status' => 'approved']);
        return back()->with('success', 'User approved!');
    }

    public function reject(User $user)
    {
        $user->update(['status' => 'rejected']);
        return back()->with('success', 'User rejected!');
    }

    public function createTournament(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'location' => 'required|string',
            'description' => 'nullable|string',
        ]);

        Tournament::create($request->all());

        return back()->with('success', 'Tournament created!');
    }


    public function updateTournament(Request $request, Tournament $tournament)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'start_date' => 'required|date',
            'location' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
    
        $tournament->update([
            'name' => $request->name,
            'start_date' => $request->start_date,
            'location' => $request->location,
            'description' => $request->description,
        ]);
    
        return redirect()->back()->with('success', 'ტურნირი წარმატებით განახლდა!');
    }

    public function destroyTournament(Tournament $tournament)
    {
        $tournament->delete();
    
        return redirect()->back()->with('success', 'ტურნირი წარმატებით წაიშალა!');
    }

}