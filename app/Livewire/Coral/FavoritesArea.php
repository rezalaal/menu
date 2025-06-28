<?php

namespace App\Livewire\Coral;

use Livewire\Component;

class FavoritesArea extends Component
{
    public $favoritesCount = 0;

    public function mount()
    {
        $this->loadFavoritesCount();
    }

    public function loadFavoritesCount()
    {
        $user = auth()->user();

        if ($user) {
            $this->favoritesCount = $user->favorites()->count();
        } else {
            $this->favoritesCount = 0;
        }
    }

    protected $listeners = ['favorite-updated' => 'loadFavoritesCount'];

    public function render()
    {
        return view('livewire.coral.favorites-area');
    }
}
