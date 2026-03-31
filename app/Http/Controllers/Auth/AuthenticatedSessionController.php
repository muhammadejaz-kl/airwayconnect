<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Carbon;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        $request->session()->regenerate();

        $user = auth()->user();
 
        if (is_null($user->email_verified_at)) {
            $otp = random_int(100000, 999999);

            DB::table('password_otps')->updateOrInsert(
                ['email' => $user->email],
                [
                    'otp' => $otp, 'created_at' => now(),
                ]
            );

            try {
                Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($user) {
                    $message->to($user->email)->subject('Verify Your Account - OTP Code');
                });

                $maskedEmail = substr($user->email, 0, 1)
                    . str_repeat('*', strpos($user->email, '@') - 1)
                    . substr($user->email, strpos($user->email, '@'));
 
                auth()->logout();

                return redirect()->route('register.verify', ['email' => $user->email])->with('status', "OTP sent to $maskedEmail");
            } catch (\Exception $e) {
                Log::error("OTP mail error for {$user->email}: {$e->getMessage()}");

                auth()->logout();

                return redirect()->route('login')->withErrors(['email' => 'OTP could not be sent. Please try again later.']);
            }
        }
 
        if ($user->hasRole('admin')) {
            return redirect()->intended(route('admin.dashboard'));
        } elseif ($user->hasRole('user')) {
            return redirect()->intended(route('user.dashboard'));
        }

        return redirect()->intended('/');
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
