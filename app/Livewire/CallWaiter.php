<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\WaiterCalled;

class CallWaiter extends Component
{
    public $tableId;

    public function mount():void
    {
        $this->tableId = Session::get('tableId');
    }

    public function notifyWaiter(): void
    {
        if (!$this->tableId) {
            $this->dispatch('alert', message: 'لطفاً بارکد روی میز را اسکن کنید.');
            return;
        }

        event(new WaiterCalled($this->tableId));
        $this->dispatch('alert', message: "گارسون برای میز شماره {$this->tableId} صدا زده شد.");
    }

    public function render():View
    {
        if (!Auth::check() || !$this->tableId) {
            return view('livewire.empty');
        }

        return view('livewire.call-waiter');
    }
}
