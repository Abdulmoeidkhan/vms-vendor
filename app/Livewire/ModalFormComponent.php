<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ModalFormComponent extends Component
{

    public $modalId;
    public $name;
    public $mykey;
    public $field1 = '';
    public $field2 = '';
    public $field3 = '';
    public $className;
    public $colorClass;
    public $title;

    public function mount($modalId, $name, $className, $mykey,$colorClass,$title)
    {
        $this->modalId = $modalId;
        $this->name = $name;
        $this->mykey = $mykey;
        $this->className = $className;
        $this->$colorClass = $colorClass;
        $this->$title = $title;
    }

    public function save()
    {
        $field = new $this->className;
        $field->name = $this->field1;
        $field->display_name = $this->field2;
        $field->description = $this->field3;
        $fieldSaved = $field->save();
        if ($fieldSaved) {
            $this->js("alert('Updated!')");
            $this->dispatch('category-updated')->self();
            $this->js("location.reload()");
        } else {
            $this->js("alert('SomeThing Went Wrong!')");
        }
    }

    #[On('category-updated')]
    public function render()
    {
        $data = $this->className::first();
        return view('livewire.modal-form-component', ['data' => $data]);
    }
}
