<?php

namespace App\Livewire;


use App\Models\Organization;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Lazy;

#[Lazy]
class UserListComponent extends Component
{
    public $users;

    public function mount()
    {
        $this->users = User::with('roles')->where('id', '!=', Auth::user()->id)->get();
    }

    #[On('addUser')]
    public function render()
    {
        // $this->users->companyName = $this->users->roles[0]->display_name == 'OrgRep' ? Organization::where('uid', $this->users->uid)->get('company_name') : '';
        return view('livewire.user-list-component');
    }
}
