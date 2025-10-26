<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class SimpleUpload extends Component
{
    use WithFileUploads;
    public $photo;

    public function updatedPhoto()
    {
        info("photo uploaded");
    }


    public function render()
    {
        return view('livewire.simple-upload');
    }
}
