<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\SendOtpViaSms;
use Livewire\Component;
use Livewire\Attributes\Validate;

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

    public $codeSent = false;

    public function mount()
    {
        if(auth()->user()) {
            return redirect()->to('/');
        }
    }

    public function SendOtp()
    {

        $this->validateOnly('mobile');
        $otpCode = random_int(10000, 99999);
        session([
            'otp' => [
                'code' => $otpCode,
                'mobile' => $this->mobile,
                'expires_at' => now()->addMinutes(2),
            ]
        ]);
        $user = User::checkUsername($this->mobile);
        $user->notify(new SendOtpViaSms($otpCode));

        $this->codeSent = true;
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

        session()->forget('otp');
        session()->flash('message', 'کد تایید شد!');
        if (!session()->has('tableId')) {
            session()->put('tableId', 1);
        }


        auth()->login(User::where('mobile', $sessionOtp['mobile'])->first());
        return redirect()->route('home');

    }

    public function render()
    {
        if ($this->codeSent) {
            return view('livewire.confirm-code');
        }
        return view('livewire.login-form');
    }
}
