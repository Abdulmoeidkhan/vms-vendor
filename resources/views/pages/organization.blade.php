@auth
@extends('layouts.layout')
@section("content")
@if (session('error'))
<script>
    alert("{{session('error')}}");
</script>
@endif
<style>
    body {
        font-family: Arial;
    }

    /* Style the tab */
    .tab {
        overflow: hidden;
        border: 1px solid #ccc;
        background-color: #f1f1f1;
    }

    .active {
        color: green;
        font-weight: bold;
    }

    /* Style the buttons inside the tab */
    .tab button {
        background-color: inherit;
        float: left;
        border: none;
        outline: none;
        cursor: pointer;
        padding: 14px 16px;
        transition: 0.3s;
        font-size: 17px;
    }

    /* Change background color of buttons on hover */
    .tab button:hover {
        background-color: #ddd;
    }

    /* Create an active/current tablink class */
    .tab button.active {
        background-color: #ccc;
    }

    /* Style the tab content */
    .tabcontent {
        display: none;
        padding: 0px 12px;
        border: 1px solid #ccc;
        border-top: none;
    }
</style>


<div class="row">
    <div class="card w-100">
        <div class="card-body p-4">
            @if(session()->get('user')->roles[0]->name === "admin" || session()->get('user')->roles[0]->name ===
            "orgRep")
            <div class="row">
                <div class="d-flex">
                    <a type="button" href="{{route('pages.addOrganizationStaff',$id)}}" class="btn btn-primary">Add
                        Staff</a>&nbsp;
                    @if(session()->get('user')->roles[0]->name === "admin")
                    <button id="sent" class="status-action-button btn btn-danger">Sent For
                        Approval</button>&nbsp;
                    <button id="pending" class="status-action-button btn btn-warning">Not Sent For
                        Approval</button>&nbsp;
                    <button id="approved" class="status-action-button btn btn-success">Approved</button>&nbsp;
                    <button id="rejected" class="status-action-button btn btn-badar">Rejected</button>
                    @endif
                </div>
            </div>
            <br />
            <div class="row">
                <div class="d-flex col-4">
                </div>
                <div class="d-flex col-4">
                    <div class="card overflow-hidden">
                        <div class="card-body p-4">
                            <h5 class="card-title text-center mb-9 fw-semibold">Functionary Pass Limit</h5>
                            <h4 class="d-flex justify-content-center mb-9 fw-semibold">
                                {{$functionaryStaffLimit->staff_quantity}}</h4>
                            <div class="align-items-center">
                                <div class="d-flex justify-content-center">
                                    {{-- <br /> --}}
                                    <p>
                                        You have <b>{{$functionaryStaffRemaing}}</b> Remaining Functionary Pass(es) Left
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            {{-- <br /> --}}
            <div class="table-responsive text-capitalize">
                <table id="table" data-filter-control-multiple-search="true" data-click-to-select="true"
                    data-filter-control-multiple-search-delimiter="," data-virtual-scroll="true"
                    data-filter-control="true" data-toggle="table" data-flat="true" data-pagination="true"
                    data-show-toggle="true" data-show-export="true" data-show-columns="true" data-show-refresh="true"
                    data-show-pagination-switch="true" data-show-columns-toggle-all="true"
                    data-page-list="[10, 25, 50, 100]" data-url="{{route('request.getOrganizationStaff',$id)}}">
                    <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-filter-control="input" data-field="SNO" data-formatter="operateSerial">S.No.
                            </th>
                            <th data-filter-control="input" data-field="companyName.company_name" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateText">Company
                                Name</th>
                            <th data-filter-control="input" data-field="staff_first_name" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateFirstAndLastName">Name</th>
                            <th data-filter-control="input" data-field="staff_designation" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateText">Designation </th>
                            <th data-filter-control="input" data-field="staff_department" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateText" data-force-hide="true">Department
                            </th>
                            <th data-filter-control="input" data-field="staff_job_type" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Job Type</th>
                            <th data-filter-control="input" data-field="staff_nationality" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Nationality</th>
                            <th data-filter-control="input" data-field="staff_identity" data-sortable="true"
                                data-formatter="operateText">Identity</th>
                            <th data-filter-control="input" data-field="staff_identity_expiry" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Identity Expiry</th>
                            <th data-filter-control="input" data-field="staff_contact" data-sortable="true"
                                data-formatter="operateText">Contact</th>
                            <th data-filter-control="input" data-field="staff_type" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Pass Type</th>
                            <th data-filter-control="input" data-field="staff_address" data-sortable="true"
                                data-formatter="operateText">Address</th>
                            <th data-filter-control="input" data-field="staff_city" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">City</th>
                            <th data-filter-control="input" data-field="staff_country" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Country</th>
                            <th data-filter-control="input" data-field="staff_dob" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">DOB</th>
                            <th data-filter-control="input" data-field="staff_doj" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">DOJ</th>
                            <th data-filter-control="input" data-field="employee_type" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Employee Type</th>
                            <th data-filter-control="input" data-field="staff_security_status" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Security Status</th>
                            <th data-field="picture.img_blob" data-width="150" data-width-unit="px"
                                data-formatter="operatepicture">
                                Picture</th>
                            <th data-field="cnicfront.img_blob" data-width="200" data-width-unit="px"
                                data-formatter="operatecnic">
                                CNIC front</th>
                            <th data-field="cnicback.img_blob" data-width="200" data-width-unit="px"
                                data-formatter="operatecnic">
                                CNIC back</th>
                            <th data-filter-control="input" data-field="staff_remarks" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Remarks</th>
                            <th data-filter-control="input" data-field="created_at" data-sortable="true"
                                data-force-hide="true">Created At
                            </th>
                            <th data-filter-control="input" data-field="updated_at" data-sortable="true"
                                data-force-hide="true">Last
                                Updated
                            </th>
                            <th data-field="uid" data-formatter="operateEdit" data-force-hide="true"
                                data-force-hide="true">Edit</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
