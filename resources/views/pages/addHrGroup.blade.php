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
                <div class="table-responsive">
                    <form name="hrInfo" id="hrInfo" method="POST"
                        action="{{isset($hr->uid)? route('request.updateHrGroup',$hr->uid):route('request.addHrGroups')}}">
                        <fieldset>
                            <legend>Add Hr Group</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($hr))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="hr_category" name="Hr Category"
                                            :className="$modelClass=App\Models\HrCategory::class" colorClass="danger"
                                            :oldData='$hr->hr_category' btnName="Add Category" />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="hr_category" name="Hr Category"
                                            :className="$modelClass=App\Models\HrCategory::class" colorClass="primary"
                                            :oldData='null' btnName="Add Category" />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="hr_category" class="form-label">Hr
                                                Category</label>
                                            <select name="hr_category" id="hr_category" class="form-select">
                                                <option value="" selected disabled hidden> Select Hr
                                                    Category
                                                </option>
                                                @foreach (\App\Models\HrCategory::all() as $category)
                                                <option value="{{$category->display_name}}" {{isset($hr->
                                                    hr_category) ? ($hr->hr_category ==
                                                    $category->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($hr->hr_category)
                                                    ?$hr->hr_category:$category->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_name" class="form-label">Hr Name</label>
                                            <input name="hr_name" type="text" class="form-control" id="hr_name"
                                                placeholder="Hr Name" value="{{isset($hr) ? $hr->hr_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_address" class="form-label">Hr Address</label>
                                            <input name="hr_address" type="text" class="form-control" id="hr_address"
                                                placeholder="Hr Address" value="{{isset($hr) ? $hr->hr_address : ''}}"
                                                required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($hr))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="type" name="Type" :className="$modelClass=App\Models\HrType::class"
                                            colorClass="success" :oldData='$hr->hr_type' />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="type" name="Type" :className="$modelClass=App\Models\HrType::class"
                                            colorClass="success" :oldData='null' />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="hr_type" class="form-label">Hr Type</label>
                                            <select name="hr_type" id="hr_type" class="form-select">
                                                <option value="" selected disabled hidden> Select Hr Type
                                                </option>
                                                @foreach (\App\Models\HrType::all() as $type)
                                                <option value="{{$type->display_name}}" {{isset($hr->
                                                    hr_type) ? ($hr->hr_type ==
                                                    $type->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($hr->hr_type)
                                                    ?$hr->hr_type:$type->display_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($hr))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="hr_country" name="Hr Country"
                                            :className="$modelClass=App\Models\Country::class" colorClass="warning"
                                            :oldData='$hr->hr_country' btnName="Add Country" />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="hr_country" name="Hr Country"
                                            :className="$modelClass=App\Models\Country::class" colorClass="warning"
                                            :oldData='null' btnName="Add Country" />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="hr_country" class="form-label">Country</label>
                                            <select name="hr_country" id="hr_country" class="form-select">
                                                <option value="" selected disabled hidden> Select Country
                                                </option>
                                                @foreach (\App\Models\Country::all() as $country)
                                                <option value="{{$country->display_name}}" {{isset($hr->
                                                    hr_country) ? ($hr->hr_country ==
                                                    $country->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($hr->hr_country)
                                                    ?$hr->hr_country:$country->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_city" class="form-label">City</label>
                                            <input name="hr_city" type="text" class="form-control" id="hr_city"
                                                placeholder="Karachi" value="{{isset($hr) ? $hr->hr_city : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="hr_contact" class="form-label">Hr Phone/Mobile
                                                Number</label>
                                            <input name="hr_contact" type="text" minlength='11' maxlength='11'
                                                class="form-control" id="hr_contact" placeholder="Hr Contact Number"
                                                value="{{isset($hr) ? $hr->hr_contact : ''}}" minlength='0'
                                                maxlength='14' onchange="isContact('contact')"
                                                title="14 DIGIT PHONE NUMBET" data-inputmask="'mask': '+99-9999999999'"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <label for="staff_quantity" class="form-label">Functionary Staff
                                                Quantity</label>
                                            <input name="staff_quantity" type="number" class="form-control"
                                                id="staff_quantity" placeholder="5"
                                                value="{{isset($hr) ? $hr->staff_quantity : ''}}" title="Staff Quanity"
                                                min="1" max="500" maxlength="3" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_ntn" class="form-label">NTN Number</label>
                                            <input name="hr_ntn" type="number" class="form-control" id="hr_ntn"
                                                placeholder="Hr NTN" value="{{isset($hr) ? $hr->hr_ntn : ''}}"
                                                onchange="isNumeric('identity')" title="NTN Number" required
                                                maxlength="15" required />
                                        </div>
                                    </div> --}}

                                </div>
                                <br />
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_owner" class="form-label">Hr Owner Name</label>
                                            <input name="hr_owner" type="text" class="form-control" id="hr_owner"
                                                placeholder="Hr Owner Name" value="{{isset($hr) ? $hr->hr_owner : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_owner_designation" class="form-label">Hr Owner
                                                Designation</label>
                                            <input name="hr_owner_designation" type="text" class="form-control"
                                                id="hr_owner_designation" placeholder="Hr Owner Designation"
                                                value="{{isset($hr) ? $hr->hr_owner_designation : ''}}" required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_owner_contact" class="form-label">Hr Owner
                                                Contact</label>
                                            <input name="hr_owner_contact" type="number" class="form-control"
                                                id="hr_owner_contact" placeholder="Hr Owner Contact"
                                                value="{{isset($hr) ? $hr->hr_owner_contact: ''}}" minlength='11'
                                                maxlength='11' required />
                                        </div>

                                    </div>
                                </div>
                                <br />
                                <h4>Account Details</h4>
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_rep_name" class="form-label">Account Name</label>
                                            <input name="hr_rep_name" type="text" class="form-control" id="hr_rep_name"
                                                placeholder="Hr Rep Name" value="{{isset($hr) ? $hr->hr_rep_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_rep_designation" class="form-label">Hr Rep
                                                Designation</label>
                                            <input name="hr_rep_designation" type="text" class="form-control"
                                                id="hr_rep_designation" placeholder="Hr Rep Designation"
                                                value="{{isset($hr) ? $hr->hr_rep_designation : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_rep_dept" class="form-label">Hr Rep
                                                Department</label>
                                            <input name="hr_rep_dept" type="text" class="form-control" id="hr_rep_dept"
                                                placeholder="Hr Rep Department"
                                                value="{{isset($hr) ? $hr->hr_rep_dept : ''}}" required />
                                        </div>
                                    </div> --}}
                                    {{--
                                </div>
                                <div class="row"> --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_rep_contact" class="form-label">Account
                                                Contact Number</label>
                                            <input name="hr_rep_contact" type="text" class="form-control"
                                                id="hr_rep_contact" placeholder="Hr Rep Contact"
                                                value="{{isset($hr) ? $hr->hr_rep_contact : ''}}" minlength='11'
                                                maxlength='11' required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_rep_email" class="form-label">Account Email</label>
                                            <input name="hr_rep_email" type="text" class="form-control"
                                                id="hr_rep_email" placeholder="Hr Rep Email"
                                                value="{{isset($hr) ? $hr->hr_rep_email  : ''}}" required {{isset($hr)
                                                ? 'disabled' : '' }} />
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_rep_phone" class="form-label">Hr Rep Phone</label>
                                            <input name="hr_rep_phone" type="text" class="form-control"
                                                id="hr_rep_phone" placeholder="Hr Rep Phone"
                                                value="{{isset($hr) ? $hr->hr_rep_phone : ''}}" required />
                                        </div>
                                    </div> --}}
                                </div>
                                <br />
                                <br />
                                <div class="row">
                                    {{-- <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submit"
                                                class="btn {{isset($hr->uid )?'btn-success':'btn-primary'}}"
                                                value="{{isset($hr->uid)?'Update HrGroup':'Add HrGroup'}}" />
                                        </div>
                                    </div> --}}
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore"
                                                class="btn {{isset($hr->uid )?'btn-primary':'btn-success'}}"
                                                value="{{isset($hr->uid)?'Update HrGroup & More':'Add HrGroup & More'}}" />
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