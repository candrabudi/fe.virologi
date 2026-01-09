<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserDetail;
use App\Models\Otp;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|alpha_dash|unique:users',
            'email' => 'required|email|unique:users',
            'full_name' => 'required|string|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user',
            'status' => 'active',
        ]);

        $user->detail()->create([
            'full_name' => $request->full_name,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Akun taktis berhasil dibuat. Silakan masuk portal.',
            'redirect' => route('login')
        ]);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $user = User::where('username', $request->login)
                    ->orWhere('email', $request->login)
                    ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => 'Kredensial tidak valid.'
            ], 401);
        }

        if ($user->status !== 'active') {
            return response()->json([
                'success' => false,
                'message' => 'Akun Anda sedang ' . $user->status . '.'
            ], 403);
        }

        // Generate OTP
        $otpCode = (string) rand(100000, 999999);
        
        Otp::create([
            'user_id' => $user->id,
            'code_hash' => Hash::make($otpCode),
            'code_last4' => substr($otpCode, -4),
            'purpose' => 'login',
            'expires_at' => Carbon::now()->addMinutes(5),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        try {
            Mail::to($user->email)->send(new OtpMail($otpCode));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengirim kode verifikasi. Silakan coba lagi nanti.'
            ], 500);
        }
        
        session(['otp_user_id' => $user->id]);

        return response()->json([
            'success' => true,
            'message' => 'Kode verifikasi telah dikirim ke ' . $user->email,
            'redirect' => route('auth.verify-otp')
        ]);
    }

    public function showVerifyOtp()
    {
        if (!session()->has('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'otp' => 'required|string|size:6',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        $userId = session('otp_user_id');
        $user = User::find($userId);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Sesi kedaluwarsa. Silakan masuk kembali.',
                'redirect' => route('login')
            ], 401);
        }

        $otpRecord = Otp::where('user_id', $user->id)
                        ->where('purpose', 'login')
                        ->whereNull('verified_at')
                        ->where('expires_at', '>', Carbon::now())
                        ->latest()
                        ->first();

        if (!$otpRecord || !Hash::check($request->otp, $otpRecord->code_hash)) {
            return response()->json([
                'success' => false,
                'message' => 'Kode verifikasi tidak valid atau kedaluwarsa.'
            ], 401);
        }

        $otpRecord->update(['verified_at' => Carbon::now()]);

        $user->update(['last_login_at' => Carbon::now()]);
        Auth::login($user);
        
        session()->forget('otp_user_id');

        return response()->json([
            'success' => true,
            'message' => 'Izin keamanan diberikan. Selamat datang kembali, ' . $user->username,
            'redirect' => route('dashboard')
        ]);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('success', 'Sesi berhasil diakhiri.');
    }
}
