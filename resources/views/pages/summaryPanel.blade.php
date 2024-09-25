@auth
@extends('layouts.layout')
@section("content")


<div class="row">
    <div class="card w-100">
        <div class="card-body p-4">
            <h5 class="card-title fw-semibold mb-4">Summary Panel</h5>
            @foreach ($majorcategories as $key => $categories )
            <div class="accordion mb-2" id="accordion{{$key}}">
                <div class="accordion-item">
                    <h2 class="accordion-header bg-dark">
                        <div class="row">
                            <div class="col-md-2 bg-dark">
                                <button class="accordion-button bg-dark" type="button"
                                    data-bs-toggle="collapse" data-bs-target="#collapse{{$key}}" aria-expanded="true"
                                    aria-controls="collapse{{$key}}">
                                </button>
                            </div>
                            <div class="col-md-5 mt-2">
                                <h3 class="text-white">
                                    {{$categories['name']}}</h3>
                            </div>
                            <div class="col-md-1">
                                <span
                                    class="badge mx-auto bg-primary rounded-3 fw-semibold">{{$categories['value'][count($categories)-1]['total']}}
                                </span>
                            </div>
                            <div class="col-md-1">
                                <span
                                    class="badge mx-auto bg-danger rounded-3 fw-semibold">{{$categories['value'][count($categories)-1]['sent']}}</span>
                            </div>
                            <div class="col-md-1">
                                <span
                                    class="badge mx-auto bg-warning rounded-3 fw-semibold">{{$categories['value'][count($categories)-1]['pending']}}</span>
                            </div>
                            <div class="col-md-1">
                                <span
                                    class="badge mx-auto bg-success rounded-3 fw-semibold">{{$categories['value'][count($categories)-1]['approved']}}</span>
                            </div>
                            <div class="col-md-1">
                                <span
                                    class="badge mx-auto bg-badar rounded-3 fw-semibold">{{$categories['value'][count($categories)-1]['rejected']}}</span>
                            </div>
                        </div>

                    </h2>
                    <div id="collapse{{$key}}" class="accordion-collapse collapse show"
                        data-bs-parent="#accordion{{$key}}">
                        <div class="accordion-body">
                            <div class="table-responsive">
                                <table class="table text-nowrap mb-0 align-middle">
                                    <thead class="text-dark fs-4">
                                        <tr>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">S.No</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Name</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Total</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Sent For Approval</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Pending</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Approved</h6>
                                            </th>
                                            <th class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">Rejected</h6>
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($categories['value'] as $index => $category)
                                        <tr>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-0">{{$index+1}}</h6>
                                            </td>
                                            <td class="border-bottom-0">
                                                <h6 class="fw-semibold mb-1 text-capitalize">
                                                    {{$category['entity_name']}}
                                            </td>
                                            <td class="border-bottom-0">
                                                <span
                                                    class="badge mx-auto bg-primary rounded-3 fw-semibold">{{$category['total']}}</span>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="badge mx-auto bg-danger rounded-3 fw-semibold">{{$category['sent']}}</span>
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="badge mx-auto bg-warning rounded-3 fw-semibold">{{$category['pending']}}</span>
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="badge mx-auto bg-success rounded-3 fw-semibold">{{$category['approved']}}</span>
                                                </div>
                                            </td>
                                            <td class="border-bottom-0">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span
                                                        class="badge mx-auto bg-badar rounded-3 fw-semibold">{{$category['rejected']}}</span>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
@endauth