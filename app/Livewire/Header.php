<?php

namespace App\Livewire;

use Livewire\Component;
use App\Settings\GeneralSettings;

class Header extends Component
{
    public $title = 'Online Menu';
    public function mount(GeneralSettings $generalSettings)
    {
        $this->title = $generalSettings->init_site_name;
    }

    public function render()
    {
        return view('livewire.header');
    }
}
