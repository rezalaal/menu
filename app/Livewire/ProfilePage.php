<?php

namespace App\Livewire;


use App\Notifications\SendOtpViaSms;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProfilePage extends Component
{
    public $showNamePrompt = false;
    public $realName = '';

    public function mount()
    {
        if (auth()->check()) {
            $user = auth()->user();
            if ($user->name === $user->username) {
                $this->showNamePrompt = true;
            }else{
                $this->realName = $user->name;
            }
        }
    }

    public function saveName()
    {
        $this->validate([
            'realName' => 'required|string|min:2',
        ]);

        $user = auth()->user();
        $user->name = $this->realName;
        $user->save();

        $this->showNamePrompt = false;

        try {
            $user->notify(new SendOtpViaSms($user->username, 'welcome'));
        }catch(\Exception $e) {
            info($e->getMessage());
        }
    }

    public function logoff()
    {
        Auth::logout();
        return redirect()->to('/table/1');
    }

    public  function orders()
    {
        return redirect()->to('orders');
    }

    public function render()
    {
        return view('livewire.profile-page')->layout('components.layouts.pwa');
    }
}
