<?php

namespace App\Livewire;

use Livewire\Component;

class Back extends Component
{
    public $modal = null;
    public $to = null;

    public function goBack()
    {
        if ($this->modal) {
            // به فرانت اعلام کن که مودال رو ببنده
            $this->dispatch('close-modal', $this->modal);
        }

        if ($this->to) {
            // ریدایرکت به مسیر مورد نظر
            return redirect($this->to);
        }
    }

    public function render()
    {
        return view('livewire.back');
    }
}
