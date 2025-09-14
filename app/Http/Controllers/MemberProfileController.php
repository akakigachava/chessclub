<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Tournament;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class MemberProfileController extends Controller
{
    public function show(Request $request)
{
    $user = $request->user();
    
    $tournaments = Tournament::where('start_date', '>=', now())
        ->orderBy('start_date')
        ->withCount('registrations')
        ->withCount(['registrations as is_user_registered' => function($query) use ($user) {
            $query->where('user_id', $user->id);
        }])
        ->get()
        ->map(function($tournament) {
            return [
                'id' => $tournament->id,
                'name' => $tournament->name,
                'start_date' => $tournament->start_date,
                'location' => $tournament->location,
                'description' => $tournament->description,
                'registration_count' => $tournament->registrations_count,
                'is_user_registered' => (bool) $tournament->is_user_registered,
            ];
        });

    return Inertia::render('MemberProfile/Show', [
        'user' => $user,
        'tournaments' => $tournaments,
        'feeDeadline' => $this->calculateFeeDeadline($user), // or use $user->fee_deadline if available
        'qrCodeUrl' => route('member.qrcode', $user)
    ]);
}

    public function qrCode(User $user)
    {
        if (Auth::id() !== $user->id) {
            abort(403, 'Unauthorized');
        }

        $qrData = json_encode([
            'member_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'status' => $user->status ?? 'active',
            'generated_at' => now()->toISOString()
        ]);

        $qrCode = QrCode::format('png')
            ->size(200)
            ->margin(2)
            ->generate($qrData);

        return response($qrCode, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'inline; filename="member-qr-code.png"');
    }

    private function calculateFeeDeadline($user)
    {
        if ($user->fee_paid_at) {
            return Carbon::parse($user->fee_paid_at)->addYear()->toDateTimeString();
        }
        
        if (isset($user->status) && $user->status === 'approved') {
            return Carbon::parse($user->updated_at)->addDays(30)->toDateTimeString();
        }
        
        return now()->addDays(30)->toDateTimeString();
    }
}