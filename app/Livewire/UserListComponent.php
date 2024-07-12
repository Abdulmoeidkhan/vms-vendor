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

    #[On('addUser')]
    public function render()
    {
        $this->users = User::with('roles')->where('id', '!=', Auth::user()->id)->get();
        foreach ($this->users as $key => $user) {
            $this->users[$key]->organizationName = $this->users[$key]->roles[0]->display_name == 'OrgRep' ? Organization::where('uid', $user->uid)->first('company_name') : '';
        }
        return view('livewire.user-list-component');
    }
}
