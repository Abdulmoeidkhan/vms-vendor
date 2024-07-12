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
                {{-- <h5 class="card-ti tle fw-semibold mb-4">New Organization</h5> --}}
                <div class="table-responsive">
                    <form name="organizationInfo" id="organizationInfo" method="POST"
                        action="{{isset($organization->uid)? route('request.updateOrganization',$organization->uid):route('request.addOrganization')}}">
                        <fieldset>
                            <legend>Add Organization</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($organization))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="category" name="Category"
                                            :className="$modelClass=App\Models\CompanyCategory::class"
                                            colorClass="danger" :oldData='$organization->company_category' />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="category" name="Category"
                                            :className="$modelClass=App\Models\CompanyCategory::class"
                                            colorClass="primary" :oldData='null' />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="company_category" class="form-label">Company
                                                Category</label>
                                            <select name="company_category" id="company_category" class="form-select">
                                                <option value="" selected disabled hidden> Select Company
                                                    Category
                                                </option>
                                                @foreach (\App\Models\CompanyCategory::all() as $category)
                                                <option value="{{$category->display_name}}" {{isset($organization->
                                                    company_category) ? ($organization->company_category ==
                                                    $category->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($organization->company_category)
                                                    ?$organization->company_category:$category->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_name" class="form-label">Company Name</label>
                                            <input name="company_name" type="text" class="form-control"
                                                id="company_name" placeholder="Company Name"
                                                value="{{isset($organization) ? $organization->company_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_address" class="form-label">Company Address</label>
                                            <input name="company_address" type="text" class="form-control"
                                                id="company_address" placeholder="Company Address"
                                                value="{{isset($organization) ? $organization->company_address : ''}}"
                                                required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($organization))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="type" name="Type"
                                            :className="$modelClass=App\Models\CompanyType::class" colorClass="success"
                                            :oldData='$organization->company_type' />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="type" name="Type"
                                            :className="$modelClass=App\Models\CompanyType::class" colorClass="success"
                                            :oldData='null' />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="company_type" class="form-label">Company Type</label>
                                            <select name="company_type" id="company_type" class="form-select">
                                                <option value="" selected disabled hidden> Select Company Type
                                                </option>
                                                @foreach (\App\Models\CompanyType::all() as $type)
                                                <option value="{{$type->display_name}}" {{isset($organization->
                                                    company_type) ? ($organization->company_type ==
                                                    $type->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($organization->company_type)
                                                    ?$organization->company_type:$type->display_name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div> --}}
                                    <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($organization))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="country" name="Country"
                                            :className="$modelClass=App\Models\Country::class" colorClass="warning"
                                            :oldData='$organization->company_country' />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="country" name="Country"
                                            :className="$modelClass=App\Models\Country::class" colorClass="warning"
                                            :oldData='null' /> @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="company_country" class="form-label">Country</label>
                                            <select name="company_country" id="company_country" class="form-select">
                                                <option value="" selected disabled hidden> Select Country
                                                </option>
                                                @foreach (\App\Models\Country::all() as $country)
                                                <option value="{{$country->display_name}}" {{isset($organization->
                                                    company_country) ? ($organization->company_country ==
                                                    $country->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($organization->company_country)
                                                    ?$organization->company_country:$country->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="company_city" class="form-label">City</label>
                                            <input name="company_city" type="text" class="form-control"
                                                id="company_city" placeholder="Karachi"
                                                value="{{isset($organization) ? $organization->company_city : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="company_contact" class="form-label">Company Phone/Mobile
                                                Number</label>
                                            <input name="company_contact" type="text" minlength='11' maxlength='11'
                                                class="form-control" id="company_contact"
                                                placeholder="Company Contact Number"
                                                value="{{isset($organization) ? $organization->company_contact : ''}}"
                                                minlength='0' maxlength='14' onchange="isContact('contact')"
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
                                                value="{{isset($organization) ? $organization->staff_quantity : ''}}"
                                                title="Staff Quanity" min="1" max="500" maxlength="3" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_ntn" class="form-label">NTN Number</label>
                                            <input name="company_ntn" type="number" class="form-control"
                                                id="company_ntn" placeholder="Company NTN"
                                                value="{{isset($organization) ? $organization->company_ntn : ''}}"
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
                                            <label for="company_owner" class="form-label">Company Owner Name</label>
                                            <input name="company_owner" type="text" class="form-control"
                                                id="company_owner" placeholder="Company Owner Name"
                                                value="{{isset($organization) ? $organization->company_owner : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_owner_designation" class="form-label">Company Owner
                                                Designation</label>
                                            <input name="company_owner_designation" type="text" class="form-control"
                                                id="company_owner_designation" placeholder="Company Owner Designation"
                                                value="{{isset($organization) ? $organization->company_owner_designation : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_owner_contact" class="form-label">Company Owner
                                                Contact</label>
                                            <input name="company_owner_contact" type="number" class="form-control"
                                                id="company_owner_contact" placeholder="Company Owner Contact"
                                                value="{{isset($organization) ? $organization->company_owner_contact: ''}}"
                                                minlength='11' maxlength='11' required />
                                        </div>

                                    </div>
                                </div>
                                <br />
                                <h4>Account Details</h4>
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_name" class="form-label">Account Name</label>
                                            <input name="company_rep_name" type="text" class="form-control"
                                                id="company_rep_name" placeholder="Company Rep Name"
                                                value="{{isset($organization) ? $organization->company_rep_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_designation" class="form-label">Company Rep
                                                Designation</label>
                                            <input name="company_rep_designation" type="text" class="form-control"
                                                id="company_rep_designation" placeholder="Company Rep Designation"
                                                value="{{isset($organization) ? $organization->company_rep_designation : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_dept" class="form-label">Company Rep
                                                Department</label>
                                            <input name="company_rep_dept" type="text" class="form-control"
                                                id="company_rep_dept" placeholder="Company Rep Department"
                                                value="{{isset($organization) ? $organization->company_rep_dept : ''}}"
                                                required />
                                        </div>
                                    </div> --}}
                                    {{--
                                </div>
                                <div class="row"> --}}
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_contact" class="form-label">Account
                                                Contact Number</label>
                                            <input name="company_rep_contact" type="text" class="form-control"
                                                id="company_rep_contact" placeholder="Company Rep Contact"
                                                value="{{isset($organization) ? $organization->company_rep_contact : ''}}"
                                                minlength='11' maxlength='11' required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_email" class="form-label">Account Email</label>
                                            <input name="company_rep_email" type="text" class="form-control"
                                                id="company_rep_email" placeholder="Company Rep Email"
                                                value="{{isset($organization) ? $organization->company_rep_email  : ''}}"
                                                required {{isset($organization) ? 'disabled' : '' }} />
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="company_rep_phone" class="form-label">Company Rep Phone</label>
                                            <input name="company_rep_phone" type="text" class="form-control"
                                                id="company_rep_phone" placeholder="Company Rep Phone"
                                                value="{{isset($organization) ? $organization->company_rep_phone : ''}}"
                                                required />
                                        </div>
                                    </div> --}}
                                </div>
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submit"
                                                class="btn {{isset($organization->uid )?'btn-success':'btn-primary'}}"
                                                value="{{isset($organization->uid)?'Update Organization':'Add Organization'}}" />
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore"
                                                class="btn {{isset($organization->uid )?'btn-primary':'btn-success'}}"
                                                value="{{isset($organization->uid)?'Update Organization & More':'Add Organization & More'}}" />
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