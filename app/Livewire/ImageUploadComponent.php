<?php

namespace App\Livewire;

use App\Models\StaffImages;
use Livewire\Component;
use Livewire\Attributes\Validate;

class ImageUploadComponent extends Component
{

    protected function imageBlobUpload($file, $id)
    {
        $imageBlob = $file;
        $imgBlob = new StaffImages();
        $imgBlob->img_blob = $imageBlob;
        $imgBlob->uid = $id;
        $imgSaved = $imgBlob->save();
        return $imgSaved;
    }

    protected function imageBlobUpdate($file, $id)
    {
        $imageBlob = $file;
        $updateImageBlob = StaffImages::where('uid', $id)->first() ? StaffImages::where('uid', $id)->update(['img_blob' => $imageBlob]) : $this->imageBlobUpload($file, $id);
        return $updateImageBlob;
    }


    public $savedpicture;
    public $uid;
    public $xyz;

    public function mount($uid = null)
    {
        $this->uid = $uid;
    }


    public function save()
    {
        return [$this->xyz, $this->savedpicture];
        // $this->imageBlobUpdate($this->image, $this->uid) ? $this->js("alert('User Added Successfully!')") : $this->js("alert('Something Went Wrong!')");
    }

    public function render()
    {

        return view('livewire.image-upload-component');
    }
}
