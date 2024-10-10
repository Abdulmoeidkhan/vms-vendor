<div>
    <div class="mb-4">
        <h5 class="card-title fw-semibold">{{$title}}</h5>
    </div>
    <br />
    <div>
        <img src="https://res.cloudinary.com/dj6mfrbth/image/upload/Images/{{$uid}}.png" height="200px"
            class="rounded mx-auto d-block" alt="User Profile Picture">
    </div>
    <form name="picture_upload" id="{{$name}}_picture_upload" wire:submit="save">
        <div class="mb-3 col-lg-10">
            <label for="{{$name}}" class="form-label">Picture</label>
            <input name="{{$name}}" type="file" class="form-control" id="{{$name}}" wire:model='pictureToBeUpdate'
                accept="image/png, image/jpeg" required>
            <input name="{{$name}}_savedpicture" type="hidden" class="form-control" id="{{$name}}_savedpicture"
                wire:model="savedpicture" required>
            <div class="box-2" wire:ignore>
                <div class="{{$name}}_result"></div>
                <div class="box-2 {{$name}}_img-result">
                    <img class="{{$name}}_cropped" src="" alt="" />
                </div>
                <div class="box">
                    <div class="options hide">
                        <label>Width</label>
                        <input type="number" class="{{$name}}_img-w" value="300" min="100" max="1200" required />
                    </div>
                    <button class="btn {{$name}}_save hide">Save</button>
                </div>
            </div>
            <button class="btn btn-outline-danger" type="submit" onclick="uploadFunc()">Upload</button>
            @if($name == 'staff_picture')
            <br />
            <br />
            <b>
                <ol>
                    <li>The Photograph should be 2X2.</li>
                    <li>The Picture should have white/blue background.</li>
                    <li>The Face should be focus and directly towards the camera.</li>
                </ol>
            </b>
            @endif
        </div>
    </form>
    <script>
        // vars
        let result_{{$name}} = document.querySelector('.{{$name}}_result'),
            img_result_{{$name}} = document.querySelector('.{{$name}}_img-result'),
            save_{{$name}} = document.querySelector('.{{$name}}_save'),
            cropped_{{$name}} = document.querySelector('.{{$name}}_cropped'),
            img_w_{{$name}} = document.querySelector('.{{$name}}_img-w'),
            upload_{{$name}} = document.querySelector('#{{$name}}'),
            cropper_{{$name}} = '';

        // on change show image with crop options
        upload_{{$name}}.addEventListener('change', e => {
            if (e.target.files.length) {
                // start file reader
                const reader = new FileReader();
                reader.onload = e => {
                    if (e.target.result) {
                        // create new image
                        let img = document.createElement('img');
                        img.id = 'image';
                        img.src = e.target.result;
                        // clean result before
                        result_{{$name}}.innerHTML = '';
                        // append new image
                        result_{{$name}}.appendChild(img);
                        // show save btn and options
                        save_{{$name}}.classList.remove('hide');
                        // options.classList.remove('hide');
                        // init cropper
                        cropper_{{$name}} = new Cropper(img);
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // save on click
        save_{{$name}}.addEventListener('click', e => {
            e.preventDefault();
            // get result to data uri
            let imgSrc = cropper_{{$name}}.getCroppedCanvas({
                width: img_w_{{$name}}.value // input value
            }).toDataURL();
            // remove hide class of img
            cropped_{{$name}}.classList.remove('hide');
            img_result_{{$name}}.classList.remove('hide');
            // show image cropped
            cropped_{{$name}}.src = imgSrc;
            document.getElementById('{{$name}}_savedpicture').value = imgSrc;
            @this.set('savedpicture', imgSrc);
            //  cropped.src="";
            //  save.classList.add('hide')
            //  img_result.classList.add('hide') 
            //  cropped.classList.add('hide') 
        });

        // function uploadFunc() {
        //     document.getElementById("picture_upload").submit().preventDefault();
        // }
    </script>
</div>