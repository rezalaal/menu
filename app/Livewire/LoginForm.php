<?php

namespace App\Livewire;

use App\Models\User;
use App\Notifications\SendOtpViaSms;
use Livewire\Component;
use Livewire\Attributes\Validate;

class LoginForm extends Component
{

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
        $this->validate();

        $user = User::checkUsername($this->mobile);
        $user->notify(new SendOtpViaSms(12345));

        $this->codeSent = true;
    }

    public function login()
    {
        session()->put('tableId', 1);
        return redirect()->to('/');
    }

    public function render()
    {
        if ($this->codeSent) {
            return view('livewire.confirm-code');
        }
        return view('livewire.login-form');
    }
}
