<?php

namespace App\Livewire;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;

class UserListComponent extends Component
{
    public $users;

    #[On('addUser')]
    public function render()
    {
        $this->users = User::with('roles')->where('id', '!=', Auth::user()->id)->get();
        return view('livewire.user-list-component');
    }
}
