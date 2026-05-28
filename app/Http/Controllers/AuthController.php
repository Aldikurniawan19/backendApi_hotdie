<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PasswordResetOtp;
use App\Mail\OtpMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Registrasi berhasil',
            'data'    => [
                'user'  => $user,
                'token' => $token,
            ],
        ], 201);
    }

    /**
     * Login an existing user.
     */
    public function login(Request $request)
    {
        $request->validate([
            'email'    => 'required|string|email',
            'password' => 'required|string',
        ]);

        $user = User::where('email', $request->email)->first();

        \Log::info('Login attempt', [
            'email' => $request->email,
            'password_attempted' => $request->password,
            'user_found' => $user ? true : false,
        ]);

        if (! $user || ! Hash::check($request->password, $user->password)) {
            \Log::warning('Login failed', ['email' => $request->email]);
            throw ValidationException::withMessages([
                'email' => ['Email atau password salah.'],
            ]);
        }

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'status'  => 'success',
            'message' => 'Login berhasil',
            'data'    => [
                'user'  => $user,
                'token' => $token,
            ],
        ], 200);
    }

    /**
     * Logout the authenticated user (revoke current token).
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Logout berhasil',
        ], 200);
    }

    /**
     * Get the authenticated user profile.
     */
    public function profile(Request $request)
    {
        return response()->json([
            'status' => 'success',
            'data'   => [
                'user' => $request->user(),
            ],
        ], 200);
    }

    /**
     * Update the authenticated user profile.
     */
    public function updateProfile(Request $request)
    {
        $request->validate([
            'name'     => 'sometimes|string|max:255',
            'email'    => 'sometimes|string|email|max:255|unique:users,email,' . $request->user()->id,
            'phone'    => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
        ]);

        $user = $request->user();
        $user->update($request->only(['name', 'email', 'phone', 'location']));

        return response()->json([
            'status'  => 'success',
            'message' => 'Profil berhasil diperbarui',
            'data'    => [
                'user' => $user->fresh(),
            ],
        ], 200);
    }

    /**
     * Send OTP code for password reset.
     */
    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Email tidak ditemukan.',
            ], 404);
        }

        // Invalidate any previous OTPs for this email
        PasswordResetOtp::where('email', $request->email)
            ->where('used', false)
            ->update(['used' => true]);

        // Generate a random 4-digit OTP
        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        PasswordResetOtp::create([
            'email'      => $request->email,
            'otp'        => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // Kirim OTP via email
        try {
            Mail::to($request->email)->send(new OtpMail($otp));
        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Gagal mengirim email. Silakan coba lagi.',
            ], 500);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Kode OTP telah dikirim ke email Anda.',
        ], 200);
    }

    /**
     * Verify the OTP code.
     */
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'otp'   => 'required|string|size:4',
        ]);

        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->latest()
            ->first();

        if (! $otpRecord || ! $otpRecord->isValid()) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
            ], 422);
        }

        return response()->json([
            'status'  => 'success',
            'message' => 'Kode OTP valid.',
        ], 200);
    }

    /**
     * Reset the password using a verified OTP.
     */
    public function resetPassword(Request $request)
    {
        \Log::info('resetPassword called', ['email' => $request->email, 'otp' => $request->otp]);

        $request->validate([
            'email'                 => 'required|string|email',
            'otp'                   => 'required|string|size:4',
            'password'              => 'required|string|min:6|confirmed',
        ]);

        \Log::info('resetPassword validation passed', ['password_received' => $request->password]);

        // Verify OTP again
        $otpRecord = PasswordResetOtp::where('email', $request->email)
            ->where('otp', $request->otp)
            ->where('used', false)
            ->latest()
            ->first();

        if (! $otpRecord || ! $otpRecord->isValid()) {
            \Log::warning('OTP invalid', ['email' => $request->email, 'otp' => $request->otp]);
            return response()->json([
                'status'  => 'error',
                'message' => 'Kode OTP tidak valid atau sudah kedaluwarsa.',
            ], 422);
        }

        // Update password langsung via DB query (bypass Eloquent casts)
        $newHash = Hash::make($request->password);

        $updated = \DB::table('users')
            ->where('email', $request->email)
            ->update(['password' => $newHash]);

        \Log::info('Password updated', [
            'email'   => $request->email,
            'rows'    => $updated,
            'newHash' => substr($newHash, 0, 20) . '...',
        ]);

        // Mark OTP as used
        $otpRecord->update(['used' => true]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Password berhasil direset. Silakan login dengan password baru.',
        ], 200);
    }
}
