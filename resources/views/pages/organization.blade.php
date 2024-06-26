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
            @if(session()->get('user')->roles[0]->name === "admin")
            <div class="row">
                <div class="d-flex">
                    <a type="button" href="{{route('pages.addOrganization')}}" class="btn btn-primary">Add Organisation</a>
                </div>
            </div>
            @endif
            <br />
            <div class="table-responsive">
                <table id="table" data-filter-control-multiple-search="true" data-filter-control-multiple-search-delimiter="," data-virtual-scroll="true" data-filter-control="true" data-toggle="table" data-flat="true" data-pagination="true" data-show-toggle="true" data-show-export="true" data-show-columns="true" data-show-refresh="true" data-show-pagination-switch="true" data-show-columns-toggle-all="true" data-page-list="[10, 25, 50, 100]" data-url="{{route('request.getOrganization')}}">
                    <thead>
                        <tr>
                            <th data-filter-control="input" data-field="SNO" data-formatter="operateSerial">S.No.</th>
                            <th data-filter-control="input" data-field="company_category" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Category</th>
                            <th data-filter-control="input" data-field="company_name" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Owner Name</th>
                            <th data-filter-control="input" data-field="company_address" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Address </th>
                            <th data-filter-control="input" data-field="company_type" data-sortable="true" data-fixed-columns="true" data-formatter="operateText">Company Type</th>
                            <th data-filter-control="input" data-field="company_city" data-sortable="true" data-formatter="operateText">City</th>
                            <th data-filter-control="input" data-field="company_country" data-sortable="true" data-formatter="operateText">Country</th>
                            <th data-filter-control="input" data-field="company_contact" data-sortable="true" data-formatter="operateInvitedBy">Contact</th>
                            <th data-filter-control="input" data-field="company_ntn" data-sortable="true" data-formatter="operateText">NTN</th>
                            <th data-filter-control="input" data-field="company_owner" data-formatter="operateSelf">Company Owner Name</th>
                            <th data-filter-control="input" data-field="company_owner_designation" data-sortable="true" data-formatter="operateText">Company Owner Designation</th>
                            <th data-filter-control="input" data-field="company_owner_contact" data-sortable="true" data-formatter="statusFormatter">Company Owner Contact</th>
                            <th data-filter-control="input" data-field="company_rep_name" data-sortable="true" data-formatter="operateText">Company Rep Name</th>
                            <th data-filter-control="input" data-field="company_rep_designation" data-sortable="true" data-formatter="operateText">Company Rep Designation</th>
                            <th data-filter-control="input" data-field="company_rep_dept" data-formatter="operateText">Company Rep Designation</th>
                            <th data-filter-control="input" data-field="company_rep_contact" data-formatter="operateText">Company Rep Contact</th>
                            <th data-filter-control="input" data-field="company_rep_email" data-formatter="operateText">Company Rep Email</th>
                            <th data-filter-control="input" data-field="company_rep_phone" data-formatter="operateText">Company Rep Phone</th>
                            <th data-filter-control="input" data-field="created_at" data-sortable="true">Created At</th>
                            <th data-filter-control="input" data-field="updated_at" data-sortable="true">Last Updated</th>
                            @if(session()->get('user')->roles[0]->name === "admin")
                            <th data-field="uid" data-formatter="operateEdit">Edit</th>
                            @endif
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</div>
<script>
    function operateText(value, row, index) {
        return value ? value : "N/A"
    }

    function operateFirstAndLastName(value, row, index) {
        return `${row.first_Name} ${row.last_Name}`;
    }

    function memberFormatter(value, row, index) {
        return value ? value.map((val, i) => '<div style="text-align:left;">' + (i + 1) + ') ' + val?.rank?.ranks_name + ' ' + val?.first_Name + ' ' + val?.last_Name + ' - ' + val?.delegation_type + '</div><br/>').join('') : '-';
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

    function operateInvitaion(value, row, index) {
        if (value) {
            return [
                '<div class="left">',
                '<a class="btn btn-success" target="_blank" href="invitation/' + value + '">',
                '<span><i class="ti ti-users" style="font-size:24px;"></i></span>',
                '</a>',
                '</div>',
            ].join('')
        }
    }

    function operateMember(value, row, index) {
        if (value) {
            return row.delegation_response == 'Accepted' ? [
                '<div class="left">',
                '<a class="btn btn-success" href="members/' + value + '">',
                '<span><i class="ti ti-users" style="font-size:24px;"></i></span>',
                '</a>',
                '</div>',
            ].join('') : [
                '<div class="left">',
                '<a class="btn btn-success" href="members/' + value + '">',
                '<span><i class="ti ti-users" style="font-size:24px;"></i></span>',
                '</a>',
                '</div>',
            ].join('')
        }
    }

    function operateInvitedBy(value, row, index) {
        return value ? value : "N/A";
    }

    function operateOfficerName(value, row, index) {
        if (value) {
            return value.map((val, i) => '<div style="text-align:left;">' + (i + 1) + ') ' + val.officer_type + ' - ' + val.ranks_name + ' ' + val.officer_first_name + ' ' + val.officer_last_name + '-' + val.officer_contact + '</div><br/>').join('')
        } else {
            return [
                '-',
            ].join('')
        }
    }

    function operateCarsName(value, row, index) {
        return value ? value.map((val, i) => '<div style="text-align:left;">' + (i + 1) + ') ' + (val.car_category == '61346491-983a-40ed-8477-2d9ed84e6767' ? 'Cat A' : 'Cat B') + '  ' + val.car_makes + ' ' + val.car_model + ' ' + val.car_number + '  ' + ' - ' + val.driver.driver_name + ' - ' + val.driver.driver_contact + '</div><br/>').join('') : '<div>-</div>';
    }

    function operateOfficer(value, row, index) {
        if (row.delegation_response) {

            return row.delegation_response == 'Accepted' ? [
                '<div class="left">',
                '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-delegation="' + row.uid + '" data-bs-target="#OfficerModal">',
                '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>',
                '<path d="M6 21v-2a4 4 0 0 1 4 -4h2" />',
                '<path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" />',
                '<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />',
                '</svg>',
                '</button>',
                '</div>'
            ].join('') : [
                '<div class="left">',
                '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-delegation="' + row.uid + '" data-bs-target="#OfficerModal" disabled>',
                '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>',
                '<path d="M6 21v-2a4 4 0 0 1 4 -4h2" />',
                '<path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" />',
                '<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />',
                '</svg>',
                '</button>',
                '</div>'
            ].join('');
        }
    }

    function detachOfficer(value, row, index) {
        if (row.delegation_response) {
            return row.delegation_response == 'Accepted' ? [
                '<div class="left">',
                '<button type="button" class="btn btn-badar"  data-bs-toggle="modal" data-bs-delegation="' + row.uid + '" data-bs-target="#DetachModal">',
                '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>',
                '<path d="M6 21v-2a4 4 0 0 1 4 -4h2" />',
                '<path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" />',
                '<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />',
                '</svg>',
                '</button>',
                '</div>'
            ].join('') : [
                '<div class="left">',
                '<button type="button" class="btn btn-badar"  data-bs-toggle="modal" data-bs-delegation="' + row.uid + '" data-bs-target="#DetachModal" disabled>',
                '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-user-shield" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>',
                '<path d="M6 21v-2a4 4 0 0 1 4 -4h2" />',
                '<path d="M22 16c0 4 -2.5 6 -3.5 6s-3.5 -2 -3.5 -6c1 0 2.5 -.5 3.5 -1.5c1 1 2.5 1.5 3.5 1.5z" />',
                '<path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0" />',
                '</svg>',
                '</button>',
                '</div>'
            ].join('');
        }
    }


    function operateCar(value, row, index) {
        if (value) {
            return row.delegation_response == 'Accepted' ? [
                '<div class="left">',
                '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-delegation="' + value + '" data-bs-target="#AttachCar">',
                '<span>',
                '<i class="ti ti-car" style="font-size:24px;"></i>',
                '</span>',
                '</button>',
                '</div>'
            ].join('') : [
                '<div class="left">',
                '<button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-delegation="' + value + '" data-bs-target="#AttachCar" disabled>',
                '<span>',
                '<i class="ti ti-car" style="font-size:24px;"></i>',
                '</span>',
                '</button>',
                '</div>'
            ].join('');
        }
    }

    function operateDetachCar(value, row, index) {
        if (row.delegation_response) {
            return row.delegation_response == 'Accepted' ? [
                '<div class="left">',
                '<button type="button" class="btn btn-badar" data-bs-toggle="modal" data-bs-delegation="' + row.uid + '" data-bs-target="#DeattachCar">',
                '<span>',
                '<i class="ti ti-car" style="font-size:24px;"></i>',
                '</span>',
                '</button>',
                '</div>'
            ].join('') : [
                '<div class="left">',
                '<button type="button" class="btn btn-badar" data-bs-toggle="modal" data-bs-delegation="' + row.uid + '" data-bs-target="#DeattachCar" disabled>',
                '<span>',
                '<i class="ti ti-car" style="font-size:24px;"></i>',
                '</span>',
                '</button>',
                '</div>'
            ].join('');
        }
    }

    function operatePlan(value, row, index) {
        if (value) {
            return row.delegation_response == 'Accepted' ? [
                '<div class="left">',
                '<a class="btn btn-success" href="addPlan/' + value + '">',
                '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-timeline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>',
                '<path d="M4 16l6 -7l5 5l5 -6" />',
                '<path d="M15 14m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '<path d="M10 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '<path d="M4 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '<path d="M20 8m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '</svg>',
                '</a>',
                '</div>'
            ].join('') : [
                '<div class="left">',
                // '<a class="btn btn-success" href="#" disablded>',
                '<button type="button" class="btn btn-success" disabled>',
                '<svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-timeline" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">',
                '<path stroke="none" d="M0 0h24v24H0z" fill="none"/>',
                '<path d="M4 16l6 -7l5 5l5 -6" />',
                '<path d="M15 14m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '<path d="M10 9m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '<path d="M4 16m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '<path d="M20 8m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" />',
                '</svg>',
                // '</a>',
                '</button>',
                '</div>'
            ].join('');
        }
    }

    function operateEdit(value, row, index) {
        if (value) {
            return [
                '<div class="left">',
                '<a class="btn btn-success" href="addOrganization/' + value + '">',
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

    function operateInterets(value, row, index) {
        if (value) {
            return value.map((val, i) => '<div style="text-align:left;">' + (i + 1) + ') ' + val?.program?.program_name + '</div><br/>').join('')
            // return value.map((val, i) => '<div style="text-align:left;">' + (i + 1) + ') ' + val.program.program_name + ' - Day ' + val.program.program_day + ' ' + val.program.program_start_time + ' ' + val.program.program_end_time + '</div><br/>').join('')
        } else {
            return [
                '-',
            ].join('')
        }
    }

    const officerModal = document.getElementById('OfficerModal')
    officerModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const delegation = button.getAttribute('data-bs-delegation')
        const modalBodyInput = officerModal.querySelector('.modal-body #delegationUid_officer')
        modalBodyInput.value = delegation
    })

    const officerDetachModal = document.getElementById('DetachModal')
    officerDetachModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const delegation = button.getAttribute('data-bs-delegation')
        const modalBodyInput = officerDetachModal.querySelector('.modal-body #delegationUid_dis_officer')
        modalBodyInput.value = delegation
        $('#DetachModal').on('shown.bs.modal', function() {
            let targetElement = document.getElementById('officerSelect');
            let officerDeSelect = document.getElementById('delegationUid_dis_officer').value;
            targetElement.innerHTML = '';
            axios.get('/detachOfficerData/' + officerDeSelect + '')
                .then(function(response) {
                    let data = response.data;
                    let data2 = [];
                    data.map((val) => {
                        data2.push(`<option class="text-capitalize" value="${val.officer_uid}">${val.officer_first_name} ${val.officer_last_name} - ${val.officer_type} </option>`)
                    })
                    targetElement.innerHTML = data2;
                })
                .catch(function(error) {
                    console.log(error);
                })
        })

    })

    const carModal = document.getElementById('AttachCar')
    carModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const delegation = button.getAttribute('data-bs-delegation')
        const modalBodyInput = carModal.querySelector('.modal-body #delegationUid_car')
        modalBodyInput.value = delegation
    })

    const carDetachModal = document.getElementById('DeattachCar')
    carDetachModal.addEventListener('show.bs.modal', event => {
        const button = event.relatedTarget
        const delegation = button.getAttribute('data-bs-delegation')
        console.log(delegation)
        const modalBodyInput = carDetachModal.querySelector('.modal-body #delegationUid_dis_car')
        modalBodyInput.value = delegation
        $('#DeattachCar').on('shown.bs.modal', function() {
            let targetElement = document.getElementById('deattachCarSelect');
            let carDisassociate = document.getElementById('delegationUid_dis_car').value;
            targetElement.innerHTML = '';
            axios.get('/detachCarData/' + carDisassociate + '')
                .then(function(response) {
                    console.log(response)
                    let data = response.data;
                    let data2 = [];
                    data.map((val) => {
                        data2.push(`<option class="text-capitalize" value="${val.car_uid}">${val.car_makes} ${val.car_model} </option>`)
                    })
                    targetElement.innerHTML = data2;
                })
                .catch(function(error) {
                    console.log(error);
                })
        })
    })


    function openCity(evt, cityName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" active", "");
        }
        document.getElementById(cityName).style.display = "block";
        evt.currentTarget.className += " active";
    }
</script>
@include("layouts.tableFoot")
<script>
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