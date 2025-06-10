<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\OneTimePasswords\Models\OneTimePassword;

class ConsumeOneTimePasswordComponent extends Component
{
    public string $username = '';
    public string $oneTimePassword = '';

    public function mount()
    {
        $this->username = session('otp_username', ''); // از سشن قبلی می‌گیریم
    }

    public function submitOneTimePassword()
    {
        $this->validate([
            'oneTimePassword' => ['required'],
        ]);

        $user = User::where('username', $this->username)->first();

        if (! $user) {
            session()->flash('error', 'کاربر یافت نشد.');
            return;
        }

        if (! OneTimePassword::for($user)->isValid($this->oneTimePassword)) {
            session()->flash('error', 'کد وارد شده معتبر نیست.');
            return;
        }

        // ورود موفق
        Auth::login($user);

        session()->forget('otp_username');

        return redirect()->intended(route('home'));
    }

    public function resendCode()
    {
        $user = User::where('username', $this->username)->first();

        if ($user) {
            OneTimePassword::for($user)->send();
            session()->flash('success', 'کد جدید ارسال شد.');
        }
    }

    public function render()
    {
        return view('vendor.one-time-passwords.components.one-time-password-form');
    }
}
