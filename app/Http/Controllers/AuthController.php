<?php

namespace App\Http\Controllers;

use App\Models\OtpCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'locale' => $request->session()->get('locale', config('app.locale')),
        ]);

        $otp = OtpCode::create([
            'user_id' => $user->id,
            'code' => (string) random_int(100000, 999999),
            'expires_at' => now()->addMinutes(5),
        ]);

        $request->session()->put('pending_user_id', $user->id);

        return redirect()->route('otp.show')->with('otp_code', $otp->code);
    }

    public function showOtp(Request $request)
    {
        $userId = $request->session()->get('pending_user_id');

        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::findOrFail($userId);
        $otp = $user->otpCodes()->latest()->first();

        return view('auth.otp', [
            'user' => $user,
            'otp' => $otp,
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $data = $request->validate([
            'code' => ['required', 'string'],
        ]);

        $userId = $request->session()->get('pending_user_id');

        if (!$userId) {
            return redirect()->route('register');
        }

        $user = User::findOrFail($userId);

        $otp = $user->otpCodes()
            ->where('code', $data['code'])
            ->whereNull('used_at')
            ->where('expires_at', '>', now())
            ->latest()
            ->first();

        if (!$otp) {
            return back()->withErrors([
                'code' => __('messages.otp_invalid'),
            ]);
        }

        $otp->update(['used_at' => now()]);
        $user->update(['otp_verified_at' => now()]);
        Auth::login($user);
        $request->session()->forget('pending_user_id');

        return redirect()->route('home')->with('status', __('messages.otp_verified'));
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $data = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'string'],
        ]);

        if (!Auth::attempt($data)) {
            return back()->withErrors([
                'email' => __('messages.invalid_credentials'),
            ]);
        }

        $request->session()->regenerate();

        $user = $request->user();

        if (!$user->otp_verified_at) {
            Auth::logout();
            return back()->withErrors([
                'email' => __('messages.otp_required'),
            ]);
        }

        if ($user->is_blocked) {
            Auth::logout();
            return back()->withErrors([
                'email' => __('messages.account_blocked'),
            ]);
        }

        return redirect()->route('home');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
