<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;


class RatingController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'approved')
        ->orderBy('rating', 'desc')
        ->get();
        
        return Inertia::render('Ranking/Index', [
            'users' => $users
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'rating' => 'required|numeric|min:0'
        ]);
     
        $user->update($validated);

        return redirect()->back()->with('success', 'User updated successfully');
    }

    public function destroy(User $user)
    {
        try {

            if ($user->role === 'admin') {
                return back()->with('error', 'ადმინისტრატორის წაშლა შეუძლებელია');
            }

            $userName = $user->name;
            $user->delete();

            return back()->with('success', "წევრი {$userName} წარმატებით წაიშალა");
        
        } catch (\Exception $e) {
            return back()->with('error', 'წევრის წაშლისას მოხდა შეცდომა');
        }
    }
}