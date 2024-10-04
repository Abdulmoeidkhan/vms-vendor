@auth
@extends('layouts.layout')
@section("content")
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/5.0.0/normalize.min.css">
<link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/cropper/2.3.4/cropper.min.css'>
<style>
    .box {
        padding: 0.5em;
        width: 100%;
        margin: 0.5em;
    }

    .box-2 {
        padding: 0.5em;
        width: calc(100%/2 - 1em);
    }

    .hide {
        display: none;
    }

    img {
        max-width: 100%;
    }
</style>
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/mediaGroups">Home</a></li>
        @if(isset($media_uid))
        <li class="breadcrumb-item"><a href="/mediaGroup/{{$media_uid}}">
                @foreach (\App\Models\MediaGroup::where('uid', $media_uid)->get('media_name') as $item)
                {{$item->media_name}}
                @endforeach
            </a></li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">Staff</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-ti tle fw-semibold mb-4">New Media Staff</h5>
                <div class="table-responsive">
                    <form name="mediaStaffInfo" id="mediaStaffInfo" method="POST"
                        action="{{isset($staff->uid)? route('request.updateMediaStaffRequest',$staff->uid):route('request.addMediaStaff',$media_uid)}}">
                        <fieldset>
                            <legend>Add Form</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_first_name" class="form-label">First Name</label>
                                            <input name="media_staff_first_name" type="text" class="form-control"
                                                id="media_staff_first_name" placeholder="First Name"
                                                value="{{isset($staff) ? $staff->media_staff_first_name : ''}}"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_last_name" class="form-label">Last Name</label>
                                            <input name="media_staff_last_name" type="text" class="form-control"
                                                id="media_staff_last_name" placeholder="Last Name"
                                                value="{{isset($staff) ? $staff->media_staff_last_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_father_name" class="form-label">Father/Husband Name</label>
                                            <input name="media_staff_father_name" type="text" class="form-control"
                                                id="media_staff_father_name" placeholder="Father/Husband Name"
                                                value="{{isset($staff) ? $staff->media_staff_father_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_designation" class="form-label">Designation</label>
                                            <input name="media_staff_designation" type="text" class="form-control"
                                                id="media_staff_designation" placeholder="Designation"
                                                value="{{isset($staff) ? $staff->media_staff_designation : ''}}"
                                                required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_department" class="form-label">Department</label>
                                            <input name="media_staff_department" type="text" class="form-control"
                                                id="media_staff_department" placeholder="Department"
                                                value="{{isset($staff) ? $staff->media_staff_department : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            @if(isset($staff))
                                            <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                                modalId="media_staff_job_type" name="Job Type"
                                                :className="$modelClass=App\Models\JobType::class" colorClass="danger"
                                                :oldData='$staff->media_staff_job_type' btnName="Add Job" />
                                            @else
                                            <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                                modalId="media_staff_job_type" name="Job Type"
                                                :className="$modelClass=App\Models\JobType::class" colorClass="primary"
                                                :oldData='null' btnName="Add Job" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_nationality" class="form-label">Nationality</label>
                                            <input name="media_staff_nationality" type="text" class="form-control"
                                                id="media_staff_nationality"
                                                value="{{isset($staff) ? $staff->media_staff_nationality : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_identity" class="form-label">CNIC/Passport</label>
                                            <input name="media_staff_identity" type="text" pattern="^[a-zA-Z0-9]{9,14}$"
                                                class="form-control" id="media_staff_identity" placeholder="Identity"
                                                minlength='7' maxlength='13'
                                                value="{{isset($staff) ? $staff->media_staff_identity : ''}}"
                                                required />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_identity_expiry" class="form-label">CNIC/Passport
                                                Expiry</label>
                                            <input name="media_staff_identity_expiry" type="date" class="form-control"
                                                id="media_staff_identity_expiry" placeholder="Identity Expiry " value='{{isset($staff) ? date("Y-m-d",strtotime($staff->media_staff_identity_expiry)) : substr(date(DATE_ATOM, mktime(0, 0, 0, (date("
                                                m")), (date("d")), (date("Y")))), 0, 10);}}'
                                                min='{{substr(date(DATE_ATOM, mktime(0, 0, 0, (date("m")), (date("d")), (date("Y")))), 0, 10);}}'
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_contact" class="form-label">Contact Number</label>
                                            <input name="media_staff_contact" type="text" minlength='11' maxlength='12'
                                                class="form-control" id="media_staff_contact"
                                                placeholder="Contact Number"
                                                value="{{isset($staff) ? $staff->media_staff_contact : ''}}"
                                                minlength='0' maxlength='14' onchange="isContact('contact')"
                                                title="14 DIGIT PHONE NUMBER" data-inputmask="'mask': '+99-9999999999'"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_address" class="form-label">Home Address</label>
                                            <input name="media_staff_address" type="text" class="form-control"
                                                id="media_staff_address"
                                                value="{{isset($staff) ? $staff->media_staff_address : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_city" class="form-label">City</label>
                                            <input name="media_staff_city" type="text" class="form-control"
                                                id="media_staff_city"
                                                value="{{isset($staff) ? $staff->media_staff_city : ''}}" required />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_country" class="form-label">Country</label>
                                            <input name="media_staff_country" type="text" class="form-control"
                                                id="media_staff_country"
                                                value="{{isset($staff) ? $staff->media_staff_country : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_dob" class="form-label">Date Of Birth</label>
                                            <input name="media_staff_dob" type="date" class="form-control"
                                                id="media_staff_dob"
                                                value="{{isset($staff) ? date('Y-m-d',strtotime($staff->media_staff_dob)):substr(date(DATE_ATOM, mktime(0, 0, 0, (date("
                                                m")), (date("d")), (date("Y") - 17))), 0, 10);}}" min="1900-01-01"
                                                max="{{substr(date(DATE_ATOM, mktime(0, 0, 0, (date(" m")), (date("d")),
                                                (date("Y") - 17))), 0, 10);}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="employee_type" class="form-label">Employee Type</label>
                                            <select name="employee_type" id="employee_type" class="form-select">
                                                <option value="" {{isset($staff->employee_type)?'':'selected'}} disabled
                                                    hidden> Select Employee Type </option>
                                                <option value="Functionary" {{isset($staff->
                                                    employee_type)?$staff->employee_type ==
                                                    'Functionary'?'selected':'':''}}>Permanent</option>
                                                <option value="Temporary" {{isset($staff->
                                                    employee_type)?$staff->employee_type ==
                                                    'Temporary'?'selected':'':''}}>Temporary</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_staff_gender" class="form-label">Employee Gender</label>
                                            <select name="media_staff_gender" id="media_staff_gender"
                                                class="form-select">
                                                <option value="" {{isset($staff->media_staff_gender)?'':'selected'}}
                                                    disabled
                                                    hidden> Select Employee Gender </option>
                                                <option value="1" {{isset($staff->
                                                    media_gender)?$staff->media_staff_gender ==
                                                    '1'?'selected':'':''}}>Male</option>
                                                <option value="0" {{isset($staff->
                                                    media_gender)?$staff->media_staff_gender ==
                                                    '0'?'selected':'':''}}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_staff_type" class="form-label">Pass Type</label>
                                            <select name="media_staff_type" id="media_staff_type" class="form-select"
                                                required>
                                                <option value="" {{isset($staff->media_staff_type)?'':'selected'}}
                                                    disabled
                                                    hidden> Pass Type </option>
                                                @if(!$functionaryStaffSaturated)
                                                <option value="Functionary" {{isset($staff->
                                                    media_type)?$staff->media_staff_type ==
                                                    'Functionary'?'selected':'':''}}>Functionary Pass</option>
                                                @endif
                                                <option value="Temporary" {{isset($staff->
                                                    media_staff_type)?$staff->media_staff_type
                                                    == 'Temporary'?'selected':'':''}}>Temporary Pass</option>
                                            </select>
                                        </div>
                                    </div> --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_staff_status" class="form-label">Staus</label>
                                            <select name="media_staff_status" id="media_staff_status"
                                                class="form-select">
                                                <option value="Active" {{isset($staff->
                                                    media_status)?$staff->media_staff_status ==
                                                    'Active'?'selected':'':''}}>Active</option>
                                                <option value="InActive" {{isset($staff->
                                                    media_status)?$staff->media_staff_status ==
                                                    'InActive'?'selected':'':''}}>InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_staff_remarks" class="form-label">Remarks</label>
                                            <textarea name="media_staff_remarks" class="form-control"
                                                id="media_staff_remarks">{{isset($staff) ? $staff->media_staff_remarks : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <br />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore"
                                                class="btn {{isset($staff->uid )?'btn-primary':'btn-success'}}"
                                                value="{{isset($staff->uid)?'Update & Next':'Add & Next'}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-8">
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@if(isset($staff->uid))
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<div class="row">
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <livewire:image-upload-component :uid="$staff->uid" title="Image" name="staff_picture" />
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <livewire:image-upload-component :uid="$staff->uid" title="CNIC Front" name="cnic_front_picture" />
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <livewire:image-upload-component :uid="$staff->uid" title="CNIC Back" name="cnic_back_picture" />
            </div>
        </div>
    </div> --}}
