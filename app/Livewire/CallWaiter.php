<?php
namespace App\Livewire;

use Livewire\Component;
use App\Models\Table;
use Illuminate\Support\Facades\Session;

class CallWaiter extends Component
{
    public ?Table $table = null;

    public function mount(): void
    {
        $tableId = Session::get('tableId');
        if ($tableId) {
            $this->table = Table::find($tableId);
        }
        
    }

    public function callWaiter(): void
    {
        if ($this->table && !$this->table->called_waiter) {
            $this->table->called_waiter = true;
            $this->table->save();
        }
    }

    public function render()
    {
        return view('livewire.call-waiter');
    }
}