@include("layouts.tableFoot")
<script>
    function operateText(value, row, index) {
        return value ? value : "N/A"
    }

    function operateFirstAndLastName(value, row, index) {
        return `${row.staff_first_name} ${row.staff_last_name}`;
    }

    function statusChangerFormatter(value, row, index) {
        if (value) {
            return [
                '<div class="left">',
                '<a class="btn btn-danger" href="statusChanger/' + row.uid + '">',
                '<span><i class="ti ti-users" style="font-size:24px;"></i></span>',
                '</a>',
                '</div>',
            ].join('')
        } else {
            return [
                '-',
            ].join('')
        }
    }

    function statusFormatter(value, row, index) {
        if (value != null) {
            return value ? ['<div class="left">', 'Yes', '</div>'].join('') : ['<div class="left">', 'No', '</div>'].join('');
        }
    }

    function operatepicture(value, row, index) {
        if (value != null) {
            return value ? `<img width="100px" height="120px" src=${value} />` : ['<div class="left">', 'Not Available', '</div>'].join('');
        }
    }
    function operatecnic(value, row, index) {
        if (value != null) {
            return value ? `<img width="150px" height="100px" src=${value} />` : ['<div class="left">', 'Not Available', '</div>'].join('');
        }
    }

    function operateEdit(value, row, index) {
        if (value) {
            return [
                '<div class="left">',
                '<a class="btn btn-success" href="' + row.company_uid + '/addOrganizationStaff/' + value + '">',
                '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-edit" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                '<path stroke="none" d="M0 0h24v24H0z" fill="none"></path>',
                '<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>',
                '<path d="M6 21v-2a4 4 0 0 1 4 -4h3.5"></path>',
                '<path d="M18.42 15.61a2.1 2.1 0 0 1 2.97 2.97l-3.39 3.42h-3v-3l3.42 -3.39z"></path>',
                '</svg>',
                '</a>',
                '</div>'
            ].join('')
        }
    }

    function operateSelf(value, row, index) {
        if (value != null) {
            return !value ? 'Rep' : 'Self';
        }
    }

    function operateSerial(value, row, index) {
        return index + 1;
    }

    
    ['#table' ].map((val => {
        var $table = $(val)
        var selectedRow = {}
        var $button = $('.status-action-button')
        


        $(function() {
            $table.on('click-row.bs.table', function(e, row, $element) {
                selectedRow = row
                $('.active').removeClass('active')
                $($element).addClass('active')
            })
        })

        $(function() {$button.click(function (val) {
            let uidArray=[]
            $table.bootstrapTable('getSelections').map((val)=>{
                uidArray.push(val.uid);
            })
            axios.post("{{route('request.updateOrganisationStaffSecurityStatus')}}",{
                uidArray,
                status:val.target.id
            }).then(
                function(response) {
                console.log(response.data);
                $table.bootstrapTable('refresh');
                }).catch(function(error) {console.log(error);})
        }
    )})
        function rowStyle(row) {
            if (row.id === selectedRow.id) {
                return {
                    classes: 'active'
                }
            }
        }


        $(val).bootstrapTable({
        exportTypes: ['json', 'csv', 'txt', 'sql', 'excel', 'pdf'],
        exportOptions: {
            fileName: 'List Of Staff',
            type: 'pdf',
            jspdf: {
                orientation: 'l',
                autotable: {
                    styles: {
                        rowHeight: 100
                    },
                    tableWidth: 'auto'
                }
            }
        }
      })
    }
    ))
</script>
@endsection
@endauth