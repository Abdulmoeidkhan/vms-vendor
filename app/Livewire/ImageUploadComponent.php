<?php

namespace App\Livewire;

// use App\Models\StaffImages;
// use App\Models\CnicFront;
// use App\Models\CnicBack;
use Livewire\Component;
use Livewire\Attributes\On;
use Livewire\WithFileUploads;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageUploadComponent extends Component
{
    use WithFileUploads;

    public $uid;
    public $savedpicture;
    public $picture;
    public $pictureToBeUpdate;
    public $title;
    public $name;
    // public $dbClassCall;

    protected $listeners = [
        '$refresh'
    ];

    public function mount($uid = null, $title = null, $name = null)
    {
        $this->uid = $uid;
        $this->title = $title;
        $this->name = $name;
        $this->savedpicture = $name . '_savedpicture';
        // switch ($name) {
        //     case "staff_picture":
        //         $this->dbClassCall = StaffImages::class;
        //         break;
        //         // case "cnic_front_picture":
        //         //     $this->dbClassCall = CnicFront::class;
        //         //     break;
        //         // case "cnic_back_picture":
        //         //     $this->dbClassCall = CnicBack::class;
        //         //     break;
        //     default:
        //         echo "Your favorite color is neither red, blue, nor green!";
        // }
    }

    protected function imageBlobUpload($file, $uid)
    {
        $imageBlob = $file;
        // $imgBlob = new $this->dbClassCall;
        // $imgBlob->img_blob = $imageBlob;
        // $imgBlob->uid = $uid;
        // $imgSaved = $imgBlob->save();
        $imgSaved = Storage::disk('cloudinary')->put('Images/' . $uid, $imageBlob);
        return $imgSaved;
    }


    protected function imageDeleteBlobUpdate($file, $uid)
    {
        $imageBlob = $file;
        $oldImageDelete = Storage::disk('cloudinary')->delete('Images/' . $uid);
        $imgSaved = Storage::disk('cloudinary')->put('Images/profile/' . $uid . '.png', $imageBlob);
        return $imgSaved;
    }

    protected function imageBlobUpdate($file, $uid)
    {
        $imageBlob = $file;
        // $updateImageBlob = $imageBlob->storeOnCloudinaryAs('images', $uid);
        $updateImageBlob = Storage::disk('cloudinary')->exists($uid.'.png') ? $this->imageDeleteBlobUpdate($imageBlob, $uid) : $this->imageBlobUpload($file, $uid);
        // $updateImageBlob = $this->dbClassCall::where('uid', $uid)->first() ? $this->dbClassCall::where('uid', $uid)->update(['img_blob' => $imageBlob]) : $this->imageBlobUpload($file, $uid);
        return $updateImageBlob;
    }

    public function save()
    {
        // $uploadOrUpdateImage = $this->imageBlobUpdate($this->savedpicture, $this->uid);
        $this->imageBlobUpdate($this->savedpicture, $this->uid) ? $this->js("alert('Image Updated Successfully!')") : $this->js("alert('Something Went Wrong!')");
        $this->dispatch('image-updated')->self();
    }

    #[On('image-updated')]
    public function render()
    {
        // $this->picture = $this->dbClassCall::where('uid', $this->uid)->first();
        return view('livewire.image-upload-component');
    }
}
