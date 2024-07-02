<?php

namespace App\Livewire;

use App\Models\StaffImages;
use Livewire\Component;

class ImageUploadComponent extends Component
{

    protected function imageBlobUpload($file, $uid)
    {
        $imageBlob = $file;
        $imgBlob = new StaffImages();
        $imgBlob->img_blob = $imageBlob;
        $imgBlob->uid = $uid;
        $imgSaved = $imgBlob->save();
        return $imgSaved;
    }

    protected function imageBlobUpdate($file, $uid)
    {
        $imageBlob = $file;
        $updateImageBlob = StaffImages::where('uid', $uid)->first() ? StaffImages::where('uid', $uid)->update(['img_blob' => $imageBlob]) : $this->imageBlobUpload($file, $uid);
        return $updateImageBlob;
    }


    public $uid;
    public $savedpicture;



    public function mount($uid = null)
    {
        $this->uid = $uid;
    }

    public function save()
    {
        $this->imageBlobUpdate($this->savedpicture, $this->uid) ? $this->js("alert('Image Updated Successfully!')") : $this->js("alert('Something Went Wrong!')");
        $this->dispatch('image-updated', uid: $this->uid);
    }

    public function render()
    {

        return view('livewire.image-upload-component');
    }
}
