<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Table;
use Illuminate\Support\Collection;

class WaiterPage extends Component
{
    public Collection $calledTables;

    public function mount(): void
    {
        $this->calledTables = collect();
    }

    public function getCalledTables(): void
    {
        $this->calledTables = Table::where('called_waiter', true)->get();
    }

    public function markAsHandled(int $tableId): void
    {
        $table = Table::find($tableId);
        if ($table) {
            $table->called_waiter = false;
            $table->save();
        }
    }

    public function render()
    {
        $this->getCalledTables();

        return view('livewire.waiter-page')->layout('components.layouts.pwa');
    }
}
