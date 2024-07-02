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
                    <form name="staffInfo" id="staffInfo" method="POST" action="{{isset($staff->uid)? route('request.updateOrganizationStaff',$staff->uid):route('request.addOrganizationStaff',$company_uid)}}">
                        <fieldset>
                            <legend>Add Staff Form</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_first_name" class="form-label">Staff First Name</label>
                                            <input name="staff_first_name" type="text" class="form-control" id="staff_first_name" placeholder="Staff First Name" value="{{isset($staff) ? $staff->staff_first_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_last_name" class="form-label">Staff Last Name</label>
                                            <input name="staff_last_name" type="text" class="form-control" id="staff_last_name" placeholder="Staff Last Name" value="{{isset($staff) ? $staff->staff_last_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_designation" class="form-label">Staff Designation</label>
                                            <input name="staff_designation" type="text" class="form-control" id="staff_designation" placeholder="Staff Designation" value="{{isset($staff) ? $staff->staff_designation : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_department" class="form-label">Staff Department</label>
                                            <input name="staff_department" type="text" class="form-control" id="staff_department" placeholder="Staff Department" value="{{isset($staff) ? $staff->staff_department : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_job_type" class="form-label">Job Type</label>
                                            <select name="staff_job_type" id="staff_job_type" class="form-select">
                                                <option value="" {{isset($staff->staff_job_type)?'':'selected'}} disabled hidden> Select Job Type </option>
                                                <option value="Labour" {{isset($staff->staff_job_type)?$staff->staff_job_type == 'Labour'?'selected':'':''}}> Labour</option>
                                                <option value="Freelance" {{isset($staff->staff_job_type)?$staff->staff_job_type == 'Freelance'?'selected':'':''}}> Freelance</option>
                                                <option value="Manager" {{isset($staff->staff_job_type)?$staff->staff_job_type == 'Manager'?'selected':'':''}}> Manager</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_nationality" class="form-label">Staff Nationality</label>
                                            <input name="staff_nationality" type="text" class="form-control" id="staff_nationality" value="{{isset($staff) ? $staff->staff_nationality : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_identity" class="form-label">Staff Identity</label>
                                            <input name="staff_identity" type="text" class="form-control" id="staff_identity" placeholder="Staff Identity " value="{{isset($staff) ? $staff->staff_identity : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_identity_expiry" class="form-label">Staff Identity Expiry</label>
                                            <input name="staff_identity_expiry" type="date" class="form-control" id="staff_identity_expiry" placeholder="Staff Identity Expiry " value="{{isset($staff) ? $staff->staff_identity_expiry : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_contact" class="form-label">Staff Contact Number</label>
                                            <input name="staff_contact" type="text" minlength='0' maxlength='14' class="form-control" id="staff_contact" placeholder="Staff Contact Number" value="{{isset($staff) ? $staff->staff_contact : ''}}" minlength='0' maxlength='14' onchange="isContact('contact')" title="14 DIGIT PHONE NUMBET" data-inputmask="'mask': '+99-9999999999'" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_address" class="form-label">Address</label>
                                            <input name="staff_address" type="text" class="form-control" id="staff_address" value="{{isset($staff) ? $staff->staff_address : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_city" class="form-label">City</label>
                                            <input name="staff_city" type="text" class="form-control" id="staff_city" value="{{isset($staff) ? $staff->staff_city : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_country" class="form-label">Country</label>
                                            <input name="staff_country" type="text" class="form-control" id="staff_country" value="{{isset($staff) ? $staff->staff_country : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_dob" class="form-label">Staff Date Of Birth</label>
                                            <input name="staff_dob" type="date" class="form-control" id="staff_dob" value="{{isset($staff) ? $staff->staff_dob : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_doj" class="form-label">Staff Date Of Joining</label>
                                            <input name="staff_doj" type="date" class="form-control" id="staff_doj" value="{{isset($staff) ? $staff->staff_doj : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="employee_type" class="form-label">Employee Type</label>
                                            <select name="employee_type" id="employee_type" class="form-select">
                                                <option value="" {{isset($staff->employee_type)?'':'selected'}} disabled hidden> Select Employee Type </option>
                                                <option value="Permanent" {{isset($staff->employee_type)?$staff->employee_type == 'Permanent'?'selected':'':''}}>Permanent</option>
                                                <option value="Temporary" {{isset($staff->employee_type)?$staff->employee_type == 'Temporary'?'selected':'':''}}>Temporary</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="staff_type" class="form-label">Staff Type</label>
                                            <select name="staff_type" id="staff_type" class="form-select">
                                                <option value="" {{isset($staff->staff_type)?'':'selected'}} disabled hidden> Staff Type </option>
                                                <option value="Functionary" {{isset($staff->staff_type)?$staff->staff_type == 'Functionary'?'selected':'':''}}>Functionary</option>
                                                <option value="Preevent" {{isset($staff->staff_type)?$staff->staff_type == 'Preevent'?'selected':'':''}}>Preevent</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_status" class="form-label">Staus</label>
                                            <select name="staff_status" id="staff_status" class="form-select">
                                                <option value="Active" {{isset($staff->staff_status)?$staff->staff_status == 'Active'?'selected':'':''}}>Active</option>
                                                <option value="InActive" {{isset($staff->staff_status)?$staff->staff_status == 'InActive'?'selected':'':''}}>InActive</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_remarks" class="form-label">Staff Remarks</label>
                                            <textarea name="staff_remarks" class="form-control" id="staff_remarks">{{isset($staff) ? $staff->staff_remarks : ''}}</textarea>
                                        </div>
                                    </div>
                                </div>

                                <br />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submit" class="btn {{isset($staff->uid )?'btn-success':'btn-primary'}}" value="{{isset($staff->uid)?'Update Staff':'Add Staff'}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore" class="btn {{isset($staff->uid )?'btn-primary':'btn-success'}}" value="{{isset($staff->uid)?'Update Staff & More':'Add Staff & More'}}" />
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
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-ti tle fw-semibold mb-4">New Staff Image</h5>
                <div class="table-responsive">
                    <livewire:image-upload-component :uid="$staff->uid" />
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
@endauth