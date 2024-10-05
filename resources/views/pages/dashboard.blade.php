@auth
@extends('layouts.layout')
@section("content")
@if(session()->get('user')->roles[0]->name =="admin" || session()->get('user')->roles[0]->name =="media" || session()->get('user')->roles[0]->name =="bxssUser")
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Media</h5>
                    </div>
                </div>
                <div id="mediaChart"></div>
            </div>
        </div>
    </div>
</div>
@if(session()->get('user')->roles[0]->name =="admin" || session()->get('user')->roles[0]->name =="bxssUser")
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Organization</h5>
                    </div>
                </div>
                <div id="orgchart"></div>
            </div>
        </div>
    </div>
</div>
@endif
@if(session()->get('user')->roles[0]->name =="admin" || session()->get('user')->roles[0]->name =="bxssUser")
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">HR</h5>
                    </div>
                </div>
                <div id="hrChart"></div>
            </div>
        </div>
    </div>
</div>
@endif
@elseif(session()->get('user')->roles[0]->name =="orgRep")
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        @foreach(\App\Models\Organization::where('uid',session()->get('user')->uid)->get() as $organization)
                        <h5 class="card-title fw-semibold">{{$organization->company_name}}</h5>
                        @endforeach
                    </div>
                </div>
                <div id="orgRepchart"></div>
            </div>
        </div>
    </div>
</div>
@elseif(session()->get('user')->roles[0]->name =="mediaRep")
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        @foreach (\App\Models\MediaGroup::where('uid',session()->get('user')->uid)->get() as $media)
                        <h5 class="card-title fw-semibold">{{$media->media_name}}</h5>
                        @endforeach
                    </div>
                </div>
                <div id="mediaRepchart"></div>
            </div>
        </div>
    </div>
</div>
@elseif(session()->get('user')->roles[0]->name =="hrRep")
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        @foreach (\App\Models\HrGroup::where('uid',session()->get('user')->uid)->get() as $hr)
                        <h5 class="card-title fw-semibold">{{$hr->hr_name}}</h5>
                        @endforeach
                    </div>
                </div>
                <div id="hrRepchart"></div>
            </div>
        </div>
    </div>
</div>
<br />
@endif
@endsection
@endauth