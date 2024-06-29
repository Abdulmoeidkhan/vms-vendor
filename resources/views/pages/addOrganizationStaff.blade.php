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
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_name" class="form-label">Staff Name</label>
                                            <input name="staff_name" type="text" class="form-control" id="staff_name" placeholder="Staff Name" value="{{isset($staff) ? $staff->staff_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_identity" class="form-label">Staff Identity</label>
                                            <input name="staff_identity" type="text" class="form-control" id="staff_identity" placeholder="Staff Identity " value="{{isset($staff) ? $staff->staff_identity : ''}}" required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_designation" class="form-label">Staff Designation</label>
                                            <input name="staff_designation" type="text" class="form-control" id="staff_designation" placeholder="Staff Designation" value="{{isset($staff) ? $staff->staff_designation : ''}}" required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_contact" class="form-label">Staff Contact Number</label>
                                            <input name="staff_contact" type="text" minlength='0' maxlength='14' class="form-control" id="staff_contact" placeholder="Staff Contact Number" value="{{isset($staff) ? $staff->staff_contact : ''}}" minlength='0' maxlength='14' onchange="isContact('contact')" title="14 DIGIT PHONE NUMBET" data-inputmask="'mask': '+99-9999999999'" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_type" class="form-label">Type</label>
                                            <select name="staff_type" id="staff_type" class="form-select">
                                                @if(isset($staff->staff_type))
                                                <option value="Test" {{$staff->staff_type == 'Test'?'selected':''}}> Test 1</option>
                                                <option value="Test2" {{$staff->staff_type == 'Test2'?'selected':''}}> Test 2</option>
                                                @else
                                                <option value="" selected disabled hidden> Select Type </option>
                                                <option value="Test"> Test 1</option>
                                                <option value="Test2"> Test 2</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_remarks" class="form-label">Staff Remarks</label>
                                            <input name="staff_remarks" type="text" class="form-control" id="staff_remarks" value="{{isset($staff) ? $staff->staff_remarks : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_address" class="form-label">Address</label>
                                            <input name="staff_address" type="text" class="form-control" id="staff_address" value="{{isset($staff) ? $staff->staff_address : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_city" class="form-label">City</label>
                                            <input name="staff_city" type="text" class="form-control" id="staff_city" value="{{isset($staff) ? $staff->staff_city : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_country" class="form-label">Country</label>
                                            <input name="staff_country" type="text" class="form-control" id="staff_country" value="{{isset($staff) ? $staff->staff_country : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
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
@endsection
@endauth