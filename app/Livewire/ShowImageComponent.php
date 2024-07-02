<?php

namespace App\Livewire;

use App\Models\StaffImages;
use Livewire\Component;
use Livewire\Attributes\On;

class ShowImageComponent extends Component
{
    protected $listeners = [
        '$refresh'
    ];

    public $uid;
    public $picture;
    public function mount($uid = null)
    {
        $this->uid = $uid;
    }

    #[On('image-updated')]
    public function render()
    {
        $this->picture = StaffImages::where('uid', $this->uid)->first();
        return view('livewire.show-image-component');
    }
}
