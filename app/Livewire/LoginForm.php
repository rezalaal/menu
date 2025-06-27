<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\SendOtpViaSms;
use Livewire\Component;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Cache;

class LoginForm extends Component
{

    #[Validate(['otp' => 'required|digits:5'],message:[
        'required' => 'کد تایید الزامی است',
        'digits' => 'کد تایید ۵ رقمی است'
    ])]
    public $otp;

    #[Validate(['mobile' => 'required|regex:/^09[0-9]{9}$/'],message:[
        'required' => 'شماره تلفن همراه خود را وارد کنید',
        'regex' => 'شماره تلفن وارد شده نامعتبر است'
    ])]
    public $mobile;
    public $step = 'showForm';

    public function mount()
    {
        if(auth()->user()) {
            return redirect()->to('/');
        }
    }


    public function SendOtp()
    {
        $this->validateOnly('mobile');

        $mobile = $this->mobile;
        if (config('app.env') === 'production') {
            // بررسی تعداد دفعات ارسال در یک ساعت اخیر
            $cacheKey = "otp_attempts_{$mobile}";
            $attempts = Cache::get($cacheKey, 0);

            if ($attempts >= 3) {
                $this->addError('mobile', "شما بیش از حد مجاز درخواست ارسال کد داشته‌اید. لطفاً بعداً دوباره تلاش کنید.");
                return;
            }
        }
        // بررسی کد فعال در session
        $existingOtp = session('otp');

        if (
            $existingOtp &&
            $existingOtp['mobile'] === $mobile &&
            now()->lessThan($existingOtp['expires_at'])
        ) {
            $this->addError('mobile', 'کد تأیید قبلاً ارسال شده است. لطفاً کمی صبر کنید.');
            $this->step = "showForm";
            return;
        }

        $otpCode = random_int(10000, 99999);

        session([
            'otp' => [
                'code' => $otpCode,
                'mobile' => $mobile,
                'expires_at' => now()->addMinutes(2),
            ]
        ]);

        if (config('app.env') === 'production') {
            // افزایش شمارش دفعات ارسال
            Cache::put($cacheKey, $attempts + 1, now()->addHour());
        }
        $user = User::checkUsername($mobile);

        if (config('app.env') === 'production') {
            try {
                $user->notify(new SendOtpViaSms($otpCode));
                info("sent otp ".$otpCode." to ".$user->username);
            }catch(\Exception $e) {
                $this->addError('otp', $e->getMessage());
                info($e->getMessage());
            }
        }else{
            info($otpCode);
        }

        $this->step = "confirmCode";

    }

    public function verify()
    {
        $this->validateOnly('otp');
        $sessionOtp = session('otp');

        if (!$sessionOtp) {
            $this->addError('otp', 'کد منقضی شده است. لطفاً دوباره درخواست دهید.');
            return;
        }

        if (now()->greaterThan($sessionOtp['expires_at'])) {
            session()->forget('otp');
            $this->addError('otp', 'کد منقضی شده است.');
            return;
        }

        if ($this->otp != $sessionOtp['code']) {
            $this->addError('otp', 'کد وارد شده نادرست است.');
            return;
        }


        $this->step = "loggedIn";

        if (!session()->has('tableId')) {
            session()->put('tableId', 1);
        }


        auth()->login(User::where('username', $sessionOtp['mobile'])->first());

        session()->forget('otp');
        $this->addError('otp', 'با موفقیت وارد شدید. کمی صبر کنید');
        // return redirect()->route('home');

    }

    public function render()
    {

        switch($this->step) {
            case "showForm":
                return view('livewire.login-form');
                break;
            case "confirmCode":
                return view('livewire.confirm-code');
                break;
            case "loggedIn":
                return view('livewire.redirect');
                break;
            default:
                return view('livewire.login-form');
        }
    }
}
