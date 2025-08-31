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
    public function show()
    {
        $user = Auth::user();
        $tournaments = Tournament::where('start_date', '>=', now())
            ->orderBy('start_date')
            ->get();

        return Inertia::render('MemberProfile/Show', [
            'user' => $user,
            'tournaments' => $tournaments,
            'feeDeadline' => $this->calculateFeeDeadline($user),
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