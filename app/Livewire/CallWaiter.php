<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Events\WaiterCalled;

class CallWaiter extends Component
{
    public $tableId;

    public function mount()
    {
        $this->tableId = Session::get('tableId');
    }

    public function call()
    {
        if (!$this->tableId) {
            $this->dispatchBrowserEvent('alert', ['message' => 'لطفاً بارکد روی میز را اسکن کنید.']);
            return;
        }

        // Broadcast event
        event(new WaiterCalled($this->tableId));

        $this->dispatchBrowserEvent('alert', ['message' => "گارسون برای میز شماره {$this->tableId} صدا زده شد."]);
    }

    public function render()
    {
        if (!Auth::check()) {
            return view('livewire.empty'); // یک view خالی بسازید بهتره
        }

        return view('livewire.call-waiter');
    }
}
