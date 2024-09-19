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
        <li class="breadcrumb-item"><a href="/depoGroups">Home</a></li>
        @if(isset($uid))
        <li class="breadcrumb-item"><a href="/depoGroup/{{$uid}}">
                @foreach (\App\Models\DepoGroup::where('uid', $uid)->get('depo_rep_name') as $item)
                {{$item->depo_rep_name}}
                @endforeach
            </a></li>
        @endif
        <li class="breadcrumb-item active" aria-current="page">Guests</li>
    </ol>
</nav>
<div class="row">
    <div class="col-lg-12 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <h5 class="card-ti tle fw-semibold mb-4">New Guest</h5>
                <div class="table-responsive">
                    <form name="guestInfo" id="guestInfo" method="POST"
                        action="{{isset($guest->uid)? route('request.updateDepoGuest',$guest->uid):route('request.addDepoGuest',$uid)}}">
                        <fieldset>
                            <legend>Add Form</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="depo_guest_rank" class="form-label">Rank</label>
                                            <select name="depo_guest_rank" id="depo_guest_rank" class="form-select"
                                                required>
                                                <option value="" disabled hidden> Select Pass Type </option>
                                                @foreach (\App\Models\Rank::all() as $key=>$rank)
                                                <option value="{{$rank->id}}" {{isset($guest)&& $guest->depo_guest_rank
                                                    == $rank->id ? 'selected' : ''}} > {{$rank->ranks_name}} </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="depo_guest_name" class="form-label">Name</label>
                                            <input name="depo_guest_name" type="text" class="form-control"
                                                id="depo_guest_name" placeholder="Name"
                                                value="{{isset($guest) ? $guest->depo_guest_name : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="depo_guest_contact" class="form-label">Contact Number</label>
                                            <input name="depo_guest_contact" type="text" minlength='11' maxlength='12'
                                                class="form-control" id="depo_guest_contact"
                                                placeholder="Contact Number"
                                                value="{{isset($guest) ? $guest->depo_guest_contact : ''}}"
                                                minlength='0' maxlength='14' onchange="isContact('contact')"
                                                title="14 DIGIT PHONE NUMBER" data-inputmask="'mask': '+99-9999999999'"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="depo_guest_service" class="form-label">Service Number</label>
                                            <input name="depo_guest_service" type="text" minlength='4' maxlength='12'
                                                class="form-control" id="depo_guest_service"
                                                placeholder="Service Number"
                                                value="{{isset($guest) ? $guest->depo_guest_service : ''}}" required />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="depo_guest_designation" class="form-label">Designation</label>
                                            <input name="depo_guest_designation" type="text" class="form-control"
                                                id="depo_guest_designation" placeholder="Designation"
                                                value="{{isset($guest) ? $guest->depo_guest_designation : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="depo_identity" class="form-label">CNIC/Passport</label>
                                            <input name="depo_identity" type="text" pattern="^[a-zA-Z0-9]{9,14}$"
                                                class="form-control" id="depo_identity" placeholder="Identity"
                                                minlength='7' maxlength='13'
                                                value="{{isset($guest) ? $guest->depo_identity : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="depo_guest_email" class="form-label">Account Email</label>
                                            <input name="depo_guest_email" type="text" class="form-control"
                                                id="depo_guest_email" placeholder="Media Rep Email"
                                                value="{{isset($guest) ? $guest->depo_guest_email  : ''}}" required />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="mb-3">
                                            <label for="badge_type" class="form-label">Badge Type</label>
                                            <select name="badge_type" id="badge_type" class="form-select" required>
                                                <option value="" {{isset($guest->badge_type)?'':'selected'}} disabled
                                                    hidden> Select Pass Type </option>
                                                <option value="Trade_visitor" {{isset($guest->
                                                    badge_type)?$guest->badge_type ==
                                                    'Trade_visitor'?'selected':'':''}}>Trade Visitor</option>
                                                <option value="Volunteer" {{isset($guest->badge_type)?$guest->badge_type
                                                    ==
                                                    'Volunteer'?'selected':'':''}}>Volunteer</option>
                                                <option value="Local_delegate" {{isset($guest->
                                                    badge_type)?$guest->badge_type ==
                                                    'Local_delegate'?'selected':'':''}}>Local Delegate</option>
                                                <option value="Organiser" {{isset($guest->badge_type)?$guest->badge_type
                                                    ==
                                                    'Organiser'?'selected':'':''}}>Organiser</option>
                                                <option value="Event_manager" {{isset($guest->
                                                    badge_type)?$guest->badge_type ==
                                                    'Event_manager'?'selected':'':''}}>Event Manager</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <br />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore"
                                                class="btn {{isset($guest->uid )?'btn-primary':'btn-success'}}"
                                                value="{{isset($guest->uid)?'Update & Next':'Add & Next'}}" />
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
@if(isset($guest->uid))
<script src='https://cdnjs.cloudflare.com/ajax/libs/cropperjs/0.8.1/cropper.min.js'></script>
<div class="row">
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <livewire:image-upload-component :uid="$guest->uid" title="Image" name="staff_picture" />
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <livewire:image-upload-component :uid="$guest->uid" title="CNIC Front" name="cnic_front_picture" />
            </div>
        </div>
    </div>
    <div class="col-lg-4 d-flex align-items-stretch">
        <div class="card w-100">
            <div class="card-body p-4">
                <livewire:image-upload-component :uid="$guest->uid" title="CNIC Back" name="cnic_back_picture" />
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