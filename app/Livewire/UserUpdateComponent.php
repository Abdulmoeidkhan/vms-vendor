<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class UserUpdateComponent extends Component
{
    public $userStatus;
    public $user;
    public function statusUpdate($status)
    {
        User::where('uid', $this->user->uid)->update(['status' => $status]);
        $updatedUser = User::where('uid', $this->user->uid)->first();
        $this->dispatch('userStatusUpdate')->to(UserStatusComponent::class);
        $this->userStatus = $updatedUser->status;
    }

    public function render()
    {
        return view('livewire.user-update-component');
    }
}
