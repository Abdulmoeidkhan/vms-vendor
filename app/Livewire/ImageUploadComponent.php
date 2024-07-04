<?php

namespace App\Livewire;

use App\Models\StaffImages;
use App\Models\CnicFront;
use App\Models\CnicBack;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;

class ImageUploadComponent extends Component
{
    use WithFileUploads;

    public $uid;
    public $savedpicture;
    public $picture;
    public $pictureToBeUpdate;
    public $title;
    public $name;
    public $dbClassCall;

    protected $listeners = [
        '$refresh'
    ];

    public function mount($uid = null, $title = null, $name = null)
    {
        $this->uid = $uid;
        $this->title = $title;
        $this->name = $name;
        $this->savedpicture = $name . '_savedpicture';
        switch ($name) {
            case "staff_picture":
                $this->dbClassCall = StaffImages::class;
                break;
            case "cnic_front_picture":
                $this->dbClassCall = CnicFront::class;
                break;
            case "cnic_back_picture":
                $this->dbClassCall = CnicBack::class;
                break;
            default:
                echo "Your favorite color is neither red, blue, nor green!";
        }
    }

    protected function imageBlobUpload($file, $uid)
    {
        $imageBlob = $file;
        $imgBlob = new $this->dbClassCall;
        $imgBlob->img_blob = $imageBlob;
        $imgBlob->uid = $uid;
        $imgSaved = $imgBlob->save();
        return $imgSaved;
    }

    protected function imageBlobUpdate($file, $uid)
    {
        $imageBlob = $file;
        $updateImageBlob = $this->dbClassCall::where('uid', $uid)->first() ? $this->dbClassCall::where('uid', $uid)->update(['img_blob' => $imageBlob]) : $this->imageBlobUpload($file, $uid);
        return $updateImageBlob;
    }

    public function save()
    {
        $this->imageBlobUpdate($this->savedpicture, $this->uid) ? $this->js("alert('Image Updated Successfully!')") : $this->js("alert('Something Went Wrong!')");
        $this->dispatch('image-updated')->self();
    }

    #[On('image-updated')]
    public function render()
    {
        $this->picture = $this->dbClassCall::where('uid', $this->uid)->first();
        return view('livewire.image-upload-component');
    }
}
