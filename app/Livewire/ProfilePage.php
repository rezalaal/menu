<?php

namespace App\Livewire;


use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class ProfilePage extends Component
{
  
    public function logoff()
    {
        Auth::logout();
    }

    public function render()
    {
        return view('livewire.profile-page');
    }
}
