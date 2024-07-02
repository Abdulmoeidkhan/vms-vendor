<div>
    <form wire:submit="save">
        <div class="mb-3 col-lg-10">
            <label for="delegation_picture" class="form-label">Picture</label>
            <input name="delegation_picture" type="file" class="form-control" id="delegation_picture"
                accept="image/png, image/jpeg" required>
            <input name="savedpicture" type="hidden" class="form-control" id="savedpicture" wire:model="savedpicture"
                required>
            <div class="box-2" wire:ignore>
                <div class="result"></div>
                <div class="box-2 img-result">
                    <img class="cropped" src="" alt="" />
                </div>
                <div class="box">
                    <div class="options hide">
                        <label>Width</label>
                        <input type="number" class="img-w" value="300" min="100" max="1200" required />
                    </div>
                    <button class="btn save hide">Save</button>
                </div>
            </div>
            <button class="btn btn-outline-danger" type="submit">Upload</button>
        </div>
    </form>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
    <script>
        // vars
        let result = document.querySelector('.result'),
            img_result = document.querySelector('.img-result'),
            save = document.querySelector('.save'),
            cropped = document.querySelector('.cropped'),
            img_w = document.querySelector('.img-w'),
            upload = document.querySelector('#delegation_picture'),
            cropper = '';

        // on change show image with crop options
        upload.addEventListener('change', e => {
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
                        result.innerHTML = '';
                        // append new image
                        result.appendChild(img);
                        // show save btn and options
                        save.classList.remove('hide');
                        // options.classList.remove('hide');
                        // init cropper
                        cropper = new Cropper(img);
                    }
                };
                reader.readAsDataURL(e.target.files[0]);
            }
        });

        // save on click
        save.addEventListener('click', e => {
            e.preventDefault();
            // get result to data uri
            let imgSrc = cropper.getCroppedCanvas({
                width: img_w.value // input value
            }).toDataURL();
            // remove hide class of img
            cropped.classList.remove('hide');
            img_result.classList.remove('hide');
            // show image cropped
            cropped.src = imgSrc;
            document.getElementById('savedpicture').value = imgSrc;
            @this.set('savedpicture', imgSrc);
        });
    </script>
</div>