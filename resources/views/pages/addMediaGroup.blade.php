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
                    <form name="mediaGroupinfo" id="mediaGroupinfo" method="POST"
                        action="{{isset($mediagroup->uid)? route('request.updateOrganization',$mediagroup->uid):route('request.addOrganization')}}">
                        <fieldset>
                            <legend>Add Media Group</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($mediagroup))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="media_category" name="Media Group Category"
                                            :className="$modelClass=App\Models\MediaCategory::class" colorClass="danger"
                                            :oldData='$mediagroup->media_category' btnName="Add Media Group" />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="media_category" name="Media Group Category"
                                            :className="$modelClass=App\Models\MediaCategory::class"
                                            colorClass="primary" :oldData='null' btnName="Add Media Group" />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="media_category" class="form-label">Media
                                                Category</label>
                                            <select name="media_category" id="media_category" class="form-select">
                                                <option value="" selected disabled hidden> Select Media
                                                    Category
                                                </option>
                                                @foreach (\App\Models\MediaCategory::all() as $mediacategory)
                                                <option value="{{$mediacategory->display_name}}" {{isset($mediagroup->
                                                    media_category) ? ($mediagroup->media_category ==
                                                    $mediacategory->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($mediagroup->media_category)
                                                    ?$mediagroup->media_category:$mediacategory->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_name" class="form-label">Media Name</label>
                                            <input name="media_name" type="text" class="form-control"
                                                id="media_name" placeholder="Media Name"
                                                value="{{isset($mediagroup) ? $mediagroup->media_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_address" class="form-label">Media Address</label>
                                            <input name="media_address" type="text" class="form-control"
                                                id="media_address" placeholder="Media Address"
                                                value="{{isset($mediagroup) ? $mediagroup->media_address : ''}}"
                                                required />
                                        </div>

                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($mediagroup))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="media_country" name="Media Group Country"
                                            :className="$modelClass=App\Models\Country::class" colorClass="warning"
                                            :oldData='$mediagroup->media_country' btnName="Add Country" />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="media_country" name="Media Group Country"
                                            :className="$modelClass=App\Models\Country::class" colorClass="warning"
                                            :oldData='null' btnName="Add Country" />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="media_country" class="form-label">Country</label>
                                            <select name="media_country" id="media_country" class="form-select">
                                                <option value="" selected disabled hidden> Select Country
                                                </option>
                                                @foreach (\App\Models\Country::all() as $country)
                                                <option value="{{$country->display_name}}" {{isset($mediagroup->
                                                    media_country) ? ($mediagroup->media_country ==
                                                    $country->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($mediagroup->media_country)
                                                    ?$mediagroup->media_country:$country->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_city" class="form-label">City</label>
                                            <input name="media_city" type="text" class="form-control"
                                                id="media_city" placeholder="Karachi"
                                                value="{{isset($mediagroup) ? $mediagroup->media_city : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="media_contact" class="form-label">Media Phone/Mobile
                                                Number</label>
                                            <input name="media_contact" type="text" minlength='11' maxlength='11'
                                                class="form-control" id="media_contact"
                                                placeholder="Media Contact Number"
                                                value="{{isset($mediagroup) ? $mediagroup->media_contact : ''}}"
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
                                                value="{{isset($mediagroup) ? $mediagroup->staff_quantity : ''}}"
                                                title="Staff Quanity" min="1" max="500" maxlength="3" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                </div>
                                <br />
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_owner" class="form-label">Media Owner Name</label>
                                            <input name="media_owner" type="text" class="form-control"
                                                id="media_owner" placeholder="Media Owner Name"
                                                value="{{isset($mediagroup) ? $mediagroup->media_owner : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_owner_designation" class="form-label">Media Owner
                                                Designation</label>
                                            <input name="media_owner_designation" type="text" class="form-control"
                                                id="media_owner_designation" placeholder="Media Owner Designation"
                                                value="{{isset($mediagroup) ? $mediagroup->media_owner_designation : ''}}"
                                                required />
                                        </div>

                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_owner_contact" class="form-label">Media Owner
                                                Contact</label>
                                            <input name="media_owner_contact" type="number" class="form-control"
                                                id="media_owner_contact" placeholder="Media Owner Contact"
                                                value="{{isset($mediagroup) ? $mediagroup->media_owner_contact: ''}}"
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
                                            <label for="media_rep_name" class="form-label">Account Name</label>
                                            <input name="media_rep_name" type="text" class="form-control"
                                                id="media_rep_name" placeholder="Media Rep Name"
                                                value="{{isset($mediagroup) ? $mediagroup->media_rep_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_rep_contact" class="form-label">Account
                                                Contact Number</label>
                                            <input name="media_rep_contact" type="text" class="form-control"
                                                id="media_rep_contact" placeholder="Media Rep Contact"
                                                value="{{isset($mediagroup) ? $mediagroup->media_rep_contact : ''}}"
                                                minlength='11' maxlength='11' required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="media_rep_email" class="form-label">Account Email</label>
                                            <input name="media_rep_email" type="text" class="form-control"
                                                id="media_rep_email" placeholder="Media Rep Email"
                                                value="{{isset($mediagroup) ? $mediagroup->media_rep_email  : ''}}"
                                                required {{isset($mediagroup) ? 'disabled' : '' }} />
                                        </div>
                                    </div>
                                </div>
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore"
                                                class="btn {{isset($mediagroup->uid )?'btn-primary':'btn-success'}}"
                                                value="{{isset($mediagroup->uid)?'Update Media Group & More':'Add Media Group & More'}}" />
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