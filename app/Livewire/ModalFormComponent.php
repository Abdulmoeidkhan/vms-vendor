<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\Attributes\Lazy;

#[Lazy]
class ModalFormComponent extends Component
{

    public $modalId = '';
    public $name = '';
    public $field1 = '';
    public $field2 = '';
    public $field3 = '';
    public $className = '';
    public $colorClass = '';
    public $oldData = '';

    public function mount($modalId, $name, $className, $colorClass, $oldData)
    {
        $this->modalId = $modalId;
        $this->name = $name;
        $this->className = $className;
        $this->$colorClass = $colorClass;
        $this->$oldData = $oldData;
    }

    public function placeholder()
    {
        return <<<'HTML'
                <div class="mb-3">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="mb-3">
                            <label class="form-label">Company {{$name}} </label>
                            <select class="form-select">
                                <option value="" selected disabled hidden> Select Company
                                    {{$name}}
                                </option>
                            </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                        <div class="mb-3">
                            <label class="form-label">Add {{$name}}</label>
                            <button type="button" class="btn btn-{{$colorClass}}">+</button>
                        </div>
                        </div>
                    </div>  
                </div>
        HTML;
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
