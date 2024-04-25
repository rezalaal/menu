<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\Attributes\Validate;

class LoginForm extends Component
{

    #[Validate(['mobile' => 'required|regex:/^09[0-9]{9}$/'],message:[
        'required' => 'شماره تلفن همراه خود را وارد کنید',
        'regex' => 'شماره تلفن وارد شده نامعتبر است'
    ])]
    public $mobile;
    

    public function login()
    {
        if(auth()->user()) {
            return redirect()->to('/');
        }

        $this->validate();
        
        User::checkUsername($this->mobile);

        session()->put('tableId', 1);
        return redirect()->to('/');
    }
    
    public function render()
    {
        return view('livewire.login-form');
    }
}
