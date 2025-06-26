<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use App\Settings\GeneralSettings;
use Livewire\Attributes\Validate;
use Illuminate\Support\Facades\Auth;

class Table extends Component
{
    public $title;
    public $tableId;
    public $tableName;
    public $tableImageUrl;
    public $settings;
    public $loggedIn = false;
    public $tableVideoUrl;


    #[Validate(['mobile' => 'required|regex:/^09[0-9]{9}$/'],message:[
        'required' => 'شماره تلفن همراه خود را وارد کنید',
        'regex' => 'شماره تلفن وارد شده نامعتبر است'
    ])]
    public $mobile;


    public function mount($id, GeneralSettings $settings)
    {
        if(auth()->user()) {
            $this->loggedIn = true;
        }

        $this->tableId = $id;
        $table = \App\Models\Table::where('id', $this->tableId)->first();
        if(!$table) {
            return abort(404);
        }

        session()->put('tableId', $this->tableId);

        if($table->getFirstMediaUrl() == null){
            $this->tableImageUrl = config('app.url').'/images/table.jpg';
        }else{
            $this->tableImageUrl = $table->getFirstMediaUrl();
        }

        $videoUrl = $table->getFirstMediaUrl('videos');
        $this->tableVideoUrl = $videoUrl ?: null;


        $this->tableName = $table->name ?? '';
        $this->title .= " به کورال فود خوش آمدید :: ". $this->tableName;
        $this->settings = [
            'title' => $settings->init_site_name,
            'instagram' => $settings->instagram_id,
            'mobile' => $settings->master_mobile
        ];
    }

    public function login()
    {
        if(auth()->user()) {
            return redirect()->to('/');
        }

        $this->validate();

        User::checkUsername($this->mobile);
        $this->loggedIn = true;
        $this->dispatch('login-successful', mobile: $this->mobile);
        return redirect()->to('/');
    }


    public function logoff()
    {
        Auth::logout();
        $this->loggedIn = false;
    }

    public function render()
    {
        return view('livewire.table')->layout('components.layouts.pwa');
    }
}
