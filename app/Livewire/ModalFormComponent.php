<?php

namespace App\Livewire;

use Livewire\Component;

class ModalFormComponent extends Component
{

    public $modalId;
    public $name;
    public $field1Name;
    public $field2Name;
    public $field3Name;
    public $field1 = '';
    public $field2 = '';
    public $field3 = '';
    public $modelClass;
    public $savedField=0;

    public function mount($modalId, $name, $field1Name, $field2Name, $field3Name, $modelClass)
    {
        $this->modalId = $modalId;
        $this->name = $name;
        $this->field1Name = $field1Name;
        $this->field2Name = $field2Name;
        $this->field3Name = $field3Name;
        $this->modelClass = $modelClass->modelClass;
    }

    public function save(){
        $field = new $this->modelClass;
        $field->name = $this->field1Name;
        $field->display_name = $this->field2Name;
        $field->description = $this->field3Name;
        $this->savedField = $field->save();
        if ($this->savedField) {
            $this->reset();
            // $this->dispatch('Up')->to(UserListComponent::class);
            $this->js("alert('Updated!')");
        }

    }

    public function render()
    {
        return view('livewire.modal-form-component');
    }
}