</div>
@else
<div class="row" style="cursor: not-allowed;">
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="card-title fw-semibold">Image</h5>
                </div>
                <br />
                <div>
                    <img src="{{asset('assets/images/profile/user-1.jpg')}}" width="200px" height="200px"
                        class="rounded mx-auto d-block" alt="User Profile Picture">
                </div>
                <form class=>
                    <div class="mb-3 col-lg-10">
                        <label for="dummyPicture" class="form-label">Picture</label>
                        <input name="dummyPicture" type="file" class="form-control disabled"
                            accept="image/png, image/jpeg" disabled>
                        <br />
                        <button class="btn btn-outline-danger disabled" type="submit" disabled>Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100 disabled">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="card-title fw-semibold">CNIC Front</h5>
                </div>
                <br />
                <div>
                    <img src="{{asset('assets/images/profile/CNIC_Front.jpg')}}" width="400px" height="200px"
                        class="rounded mx-auto d-block" alt="User Profile Picture">
                </div>
                <form>
                    <div class="mb-3 col-lg-10">
                        <label for="dummyPicture" class="form-label">Picture</label>
                        <input name="dummyPicture" type="file" class="form-control" accept="image/png, image/jpeg"
                            disabled>
                        <br />
                        <button class="btn btn-outline-danger disabled" type="submit" disabled>Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100 ">
            <div class="card-body p-4">
                <div class="mb-4">
                    <h5 class="card-title fw-semibold">CNIC Back</h5>
                </div>
                <br />
                <div>
                    <img src="{{asset('assets/images/profile/CNIC_Back.jpg')}}" width="400px" height="200px"
                        class="rounded mx-auto d-block" alt="User Profile Picture">
                </div>
                <form>
                    <div class="mb-3 col-lg-10">
                        <label for="dummyPicture" class="form-label">Picture</label>
                        <input name="dummyPicture" type="file" class="form-control" accept="image/png, image/jpeg"
                            disabled>
                        <br />
                        <button class="btn btn-outline-danger disabled" type="submit" disabled>Upload</button>
                    </div>
                </form>
            </div>
        </div>
    </div> --}}
</div>
@endif
@endsection
@endauth