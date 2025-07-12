<?php

namespace App\Livewire\Coral;

use Livewire\Component;
use App\Settings\GeneralSettings;

class SettingsModal extends Component
{
    public string $section = ''; // مثلا 'about', 'work_hours', 'contact'
    public string $content = '';

    public function mount(string $section, GeneralSettings $settings)
    {
        $this->section = $section;

        switch ($section) {
            case 'about':               
                $this->content = $settings->about ?? 'توضیحاتی برای این بخش موجود نیست.';
                break;
            case 'work_hours':               
                $this->content = $settings->work_hours ?? 'ساعات کاری ثبت نشده است.';
                break;
            case 'contact':               
                $this->content = $settings->contact ?? 'اطلاعات تماس موجود نیست.';
                break;
            default:               
                $this->content = 'بخش مورد نظر یافت نشد.';
        }
    }

    public function render()
    {
        return view('livewire.coral.settings-modal');
    }
}

