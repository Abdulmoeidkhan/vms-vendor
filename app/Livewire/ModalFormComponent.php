<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;

class ModalFormComponent extends Component
{

    public $modalId;
    public $name;
    public $field1 = '';
    public $field2 = '';
    public $field3 = '';
    public $className;
    public $colorClass;
    public $oldData;

    public function mount($modalId, $name, $className, $colorClass, $oldData)
    {
        $this->modalId = $modalId;
        $this->name = $name;
        $this->className = $className;
        $this->$colorClass = $colorClass;
        $this->$oldData = $oldData;
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
            $this->pull(['field1', 'field2', 'field3']);
        } else {
            $this->js("alert('SomeThing Went Wrong!')");
        }
    }

    #[On('category-updated')]
    public function render()
    {
        $categories = $this->className::all();
        return view('livewire.modal-form-component', ['categories' => $categories]);
    }
}
