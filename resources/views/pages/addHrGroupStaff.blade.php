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
        <li class="breadcrumb-item"><a href="/hrGroups">Home</a></li>
        @if(isset($uid))
        <li class="breadcrumb-item"><a href="/hrGroup/{{$uid}}">
                @foreach (\App\Models\HrGroup::where('uid', $uid)->get('hr_name') as $item)
                {{$item->hr_name}}
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
                <h5 class="card-ti tle fw-semibold mb-4">New Staff</h5>
                <div class="table-responsive">
                    <form name="staffInfo" id="staffInfo" method="POST"
                        action="{{isset($staff->uid)? route('request.updateHrGroupStaff',$staff->uid):route('request.addHrGroupStaff',$uid)}}">
                        <fieldset>
                            <legend>Add Form</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_first_name" class="form-label">First Name</label>
                                            <input name="hr_first_name" type="text" class="form-control"
                                                id="hr_first_name" placeholder="First Name"
                                                value="{{isset($staff) ? $staff->hr_first_name : ''}}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_last_name" class="form-label">Last Name</label>
                                            <input name="hr_last_name" type="text" class="form-control"
                                                id="hr_last_name" placeholder="Last Name"
                                                value="{{isset($staff) ? $staff->hr_last_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_father_name" class="form-label">Father Name</label>
                                            <input name="hr_father_name" type="text" class="form-control"
                                                id="hr_father_name" placeholder="Father Name"
                                                value="{{isset($staff) ? $staff->hr_father_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_designation" class="form-label">Designation</label>
                                            <input name="hr_designation" type="text" class="form-control"
                                                id="hr_designation" placeholder="Designation"
                                                value="{{isset($staff) ? $staff->hr_designation : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_department" class="form-label">Department</label>
                                            <input name="hr_department" type="text" class="form-control"
                                                id="hr_department" placeholder="Department"
                                                value="{{isset($staff) ? $staff->hr_department : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            @if(isset($staff))
                                            <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                                modalId="hr_job_type" name="Job Type"
                                                :className="$modelClass=App\Models\JobType::class" colorClass="danger"
                                                :oldData='$staff->hr_job_type' btnName="Add Job" />
                                            @else
                                            <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                                modalId="hr_job_type" name="Job Type"
                                                :className="$modelClass=App\Models\JobType::class" colorClass="primary"
                                                :oldData='null' btnName="Add Job" />
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_nationality" class="form-label">Nationality</label>
                                            <input name="hr_nationality" type="text" class="form-control"
                                                id="hr_nationality"
                                                value="{{isset($staff) ? $staff->hr_nationality : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_identity" class="form-label">CNIC/Passport</label>
                                            <input name="hr_identity" type="text" pattern="^[a-zA-Z0-9]{9,14}$" class="form-control"
                                                id="hr_identity" placeholder="Identity" minlength='7' maxlength='13'
                                                value="{{isset($staff) ? $staff->hr_identity : ''}}" required />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_identity_expiry" class="form-label">CNIC/Passport
                                                Expiry</label>
                                            <input name="hr_identity_expiry" type="date" class="form-control"
                                                id="hr_identity_expiry" placeholder="Identity Expiry " value='{{isset($staff) ? date("Y-m-d",strtotime($staff->hr_identity_expiry)) : substr(date(DATE_ATOM, mktime(0, 0, 0, (date("
                                                m")), (date("d")), (date("Y")))), 0, 10);}}'
                                                min='{{substr(date(DATE_ATOM, mktime(0, 0, 0, (date("m")), (date("d")), (date("Y")))), 0, 10);}}'
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_contact" class="form-label">Contact Number</label>
                                            <input name="hr_contact" type="text" minlength='11' maxlength='12'
                                                class="form-control" id="hr_contact" placeholder="Contact Number"
                                                value="{{isset($staff) ? $staff->hr_contact : ''}}" minlength='0'
                                                maxlength='14' onchange="isContact('contact')"
                                                title="14 DIGIT PHONE NUMBER" data-inputmask="'mask': '+99-9999999999'"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_address" class="form-label">Home Address</label>
                                            <input name="hr_address" type="text" class="form-control" id="hr_address"
                                                value="{{isset($staff) ? $staff->hr_address : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_city" class="form-label">City</label>
                                            <input name="hr_city" type="text" class="form-control" id="hr_city"
                                                value="{{isset($staff) ? $staff->hr_city : ''}}" required />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_country" class="form-label">Country</label>
                                            <input name="hr_country" type="text" class="form-control" id="hr_country"
                                                value="{{isset($staff) ? $staff->hr_country : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_dob" class="form-label">Date Of Birth</label>
                                            <input name="hr_dob" type="date" class="form-control" id="hr_dob"
                                                value="{{isset($staff) ? date('Y-m-d',strtotime($staff->hr_dob)):substr(date(DATE_ATOM, mktime(0, 0, 0, (date("
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
                                                <option value="Permanent" {{isset($staff->
                                                    employee_type)?$staff->employee_type ==
                                                    'Permanent'?'selected':'':''}}>Permanent</option>
                                                <option value="Temporary" {{isset($staff->
                                                    employee_type)?$staff->employee_type ==
                                                    'Temporary'?'selected':'':''}}>Temporary</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_gender" class="form-label">Employee Gender</label>
                                            <select name="hr_gender" id="hr_gender" class="form-select">
                                                <option value="" {{isset($staff->hr_gender)?'':'selected'}} disabled
                                                    hidden> Select Employee Gender </option>
                                                <option value="1" {{isset($staff->
                                                    hr_gender)?$staff->hr_gender ==
                                                    '1'?'selected':'':''}}>Male</option>
                                                <option value="0" {{isset($staff->
                                                    hr_gender)?$staff->hr_gender ==
                                                    '0'?'selected':'':''}}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_type" class="form-label">Pass Type</label>
                                            <select name="hr_type" id="hr_type" class="form-select" required>
                                                <option value="" {{isset($staff->hr_type)?'':'selected'}} disabled
                                                    hidden> Select Pass Type </option>
                                                <option value="Trade_visitor" {{isset($staff->
                                                    hr_type)?$staff->hr_type ==
                                                    'Trade_visitor'?'selected':'':''}}>Trade Visitor</option>
                                                <option value="Volunteer" {{isset($staff->
                                                    hr_type)?$staff->hr_type ==
                                                    'Volunteer'?'selected':'':''}}>Volunteer</option>
                                                <option value="Local_delegate" {{isset($staff->
                                                    hr_type)?$staff->hr_type ==
                                                    'Local_delegate'?'selected':'':''}}>Local Delegate</option>
                                                <option value="Organiser" {{isset($staff->
                                                    hr_type)?$staff->hr_type ==
                                                    'Organiser'?'selected':'':''}}>Organiser</option>
                                                <option value="Event_manager" {{isset($staff->
                                                    hr_type)?$staff->hr_type ==
                                                    'Event_manager'?'selected':'':''}}>Event Manager</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_status" class="form-label">Staus</label>
                                            <select name="hr_status" id="hr_status" class="form-select">
                                                <option value="Active" {{isset($staff->
                                                    hr_status)?$staff->hr_status ==
                                                    'Active'?'selected':'':''}}>Active</option>
                                                <option value="InActive" {{isset($staff->
                                                    hr_status)?$staff->hr_status ==
                                                    'InActive'?'selected':'':''}}>InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_remarks" class="form-label">Remarks</label>
                                            <textarea name="hr_remarks" class="form-control"
                                                id="hr_remarks">{{isset($staff) ? $staff->hr_remarks : ''}}</textarea>
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
    <div class="col-lg-4 d-flex align-items-stretch">
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
    </div>
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
    <div class="col-lg-4 d-flex align-items-stretch">
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
    </div>
</div>
@endif
@endsection
@endauth