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
        background-color: var(--bs-success);
        font-weight: bold;
    }

    .rejected {
        background-color: var(--bs-badar);
        font-weight: bold;
        color: black;
    }

    .approved {
        background-color: var(--bs-success);
        font-weight: bold;
        color: white;
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
            @if(session('user')->roles[0]->name === "admin" || session('user')->roles[0]->name === "depoRep" ||
            session()->get('user')->roles[0]->name === "bxssUser")
            {{-- <div class="row">
                <div class="d-flex flex-wrap">
                    if(session('user')->roles[0]->name === "admin")
                    <button id="sent" class="status-action-button btn btn-danger mb-2">Sent For
                        Approval</button>&nbsp;
                    <button id="pending" class="status-action-button btn btn-warning mb-2">Status Pending</button>&nbsp;
                    <button id="approved" class="status-action-button btn btn-success mb-2">Approved</button>&nbsp;
                    <button id="rejected" class="status-action-button btn btn-badar mb-2">Rejected</button>
                    endif
                </div>
            </div> --}}
            <br />
            <div class="row">
                @if(session('user')->roles[0]->name === "admin" || session()->get('user')->roles[0]->name ==="bxssUser")
                <div class="d-flex flex-wrap">
                    <a type="button" href="{{route('pages.addDepoGuestRender',$id)}}" class="btn btn-primary mb-2">Add
                        Depo Staff</a>&nbsp;
                    <button id="sent" class="print-action-button btn btn-primary mb-2">Print Bagde</button>&nbsp;
                </div>
                @endif
            </div>
            @endif
            <div class="table-responsive text-capitalize">
                <table id="table" data-filter-control-multiple-search="true" data-header-style="headerStyle"
                    data-filter-control-multiple-search-delimiter="," data-click-to-select="true" data-show-print="true"
                    data-virtual-scroll="true" data-filter-control="true" data-pagination="true" data-show-export="true"
                    data-show-columns="true" data-show-refresh="true" data-show-pagination-switch="true"
                    data-row-style="rowStyle" data-page-list="[10, 25, 50, 100]"
                    data-print-as-filtered-and-sorted-on-ui="true" data-url="{{route('request.getDepoGuest',$id)}}">
                    <thead>

                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-filter-control="input" data-field="SNO" data-formatter="operateSerial"
                                data-print-ignore><b>S.No.</b>
                            </th>
                            {{-- <th data-filter-control="input" data-formatter="operateBadge" data-force-hide="true">
                                Badge
                                Print</th> --}}
                            <th data-filter-control="input" data-field="depo_guest_name" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Name</th>
                            <th data-filter-control="input" data-field="depo_guest_designation" data-sortable="true"
                                data-formatter="operateText">Designation</th>
                            <th data-filter-control="input" data-field="depo_identity" data-sortable="true"
                                data-formatter="operateText">CNIC/Passport</th>
                            <th data-filter-control="input" data-field="badge_type" data-sortable="true"
                                data-formatter="operateText">Badge Category</th>
                            <th data-filter-control="input" data-field="depo_guest_contact" data-sortable="true"
                                data-formatter="operateDigits">Staff Contact</th>
                            <th data-filter-control="input" data-field="depo_guest_email" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true">Staff Email</th>
                            <th data-filter-control="input" data-field="created_at" data-sortable="true"
                                data-force-hide="true" data-formatter="operateDate">Created At
                            </th>
                            <th data-filter-control="input" data-field="updated_at" data-sortable="true"
                                data-force-hide="true" data-formatter="operateDate">Last Updated
                            </th>
                            {{-- <th data-filter-control="input" data-field="picture" data-sortable="true"
                                data-formatter="operateBool">Image Uploaded</th> --}}
                            <th data-field="pictureUrl" data-formatter="operatepicture">Picture</th>
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

    function operateDigits(value, row, index) {
        return value ? value : 0
    }

    function operateDate(value, row, index) {
        return value ? value.slice(0,10) : "N/A"
    }

    function operateFirstAndLastName(value, row, index) {
        return `${row.depo_name}`;
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

    // function operatepicture(value, row, index) {
    //     if (value != null) {
    //         return value ? `<img width="100" height="120" src=${value} />` : ['<div class="left">', 'Not Available', '</div>'].join('');
    //     }
    // }

    function operatepicture(value, row, index) {
        if (value != null) {
            return value ? `<img width="100" height="120" src="${value}" />` : ['<div class="left">', 'Not Available', '</div>'].join('');
        }
    }
    
    function operatecnic(value, row, index) {
        if (value != null) {
            return value ? `<img width="150px" height="100px" src=${value} />` : ['<div class="left">', 'Not Available', '</div>'].join('');
        }
    }

    // function operateBool(value, row, index){
    //     return value.img_blob?'Yes':'No';
    // }

    function operateEdit(value, row, index) {
        if (row.depo_uid) {
            return [
                '<div class="left">',
                '<a class="btn btn-success" href="' + row.depo_uid + '/addDepoGuestRender/' + value + '">',
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

    function operateBadge(value, row, index) {
        if (row.depo_security_status == "approved" ) {
            return [
                '<div class="left">',
                '<a class="btn btn-primary" href="' + row.depo_uid + '/addDepoGuestRender/' + value + '">',
                '<svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-id-badge-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 12h3v4h-3z" /><path d="M10 6h-6a1 1 0 0 0 -1 1v12a1 1 0 0 0 1 1h16a1 1 0 0 0 1 -1v-12a1 1 0 0 0 -1 -1h-6" /><path d="M10 3m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z" /><path d="M14 16h2" /><path d="M14 12h4" /></svg>',
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

    function headerStyle(column){

    }

    function rowStyle(row) {
            if(row.hr_security_status == 'rejected'){
                return {classes: 'rejected'}
            }
            else if(row.hr_security_status == 'approved'){
                return {classes: 'approved'}
            }
            else{
                return {classes: ''}
            }
            console.log(row)
            if (row.id === selectedRow.id) {
                return {
                    classes: 'active'
                }
            }
            else if(row.functionaryPending != 0){
                return {
                    classes: 'pending'
                }
            }
        }


    
    ['#table' ].map((val => {
        var $table = $(val)
        var selectedRow = {}
        var $button = $('.status-action-button')
        var $printButton = $('.print-action-button')

        $(function() {$button.click(function (val) {
            let uidArray=[]
            $table.bootstrapTable('getSelections').map((val)=>{
                uidArray.push(val.uid);
            })
        }
    )
    $(function() {$printButton.click(function (val) {
            let uidArray=[]
            $table.bootstrapTable('getSelections').map((val)=>{
                    uidArray.push(val.id);
                })
                uidArray.length?window.location.href = "{{  url('') }}/badge/depo/"+uidArray+"":alert("Please atleast select one");
                })
        })
})
        $(val).bootstrapTable({
        exportTypes: ['json', 'csv', 'txt', 'sql', 'excel', 'pdf'],
        exportOptions: {
            fileName: '{{$depo->depo_rep_name}}',
            type: 'pdf',
            jspdf: {
                orientation: 'l',
                autotable: {
                    styles: {
                        rowHeight: 60,
                        overflow: 'linebreak',
                        valign: 'middle',
                    },
                    headerStyles:{
                        fontSize:12,
                        fontStyle: 'bold',
                    },
                    tableWidth: 'auto',
                },
            }
        }
        })
    }
    ))
</script>
@endsection
@endauth