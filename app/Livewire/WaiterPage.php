<?php

namespace App\Livewire;

use Livewire\Component;

class WaiterPage extends Component
{
    public $notification = '';

    protected $listeners = ['waiterCalled' => 'showNotification'];

    public function showNotification($tableId)
    {
        $this->notification = "گارسون برای میز شماره {$tableId} صدا زده شد!";
    }

    public function render()
    {
        return view('livewire.waiter-page');
    }
}

