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
                    <form name="depoInfo" id="depoInfo" method="POST"
                        action="{{isset($depoGroups->uid)? route('request.updateDepoGroup',$depoGroups->uid):route('request.addDepoGroup')}}">
                        <fieldset>
                            <legend>Add Depo Guest Group</legend>
                            @csrf
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="depo_rep_name" class="form-label">Depo Rep Name</label>
                                            <input name="depo_rep_name" type="text" class="form-control"
                                                id="depo_rep_name" placeholder="Depo Rep Name"
                                                value="{{isset($depoGroups) ? $depoGroups->depo_rep_name : ''}}"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="depo_rep_contact" class="form-label">Depo Rep Contact
                                                Number</label>
                                            <input name="depo_rep_contact" type="text" minlength='11'
                                                class="form-control" id="depo_rep_contact"
                                                placeholder="Depo Contact Number"
                                                value="{{isset($depoGroups) ? $depoGroups->depo_rep_contact : ''}}"
                                                maxlength='14' onchange="isContact('contact')"
                                                title="14 DIGIT PHONE NUMBET" data-inputmask="'mask': '+99-9999999999'"
                                                required />
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="depo_rep_email" class="form-label">Depo Rep Email</label>
                                            <input name="depo_rep_email" type="text" class="form-control"
                                                id="depo_rep_email" placeholder="Depo Rep Email"
                                                value="{{isset($depoGroups) ? $depoGroups->depo_rep_email : ''}}"
                                                {{isset($depoGroups->depo_rep_email) ? 'disabled' : '' }} />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4">
                                        @if(session()->get('user')->roles[0]->name === "admin")
                                        @if(isset($depoGroups))
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="depo_category" name="Depo Category" colorClass="danger"
                                            :className="$modelClass=App\Models\HrCategory::class" btnName="Add Category"
                                            :oldData='$depoGroups->depo_category' />
                                        @else
                                        <livewire:modal-form-component wire:id="{{rand()}}" wire:key="{{rand()}}"
                                            modalId="depo_category" name="Depo Category" btnName="Add Category"
                                            :className="$modelClass=App\Models\HrCategory::class" colorClass="primary"
                                            :oldData='null' />
                                        @endif
                                        @else
                                        <div class="mb-3">
                                            <label for="depo_category" class="form-label">Depo
                                                Category</label>
                                            <select name="depo_category" id="depo_category" class="form-select">
                                                <option value="" selected disabled hidden> Select Depo
                                                    Category
                                                </option>
                                                @foreach (\App\Models\HrCategory::all() as $category)
                                                <option value="{{$category->display_name}}" {{isset($depoGroups->
                                                    depo_category) ? ($depoGroups->depo_category ==
                                                    $category->display_name ? 'selected' : '')
                                                    : ''}}>{{isset($depoGroups->depo_category)
                                                    ?$depoGroups->depo_category:$category->display_name}}
                                                </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="staff_quantity" class="form-label">Depo Guest Quantity</label>
                                            <input name="staff_quantity" type="number" class="form-control"
                                                id="staff_quantity" placeholder="5"
                                                value="{{isset($depoGroups) ? $depoGroups->staff_quantity : ''}}"
                                                title="Guest Quanity" min="1" max="500" maxlength="3" required />
                                        </div>
                                    </div>
                                    {{-- <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="hr_owner_contact" class="form-label">Depo Rep
                                                Contact</label>
                                            <input name="depo_rep_phone" type="number" class="form-control"
                                                id="depo_rep_phone" placeholder="Depo Rep Contact"
                                                value="{{isset($depoGroups) ? $depoGroups->depo_rep_phone: ''}}"
                                                minlength='11' maxlength='11' required />
                                        </div>
                                    </div> --}}
                                </div>
                                <br />
                                <br />
                                <div class="row">
                                    <div class="col-md-2">
                                        <div class="mb-3">
                                            <input type="submit" name="submitMore"
                                                class="btn {{isset($depoGroups->uid )?'btn-primary':'btn-success'}}"
                                                value="{{isset($depoGroups->uid)?'Update Depo Group & More':'Add Depo Group & More'}}" />
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