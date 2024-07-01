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
            @if(session()->get('user')->roles[0]->name === "admin" || session()->get('user')->roles[0]->name === "orgRep")
            <div class="row">
                <div class="d-flex">
                    <a type="button" href="{{route('pages.addOrganizationStaff',$id)}}" class="btn btn-primary">Add Staff</a>
                </div>
            </div>
            @endif
            <br />
            <div class="table-responsive">
                <table id="table" data-filter-control-multiple-search="true" data-filter-control-multiple-search-delimiter="," data-virtual-scroll="true" data-filter-control="true" data-toggle="table" data-flat="true" data-pagination="true" data-show-toggle="true" data-show-export="true" data-show-columns="true" data-show-refresh="true" data-show-pagination-switch="true" data-show-columns-toggle-all="true" data-page-list="[10, 25, 50, 100]" data-url="{{route('request.getOrganizationStaff',$id)}}">
                    <thead>
                        <tr>
                            <th data-filter-control="input" data-field="SNO" data-formatter="operateSerial">S.No.</th>
                            <th data-filter-control="input" data-field="staff_name" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Category</th>
                            <th data-filter-control="input" data-field="staff_identity" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Owner Name</th>
                            <th data-filter-control="input" data-field="staff_contact" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Address </th>
                            <th data-filter-control="input" data-field="staff_designation" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Type</th>
                            <th data-filter-control="input" data-field="staff_type" data-sortable="true" data-formatter="operateText">City</th>
                            <th data-filter-control="input" data-field="staff_address" data-sortable="true" data-formatter="operateText">Country</th>
                            <th data-filter-control="input" data-field="staff_city" data-sortable="true" data-formatter="operateText">Contact</th>
                            <th data-filter-control="input" data-field="staff_country" data-sortable="true" data-formatter="operateText">NTN</th>
                            <th data-filter-control="input" data-field="staff_remarks" data-formatter="operateSelf">Company Owner Name</th>
                            <th data-filter-control="input" data-field="created_at" data-sortable="true">Created At</th>
                            <th data-filter-control="input" data-field="updated_at" data-sortable="true">Last Updated</th>
                            <th data-field="uid" data-formatter="operateEdit">Edit</th>
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
        return `${row.first_Name} ${row.last_Name}`;
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

    ['#table', '#table1', '#table2', '#table3', '#table4', ].map((val => {
        var $table = $(val)
        var selectedRow = {}

        $(function() {
            $table.on('click-row.bs.table', function(e, row, $element) {
                selectedRow = row
                $('.active').removeClass('active')
                $($element).addClass('active')
            })
        })

        function rowStyle(row) {
            if (row.id === selectedRow.id) {
                return {
                    classes: 'active'
                }
            }
            return {}
        }

        $(val).bootstrapTable({
            exportOptions: {
                fileName: 'List Of All Organisation'
            }
        });
    }))
</script>
@endsection
@endauth