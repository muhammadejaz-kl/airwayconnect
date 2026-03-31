<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class PasswordResetLinkController extends Controller
{
    /**
     * Display the password reset link request view.
     */
    public function create(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle an incoming password reset link request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email', 'exists:users,email'],
        ]);

        $otp = random_int(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp,
                'created_at' => now(),
            ]
        );

        try {
            Mail::send('emails.password-otp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email)
                    ->subject('Your Password Reset OTP');
            });

            $maskedEmail = substr($request->email, 0, 1)
                . str_repeat('*', strpos($request->email, '@') - 1)
                . substr($request->email, strpos($request->email, '@'));

            return redirect()->route('password.verify', ['email' => $request->email])
                ->with('status', "OTP sent to $maskedEmail");
        } catch (\Exception $e) {
            Log::info("Password reset OTP for {$request->email}: {$otp}");

            return redirect()->route('password.verify', ['email' => $request->email])
                ->with('status', "OTP could not be sent via email.");
        }
    }

    public function verify(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code'  => 'required|digits:6',
        ]);

        $record = DB::table('password_otps')
            ->where('email', $request->email)
            ->where('otp', $request->code)
            ->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 10) {
            return back()->withErrors(['code' => 'Invalid or expired OTP']);
        }

        return redirect()->route('password.reset.form', ['email' => $request->email]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = bcrypt($request->password);
        $user->save();

        DB::table('password_otps')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Password reset successfully!');
    }
}
