<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

class UserStatusComponent extends Component
{
    public $userStatus;
    public $user;

    #[On('userStatusUpdate')]
    public function render()
    {
        $updatedUser = User::where('uid', $this->user->uid)->first();
        $this->userStatus = $updatedUser->status;
        return view('livewire.user-status-component');
    }
}
