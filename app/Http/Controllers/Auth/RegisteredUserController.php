<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'phone_code' => ['required', 'string'],
            'phone_number' => ['required', 'string', 'unique:users,phone_number'],
        ], [
            'phone_number.unique' => 'The phone number has already been taken.',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_code' => '+' . $request->phone_code,
            'phone_number' => $request->phone_number,
        ]);

        $user->assignRole('user');
        event(new Registered($user));

        $otp = random_int(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            [
                'otp' => $otp, 'created_at' => now(),
            ]
        );

        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email)->subject('Your Account Verification OTP');
            });

            $maskedEmail = substr($request->email, 0, 1)
                . str_repeat('*', strpos($request->email, '@') - 1)
                . substr($request->email, strpos($request->email, '@'));

            return redirect()->route('register.verify', ['email' => $request->email])->with('status', "OTP sent to $maskedEmail");

        } catch (\Exception $e) {
            Log::error("OTP mail error for {$request->email}: {$e->getMessage()}");
            return redirect()->route('register.verify', ['email' => $request->email])->with('status', "OTP could not be sent. Please check logs.");
        }
    }

    public function verifyForm(Request $request)
    {
        return view('auth.verify-register-otp', ['email' => $request->email]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'code' => 'required|digits:6',
        ]);

        $record = DB::table('password_otps')->where('email', $request->email)->where('otp', $request->code)->first();

        if (!$record || now()->diffInMinutes($record->created_at) > 10) {
            return back()->withErrors(['code' => 'Invalid or expired OTP'])->with('email', $request->email);
        }

        $user = User::where('email', $request->email)->first();

        if (is_null($user->email_verified_at)) {
            $user->email_verified_at = now();
            $user->save();
        }

        DB::table('password_otps')->where('email', $request->email)->delete();

        Auth::login($user);

        return redirect()->route('user.dashboard')->with('status', 'Account verified & logged in!');
    }

    /**
     * Re-send OTP
     */
    public function resendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $otp = random_int(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            ['email' => $request->email],
            ['otp' => $otp, 'created_at' => now()]
        );

        try {
            Mail::send('emails.otp', ['otp' => $otp], function ($message) use ($request) {
                $message->to($request->email)->subject('Your Account Verification OTP');
            });

            return back()->with('status', 'A new OTP has been sent to your email.');
        } catch (\Exception $e) {
            return back()->withErrors(['code' => 'Failed to send OTP. Try again later.']);
        }
    }

}
