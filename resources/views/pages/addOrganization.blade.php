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
                <h5 class="card-ti tle fw-semibold mb-4">New Organization</h5>
                <div class="table-responsive">
                    <form name="organizationInfo" id="organizationInfo" method="POST" action="{{isset($organization->uid)? route('request.updateOrganization',$organization->uid):route('request.addOrganization')}}">
                        <fieldset>
                            <legend>Add Organization Form</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_category" class="form-label">Company Category</label>
                                            <select name="company_category" id="company_category" class="form-select">
                                                @if(isset($organization->uid))
                                                <option value="Test" {{$organization->company_category == 'Test'?'selected':''}}> Test 1</option>
                                                <option value="Test2" {{$organization->company_category == 'Test2'?'selected':''}}> Test 2</option>
                                                @else
                                                <option value="" selected disabled hidden> Select Category </option>
                                                <option value="Test"> Test 1</option>
                                                <option value="Test2"> Test 2</option>
                                                @endif
                                                <!-- foreach (\App\Models\Rank::all() as $renderRank) -->
                                                <!-- <option value="renderRank->ranks_uid" {{isset($organization->company_category) ? ($organization->company_category ? 'selected' : '') : ''}}>{{isset($organization->company_category) ?$organization->company_category:''}}</option> -->
                                                <!-- endforeach -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_name" class="form-label">Company Name</label>
                                            <input name="company_name" type="text" class="form-control" id="company_name" placeholder="Company Name" value="{{isset($organization) ? $organization->company_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_address" class="form-label">Company Address</label>
                                            <input name="company_address" type="text" class="form-control" id="company_address" placeholder="Company Address" value="{{isset($organization) ? $organization->company_address : ''}}" required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_type" class="form-label">Type</label>
                                            <select name="company_type" id="company_type" class="form-select" {{isset($organization->company_type)?$organization->company_type:''}}>
                                                @if(isset($organization->uid))
                                                <option value="Test" {{$organization->company_type == 'Test'?'selected':''}}> Test 1</option>
                                                <option value="Test2" {{$organization->company_type == 'Test2'?'selected':''}}> Test 2</option>
                                                @else
                                                <option value="" selected disabled hidden> Select Type </option>
                                                <option value="Test"> Test 1</option>
                                                <option value="Test2"> Test 2</option>
                                                @endif
                                                <!-- foreach (\App\Models\Rank::all() as $renderRank) -->
                                                <!-- <option value="{{isset($organization->company_type) ? $organization->company_type  : ''}}"> {{isset($organization->company_type) ?$organization->company_type:""}} </option> -->
                                                <!-- endforeach -->
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_country" class="form-label">Country</label>
                                            <!-- <input name="company_country" type="text" class="form-control" id="company_country" placeholder="Pakistan" value="{{isset($organization) ? $organization->company_country : ''}}" required /> -->
                                            <select name="company_country" id="company_country" class="form-select" {{isset($organization->company_country)?$organization->company_country:''}}>
                                                <option value="" selected disabled hidden> Select Type </option>
                                                @foreach (\App\Models\Country::all() as $country)
                                                <option value="{{$country->name}}"> {{$country->value}} </option>
                                                @endforeach
                                            </select>
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_city" class="form-label">City</label>
                                            <input name="company_city" type="text" class="form-control" id="company_city" placeholder="Karachi" value="{{isset($organization) ? $organization->company_city : ''}}" required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">

                                        <div class="mb-3">
                                            <label for="company_contact" class="form-label">Contact Number</label>
                                            <input name="company_contact" type="text" minlength='0' maxlength='14' class="form-control" id="company_contact" placeholder="Company Contact Number" value="{{isset($organization) ? $organization->company_contact : ''}}" minlength='0' maxlength='14' onchange="isContact('contact')" title="14 DIGIT PHONE NUMBET" data-inputmask="'mask': '+99-9999999999'" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_ntn" class="form-label">NTN Number</label>
                                            <input name="company_ntn" type="number" class="form-control" id="company_ntn" placeholder="Company NTN" value="{{isset($organization) ? $organization->company_ntn : ''}}" onchange="isNumeric('identity')" title="NTN Number" required maxlength="15" required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                    </div>
                                </div>
                                <br />
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_owner" class="form-label">Company Owner Name</label>
                                            <input name="company_owner" type="text" class="form-control" id="company_owner" placeholder="Company Owner Name" value="{{isset($organization) ? $organization->company_owner : ''}}" required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_owner_designation" class="form-label">Company Owner Designation</label>
                                            <input name="company_owner_designation" type="text" class="form-control" id="company_owner_designation" placeholder="Company Owner Designation" value="{{isset($organization) ? $organization->company_owner_designation : ''}}" required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_owner_contact" class="form-label">Company Owner Contact</label>
                                            <input name="company_owner_contact" type="number" class="form-control" id="company_owner_contact" placeholder="Company Owner Contact" value="{{isset($organization) ? $organization->company_owner_contact: ''}}" required />
                                        </div>

                                    </div>
                                </div>
                                <br />
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_name" class="form-label">Company Rep Name</label>
                                            <input name="company_rep_name" type="text" class="form-control" id="company_rep_name" placeholder="Company Rep Name" value="{{isset($organization) ? $organization->company_rep_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_designation" class="form-label">Company Rep Designation</label>
                                            <input name="company_rep_designation" type="text" class="form-control" id="company_rep_designation" placeholder="Company Rep Designation" value="{{isset($organization) ? $organization->company_rep_designation : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_dept" class="form-label">Company Rep Department</label>
                                            <input name="company_rep_dept" type="text" class="form-control" id="company_rep_dept" placeholder="Company Rep Department" value="{{isset($organization) ? $organization->company_rep_dept : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_contact" class="form-label">Company Rep Contact</label>
                                            <input name="company_rep_contact" type="text" class="form-control" id="company_rep_contact" placeholder="Company Rep Contact" value="{{isset($organization) ? $organization->company_rep_contact : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_email" class="form-label">Company Rep Email</label>
                                            <input name="company_rep_email" type="text" class="form-control" id="company_rep_email" placeholder="Company Rep Email" value="{{isset($organization) ? $organization->company_rep_email  : ''}}" required disabled />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_phone" class="form-label">Company Rep Phone</label>
                                            <input name="company_rep_phone" type="text" class="form-control" id="company_rep_phone" placeholder="Company Rep Phone" value="{{isset($organization) ? $organization->company_rep_phone : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submit" class="btn {{isset($organization->uid )?'btn-success':'btn-primary'}}" value="{{isset($organization->uid)?'Update Organization':'Add Organization'}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore" class="btn {{isset($organization->uid )?'btn-primary':'btn-success'}}" value="{{isset($organization->uid)?'Update Organization & More':'Add Organization & More'}}" />
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