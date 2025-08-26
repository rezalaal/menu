<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Notifications\SendOtpViaSms;

class AuthController extends Controller
{
    public function sendOtp(Request $request)
    {
        // 1. اعتبارسنجی ورودی
        $request->validate([
            'mobile' => ['required', 'regex:/^09\d{9}$/'], // فقط شماره موبایل ایران
        ]);

        $mobile = $request->mobile;

        info("Send OTP via API: ". $mobile);
        // 2. محدودیت تعداد دفعات در محیط production
        if (config('app.env') === 'production') {
            $cacheKey = "otp_attempts_{$mobile}";
            $attempts = Cache::get($cacheKey, 0);

            if ($attempts >= 3) {
                return response()->json([
                    'message' => 'شما بیش از حد مجاز درخواست ارسال کد داشته‌اید. لطفاً بعداً دوباره تلاش کنید.'
                ], 429);
            }
        }

        // 3. بررسی کد فعال در session
        $existingOtp = session('otp');

        if (
            $existingOtp &&
            $existingOtp['mobile'] === $mobile &&
            now()->lessThan($existingOtp['expires_at'])
        ) {
            return response()->json([
                'message' => 'کد تأیید قبلاً ارسال شده است. لطفاً کمی صبر کنید.'
            ], 429);
        }

        // 4. تولید کد OTP
        $otpCode = random_int(10000, 99999);

        // 5. ذخیره در session (یا بهتر: در DB/Redis)
        session([
            'otp' => [
                'code' => $otpCode,
                'mobile' => $mobile,
                'expires_at' => now()->addMinutes(2),
            ]
        ]);

        // 6. افزایش شمارش دفعات ارسال
        if (config('app.env') === 'production') {
            Cache::put($cacheKey, $attempts + 1, now()->addHour());
        }

        // 7. بررسی کاربر
        $user = User::checkUsername($mobile);

        // 8. ارسال SMS
        if (config('app.env') === 'production') {
            try {
                $user->notify(new SendOtpViaSms($otpCode));
                info("sent otp ".$otpCode." to ".$user->username);
            } catch (\Exception $e) {
                info($e->getMessage());
                return response()->json([
                    'message' => 'خطا در ارسال پیامک',
                    'error'   => $e->getMessage()
                ], 500);
            }
        } else {
            // در محیط توسعه، کد در لاگ چاپ میشه
            info("OTP for {$mobile}: {$otpCode}");
        }

        // 9. پاسخ موفق
        return response()->json([
            'message' => 'کد تأیید ارسال شد',
            'expires_in' => 120 // ثانیه
        ]);
    }

    public function verifyOtp(Request $request)
    {
        // 1. اعتبارسنجی ورودی
        $request->validate([
            'mobile' => ['required', 'regex:/^09\d{9}$/'],
            'otp'    => ['required', 'digits:5'],
        ]);

        info("Verify OTP via API: ". $request->mobile);
        // 2. گرفتن کد ذخیره‌شده در session
        $sessionOtp = session('otp');

        if (!$sessionOtp) {
            return response()->json([
                'message' => 'کد منقضی شده است. لطفاً دوباره درخواست دهید.'
            ], 422);
        }

        // 3. بررسی تاریخ انقضا
        if (now()->greaterThan($sessionOtp['expires_at'])) {
            session()->forget('otp');
            return response()->json([
                'message' => 'کد منقضی شده است.'
            ], 422);
        }

        // 4. بررسی صحت کد
        if ($request->otp != $sessionOtp['code'] || $request->mobile != $sessionOtp['mobile']) {
            return response()->json([
                'message' => 'کد وارد شده نادرست است.'
            ], 422);
        }

        // 5. ورود کاربر
        $user = User::where('username', $sessionOtp['mobile'])->first();
        if (!$user) {
            // اگر وجود نداشت، می‌تونیم کاربر جدید بسازیم
            $user = User::create([
                'username' => $sessionOtp['mobile'],
                'password' => bcrypt(str()->random(16)), // رمز رندوم
            ]);
        }

        // 6. صدور توکن (Sanctum)
        $token = $user->createToken('auth_token')->plainTextToken;

        // 7. پاک کردن OTP
        session()->forget('otp');

        // 8. پاسخ موفق
        return response()->json([
            'message' => 'با موفقیت وارد شدید.',
            'token'   => $token,
            'user'    => $user->username
        ]);
    }

}
