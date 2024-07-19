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
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-ti tle fw-semibold mb-4">New Staff</h5>
                <div class="table-responsive">
                    <form name="staffInfo" id="staffInfo" method="POST"
                        action="{{isset($staff->uid)? route('request.updateOrganizationStaff',$staff->uid):route('request.addOrganizationStaff',$company_uid)}}">
                        <fieldset>
                            <legend>Add Form</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_first_name" class="form-label">First Name</label>
                                            <input name="staff_first_name" type="text" class="form-control"
                                                id="staff_first_name" placeholder="First Name"
                                                value="{{isset($staff) ? $staff->staff_first_name : ''}}" required />
                                        </div>
                                    </div>

                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_last_name" class="form-label">Last Name</label>
                                            <input name="staff_last_name" type="text" class="form-control"
                                                id="staff_last_name" placeholder="Last Name"
                                                value="{{isset($staff) ? $staff->staff_last_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_father_name" class="form-label">Father Name</label>
                                            <input name="staff_father_name" type="text" class="form-control"
                                                id="staff_father_name" placeholder="Father Name"
                                                value="{{isset($staff) ? $staff->staff_father_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_designation" class="form-label">Designation</label>
                                            <input name="staff_designation" type="text" class="form-control"
                                                id="staff_designation" placeholder="Designation"
                                                value="{{isset($staff) ? $staff->staff_designation : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_department" class="form-label">Department</label>
                                            <input name="staff_department" type="text" class="form-control"
                                                id="staff_department" placeholder="Department"
                                                value="{{isset($staff) ? $staff->staff_department : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            {{-- if(session()->get('user')->roles[0]->name === "admin") --}}
                                            @if(isset($staff))
                                            <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                                modalId="staff_job_type" name="Job Type"
                                                :className="$modelClass=App\Models\JobType::class" colorClass="danger"
                                                :oldData='$staff->staff_job_type' btnName="Add Job" />
                                            @else
                                            <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                                modalId="staff_job_type" name="Job Type"
                                                :className="$modelClass=App\Models\JobType::class" colorClass="primary"
                                                :oldData='null' btnName="Add Job" />
                                            @endif
                                            {{-- else
                                            <label for="staff_job_type" class="form-label">Job Type</label>
                                            <select name="staff_job_type" id="staff_job_type" class="form-select">
                                                <option value="" {{isset($staff->staff_job_type)?'':'selected'}}
                                                    disabled hidden> Select Job Type </option>
                                                @foreach (\App\Models\JobType::all() as $jobType)
                                                <option value="{{$jobType->display_name}}" {{isset($staff->
                                                    staff_job_type) ? ($staff->staff_job_type ==
                                                    $country->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($staff->staff_job_type)
                                                    ?$staff->staff_job_type:$jobType->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                            endif --}}
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_nationality" class="form-label">Nationality</label>
                                            <input name="staff_nationality" type="text" class="form-control"
                                                id="staff_nationality"
                                                value="{{isset($staff) ? $staff->staff_nationality : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_identity" class="form-label">CNIC/Passport</label>
                                            <input name="staff_identity" type="text" class="form-control"
                                                id="staff_identity" placeholder="Identity" minlength='7' maxlength='13'
                                                value="{{isset($staff) ? $staff->staff_identity : ''}}" required />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_identity_expiry" class="form-label">CNIC/Passport
                                                Expiry</label>
                                            <input name="staff_identity_expiry" type="date" class="form-control"
                                                id="staff_identity_expiry" placeholder="Identity Expiry "
                                                value='{{isset($staff) ? date("Y-m-d",strtotime($staff->staff_identity_expiry)) : substr(date(DATE_ATOM, mktime(0, 0, 0, (date("
                                                m")), (date("d")), (date("Y")))), 0, 10);}}' min='{{substr(date(DATE_ATOM, mktime(0, 0, 0, (date("m")), (date("d")), (date("Y")))), 0, 10);}}' required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_contact" class="form-label">Contact Number</label>
                                            <input name="staff_contact" type="text" minlength='11' maxlength='11'
                                                class="form-control" id="staff_contact" placeholder="Contact Number"
                                                value="{{isset($staff) ? $staff->staff_contact : ''}}" minlength='0'
                                                maxlength='14' onchange="isContact('contact')"
                                                title="14 DIGIT PHONE NUMBER" data-inputmask="'mask': '+99-9999999999'"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_address" class="form-label">Home Address</label>
                                            <input name="staff_address" type="text" class="form-control"
                                                id="staff_address"
                                                value="{{isset($staff) ? $staff->staff_address : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_city" class="form-label">City</label>
                                            <input name="staff_city" type="text" class="form-control" id="staff_city"
                                                value="{{isset($staff) ? $staff->staff_city : ''}}" required />
                                        </div>
                                    </div>

                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_country" class="form-label">Country</label>
                                            <input name="staff_country" type="text" class="form-control"
                                                id="staff_country"
                                                value="{{isset($staff) ? $staff->staff_country : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_dob" class="form-label">Date Of Birth</label>
                                            <input name="staff_dob" type="date" class="form-control" id="staff_dob"
                                                value="{{isset($staff) ? date('Y-m-d',strtotime($staff->staff_dob)):substr(date(DATE_ATOM, mktime(0, 0, 0, (date("
                                                m")), (date("d")), (date("Y") - 17))), 0, 10);}}" min="1900-01-01"
                                                max="{{substr(date(DATE_ATOM, mktime(0, 0, 0, (date(" m")), (date("d")),
                                                (date("Y") - 17))), 0, 10);}}" required />
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_doj" class="form-label">Date Of Joining</label>
                                            <input name="staff_doj" type="date" class="form-control" id="staff_doj"
                                                value="{{isset($staff) ? $staff->staff_doj : ''}}" required />
                                        </div>
                                    </div> --}}
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
                                            <label for="staff_gender" class="form-label">Employee Gender</label>
                                            <select name="staff_gender" id="staff_gender" class="form-select">
                                                <option value="" {{isset($staff->staff_gender)?'':'selected'}} disabled
                                                    hidden> Select Employee Gender </option>
                                                <option value="Male" {{isset($staff->
                                                    staff_gender)?$staff->staff_gender ==
                                                    'Male'?'selected':'':''}}>Male</option>
                                                <option value="Female" {{isset($staff->
                                                    staff_gender)?$staff->staff_gender ==
                                                    'Female'?'selected':'':''}}>Female</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- if(isset($staff->staff_type)?$staff->staff_type !="PreEvent":true) --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_type" class="form-label">Pass Type</label>
                                            <select name="staff_type" id="staff_type" class="form-select" required>
                                                <option value="" {{isset($staff->staff_type)?'':'selected'}} disabled
                                                    hidden> Pass Type </option>
                                                @if(!$functionaryStaffSaturated)
                                                <option value="Functionary" {{isset($staff->
                                                    staff_type)?$staff->staff_type ==
                                                    'Functionary'?'selected':'':''}}>Functionary Pass</option>
                                                @endif
                                                <option value="Temporary" {{isset($staff->staff_type)?$staff->staff_type
                                                    == 'Temporary'?'selected':'':''}}>Temporary Pass</option>
                                            </select>
                                        </div>
                                    </div>
                                    {{-- endif --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_status" class="form-label">Staus</label>
                                            <select name="staff_status" id="staff_status" class="form-select">
                                                <option value="Active" {{isset($staff->
                                                    staff_status)?$staff->staff_status ==
                                                    'Active'?'selected':'':''}}>Active</option>
                                                <option value="InActive" {{isset($staff->
                                                    staff_status)?$staff->staff_status ==
                                                    'InActive'?'selected':'':''}}>InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_remarks" class="form-label">Remarks</label>
                                            <textarea name="staff_remarks" class="form-control"
                                                id="staff_remarks">{{isset($staff) ? $staff->staff_remarks : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <br />
                                <div class="row">
                                    {{-- <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submit"
                                                class="btn {{isset($staff->uid )?'btn-success':'btn-primary'}}"
                                                value="{{isset($staff->uid)?'Update Staff':'Add Staff'}}" />
                                        </div>
                                    </div> --}}
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
                    <img src="{{asset('assets/images/profile/user-1.jpg')}}" width="200px" height="200px"
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
                    <img src="{{asset('assets/images/profile/user-1.jpg')}}" width="200px" height="200px"
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