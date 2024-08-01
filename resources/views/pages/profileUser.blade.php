@auth
@extends('layouts.layout')
@section("content")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<style>
    .box,
    .box-representatives {
        padding: 0.5em;
        width: 100%;
        margin: 0.5em;
    }

    .box-2,
    .box-2-representatives {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }

    .hide,
    .hide-representatives {
        display: none;
    }

    img {
        max-width: 100%;
    }
</style>
<div id="liveAlertPlaceholder"></div>
<div class="row">
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="card-title fw-semibold">Profile Picture</h5>
                </div>
                <!-- <img src="asset('assets/images/profile/user-1.jpg')" width="200px" height="200px" class="rounded mx-auto d-block" alt="User Profile Picture"> -->
                <img src="{{$user->images?$user->images->img_blob:($user->avatar?$user->avatar:asset('assets/images/profile/user-1.jpg'))}}" width="200px" height="200px" class="rounded mx-auto d-block" alt="User Profile Picture">
                <br />
                <form action="{{route('request.imageUpload')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="input-group">
                        <input type="hidden" value="{{$user->uid}}" name="id" required/>
                        <!-- <input type="file" class="form-control" id="uploadFile" aria-describedby="inputGroupFileAddon04" aria-label="Upload" name="image" accept="image/png, image/jpeg" required>
                        <button class="btn btn-outline-danger" type="submit">Upload</button> -->
                    </div>
                    <div class="mb-3">
                        <label for="delegation_picture" class="form-label">Picture</label>
                        <input name="delegation_picture" type="file" class="form-control" id="delegation_picture" accept="image/png, image/jpeg" required>
                        <input name="savedpicture" type="hidden" class="form-control" id="savedpicture" value="" required>
                        <div class="box-2">
                            <div class="result"></div>
                        </div>
                        <div class="box-2 img-result {{isset($delegationHead->delegation_picture) ? ($delegationHead?->delegation_picture?->img_blob ? '' : 'hide') : ''}}">
                            <img class="cropped" src="{{isset($delegationHead->delegation_picture)? $delegationHead?->delegation_picture?->img_blob:''}}" alt="" />
                        </div>
                        <div class="box">
                            <div class="options hide">
                                <label>Width</label>
                                <input type="number" class="img-w" value="300" min="100" max="1200" required/>
                            </div>
                            <button class="btn save hide">Save</button>
                        </div>
                        <button class="btn btn-outline-danger" type="submit">Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-8 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-title fw-semibold mb-4">Profile Information</h5>
                <div class="table-responsive">
                    <form name="userBasicInfo" id="userBasicInfo">
                        <fieldset>
                            <legend>General Information</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="disabledInputEmail1" class="form-label">Registered Email Address</label>
                                <input name="disabledInputEmail1" type="email" class="form-control" id="disabledInputEmail1" placeholder="Registered Email Address" aria-describedby="emailHelp" value="{{$user->email}}" disabled>
                                <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
                            </div>
                            <div class="mb-3">
                                <label for="inputUserName" class="form-label">Your User Name</label>
                                <input name="inputUserName" type="text" class="form-control" id="inputUserName" placeholder="User Name" aria-describedby="userHelp" value="{{$user->name}}" minlength="3" maxlength="20" required>
                            </div>
                            <div class="mb-3">
                                <label for="contact" class="form-label">Your Contact Number</label>
                                <input type="text" name="inputContactNumber" class="form-control" id="contact" placeholder="Contact Number" aria-describedby="userHelp" value="{{$user->contact_number}}" minlength="14" maxlength="14" required>
                            </div>
                            <input type="hidden" name="uid" value="{{$user->uid}}" />
                            <input type="submit" name="submit" class="btn btn-primary" value="Update" />
                        </fieldset>
                    </form>
                </div>
                <br />
                <div class="table-responsive">
                    <form name="userPasswordInfo" id="userPasswordInfo">
                        <fieldset>
                            <legend>Password Information</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="userInputPassword" class="form-label">Password</label>
                                <input type="password" name="userInputPassword" onkeypress="checkPasswordStrength(this)" class="form-control" id="userInputPassword" placeholder="Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                            <div class="mb-3">
                                <label for="userInputPasswordConfirm" class="form-label">Confirm Password</label>
                                <input type="password" name="userInputPasswordConfirm" onkeypress="checkPasswordStrength(this)" class="form-control" id="userInputPasswordConfirm" placeholder="Confirm Password" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Must contain at least one number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                            </div>
                            <input type="hidden" name="uid" value="{{$user->uid}}" required/>
                            <input type="submit" name="submit" class="btn btn-badar" value="Change" />
                        </fieldset>
                    </form>
                </div>
                <br />
                <div class="table-responsive">
                    <form name="userPermissionAndRolesInfo" id="userPermissionAndRolesInfo">
                        <fieldset <?php echo $user->uid === auth()->user()->uid ? 'disabled' : '' ?>>
                            <legend>Permissions & Roles</legend>
                            @csrf
                            <div class="mb-3">
                                <label for="roleSelect" class="form-label">Roles</label>
                                <select id="roleSelect" name="roles" class="form-select">
                                    @foreach($selectiveRoles as $selectiveRole)
                                    <option value="{{$selectiveRole->name}}" <?php echo $user->roles[0]->name === $selectiveRole->name ? 'selected' : '' ?>>{{$selectiveRole->display_name}}</option>
                                    {{$selectiveRole->name}}
                                    @endforeach
                                </select>
                            </div>

                            <input type="hidden" name="uid" value="{{$user->uid}}" required/>
                            <input type="submit" name="submit" class="btn btn-danger" value="Authorise" />
                        </fieldset>
                    </form>
                </div>
                <script async src="{{asset('assets/js/formValidations.js')}}"></script>
            </div>
        </div>
    </div>
</div>
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<script>
    // vars
    let result = document.querySelector('.result'),
        img_result = document.querySelector('.img-result'),
        save = document.querySelector('.save'),
        cropped = document.querySelector('.cropped'),
        img_w = document.querySelector('.img-w'),
        dwn = document.querySelector('.download'),
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
        dwn.classList.remove('hide');
        dwn.download = 'imagename.png';
        dwn.setAttribute('href', imgSrc);
    });
</script>
@endsection
@endauth