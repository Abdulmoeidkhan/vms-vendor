<?php

namespace App\Livewire;

use App\Models\CompanyCategory;
use Livewire\Component;
use ReflectionClass;

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
    public $className;

    public function mount($modalId, $name, $field1Name, $field2Name, $field3Name, $className)
    {
        $this->modalId = $modalId;
        $this->name = $name;
        $this->field1Name = $field1Name;
        $this->field2Name = $field2Name;
        $this->field3Name = $field3Name;
        switch ($className) {
            case "CompanyCategory":
                $this->className = CompanyCategory::class;
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
    }

    public function render()
    {
        return view('livewire.modal-form-component');
    }
}
