<?php

namespace App\Livewire\Coral;

use Livewire\Component;

class UserArea extends Component
{
    public function profile()
    {
        return redirect()->to("/profile");
    }
    public function render()
    {
        return view('livewire.coral.user-area');
    }
}
