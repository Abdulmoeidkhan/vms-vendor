@auth
@extends('layouts.layout')
@section("content")
@if(session()->get('user')->roles[0]->name =="admin")
<div class="row">
    <div class="col-lg-6 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Organization</h5>
                    </div>
                    {{-- <div>
                        <select class="form-select">
                            <option value="1">March 2023</option>
                            <option value="2">April 2023</option>
                            <option value="3">May 2023</option>
                            <option value="4">June 2023</option>
                        </select>
                    </div> --}}
                </div>
                <div id="orgchart"></div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Media</h5>
                    </div>
                    {{-- <div>
                        <select class="form-select">
                            <option value="1">March 2023</option>
                            <option value="2">April 2023</option>
                            <option value="3">May 2023</option>
                            <option value="4">June 2023</option>
                        </select>
                    </div> --}}
                </div>
                <div id="mediaChart"></div>
            </div>
        </div>
    </div>
</div>
@elseif(session()->get('user')->roles[0]->name =="orgRep")
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <h5 class="card-title fw-semibold">Organization</h5>
                    </div>
                    {{-- <div>
                        <select class="form-select">
                            <option value="1">March 2023</option>
                            <option value="2">April 2023</option>
                            <option value="3">May 2023</option>
                            <option value="4">June 2023</option>
                        </select>
                    </div> --}}
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
                        <h5 class="card-title fw-semibold">Media</h5>
                    </div>
                    {{-- <div>
                        <select class="form-select">
                            <option value="1">March 2023</option>
                            <option value="2">April 2023</option>
                            <option value="3">May 2023</option>
                            <option value="4">June 2023</option>
                        </select>
                    </div> --}}
                </div>
                <div id="mediaRepchart"></div>
            </div>
        </div>
    </div>
</div>
{{-- <div class="row">
    <div class="col-xs-6 ">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Delegation</h5>
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="fw-semibold mb-3">
                        </h4>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">Accepted</span>
                            </div>
                            <div class="me-2">
                                <span class="round-8 bg-warning rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">Awaited</span>
                            </div>
                            <div>
                                <span class="round-8 bg-badar rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">Regretted</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-center">
                            <div id="breakup"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 ">
        <div class="card overflow-hidden">
            <div class="card-body p-4">
                <h5 class="card-title mb-9 fw-semibold">Flights</h5>
                <div class="row align-items-center">
                    <div class="col-8">
                        <h4 class="fw-semibold mb-3">
                        </h4>
                        <div class="d-flex align-items-center">
                            <div class="me-2">
                                <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">Departed</span>
                            </div>
                            <div class="me-2">
                                <span class="round-8 bg-warning rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">Arrived</span>
                            </div>
                            <div>
                                <span class="round-8 bg-badar rounded-circle me-2 d-inline-block"></span>
                                <span class="fs-2">Not Arrived</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="d-flex justify-content-center">
                            <div id="intlDelegation"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12 d-flex align-items-strech">
        <div class="card w-100">
            <div class="card-body">
                <h5 class="card-title mb-9 fw-semibold">Officer Chart</h5>
                <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                    <div class="mb-3 mb-sm-0">
                        <!-- <h5 class="card-title fw-semibold">Officers</h5> -->
                    </div>
                </div>
                <div id="officerchart"></div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-6 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Delegates</h5>
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h4 class="fw-semibold mb-3">
                                </h4>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-2">Active</span>
                                    </div>
                                    <div class="me-2">
                                        <span class="round-8 bg-warning rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-2">InActive</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-flex justify-content-center">
                                    <div id="delegatechart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-6 ">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="card-body p-4">
                        <h5 class="card-title mb-9 fw-semibold">Golf Players</h5>
                        <div class="row align-items-center">
                            <div class="col-4">
                                <h4 class="fw-semibold mb-3">
                                </h4>
                                <div class="d-flex align-items-center">
                                    <div class="me-2">
                                        <span class="round-8 bg-primary rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-2">Player</span>
                                    </div>
                                    <div class="me-2">
                                        <span class="round-8 bg-warning rounded-circle me-2 d-inline-block"></span>
                                        <span class="fs-2">Non Player</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-8">
                                <div class="d-flex justify-content-center">
                                    <div id="delegategolfchart"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> --}}
<br />
@endif
@endsection
@endauth