@auth
@extends('layouts.layout')
@section("content")
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
            <div class="row">
                @if(session('user')->roles[0]->name === "admin" || session()->get('user')->roles[0]->name ==="bxssUser")
                <div class="d-flex flex-wrap">
                    <button id="sent" class="print-action-button btn btn-primary mb-2">Print Bagde</button>&nbsp;
                </div>
                @endif
            </div>
            <div class="table-responsive text-capitalize">
                <table id="table" data-filter-control-multiple-search="true"
                    data-filter-control-multiple-search-delimiter="," data-click-to-select="true" data-show-print="true"
                    data-virtual-scroll="true" data-filter-control="true" data-pagination="true" data-show-export="true"
                    data-show-columns="true" data-show-refresh="true" data-show-pagination-switch="true" data-page-list="[10, 25, 50, 100, 200]" data-url="{{route('request.mediaAllStaff')}}" data-header-style="headerStyle"
                    data-print-as-filtered-and-sorted-on-ui="true">
                    <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true" data-print-ignore="true"></th>
                            <th data-filter-control="input" data-field="SNO" data-formatter="operateSerial"><b>S.No.</b>
                            </th>
                            <th data-filter-control="input" data-formatter="operateBadge" data-force-hide="true"
                                data-print-ignore="true">Badge
                                Print</th>
                            <th data-filter-control="input" data-field="media_staff_security_status"
                                data-sortable="true" data-formatter="operateText" data-force-hide="true"
                                data-print-ignore="true">Security Status
                            </th>
                            <th data-filter-control="input" data-field="media_staff_first_name" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateFirstAndLastName">Name</th>
                            <th data-filter-control="input" data-field="media_staff_father_name" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateText">Father/Husband Name</th>
                            <th data-filter-control="input" data-field="mediaName.media_name" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateText">Media Name</th>
                            <th data-filter-control="input" data-field="media_staff_designation" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateText">
                                Designation </th>
                            <th data-filter-control="input" data-field="media_staff_department" data-sortable="true"
                                data-fixed-columns="true" data-formatter="operateText" data-force-hide="true"
                                data-print-ignore="true">Department
                            </th>
                            <th data-filter-control="input" data-field="media_staff_address" data-sortable="true"
                                data-formatter="operateText">Home Address</th>
                            <th data-filter-control="input" data-field="media_staff_city" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true" data-print-ignore="true">City</th>
                            <th data-filter-control="input" data-field="media_staff_country" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true" data-print-ignore="true">Country
                            </th>
                            <th data-filter-control="input" data-field="media_staff_job_type" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true" data-print-ignore="true">Job Type
                            </th>
                            <th data-filter-control="input" data-field="media_staff_nationality" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true" data-print-ignore="true">Nationality
                            </th>
                            <th data-filter-control="input" data-field="media_staff_identity" data-sortable="true"
                                data-formatter="operateDigits">CNIC/Passport</th>
                            <th data-filter-control="input" data-field="media_staff_identity_expiry"
                                data-sortable="true" data-formatter="operateText" data-force-hide="true"
                                data-print-ignore="true">Identity Expiry
                            </th>
                            <th data-filter-control="input" data-field="media_staff_contact" data-sortable="true"
                                data-formatter="operateDigits">Contact</th>
                            <th data-filter-control="input" data-field="media_staff_dob" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true" data-print-ignore="true">DOB</th>
                            <th data-filter-control="input" data-field="employee_type" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true" data-print-ignore="true">Employee
                                Type</th>
                            <th data-field="pictureUrl" data-formatter="operatepicture">Picture</th>
                            <th data-filter-control="input" data-field="media_staff_remarks" data-sortable="true"
                                data-formatter="operateText" data-force-hide="true" data-print-ignore="true">Remarks
                            </th>
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
        return `${row.media_staff_first_name} ${row.media_staff_last_name}`;
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
            return value ? `<img width="100" height="120" src="${value}"  />` : ['<div class="left">', 'Not Available', '</div>'].join('');
        }
    }

    function operateEdit(value, row, index) {
        if (row.media_staff_security_status == 'pending') {
            return [
                '<div class="left">',
                '<a class="btn btn-success" href="' + row.media_uid + '/addMediaStaff/' + value + '">',
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
        if (row.staff_security_status == "approved") {
            return [
                '<div class="left">',
                '<a class="btn btn-primary" href="' + row.company_uid + '//' + value + '">',
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
            axios.post("{{route('request.updateMediaStaffSecurityStatus')}}",{
                uidArray,
                status:val.target.id
            }).then(
                function(response) {
                $table.bootstrapTable('refresh');
                }).catch(function(error) {console.log(error);})
        })
        
        $(function() {$printButton.click(function (val) {
            let uidArray=[]
            $table.bootstrapTable('getSelections').map((val)=>{
                    uidArray.push(val.id);
                })
                uidArray.length?window.location.href = "{{  url('') }}/badge/media/"+uidArray+"":alert("Please atleast select one");
                })
        })
        })

        $(val).bootstrapTable({
        exportTypes: ['json', 'csv', 'txt', 'sql', 'excel', 'pdf'],
        exportOptions: {
            fileName: 'Media All Staff',
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
      $(val).bootstrapTable({
      printPageBuilder: function (val) {
        return `
<html>
  <head>
  <style type="text/css" media="print">
  @page {
    size: auto;
    margin: 25px 0 25px 0;
  }
  </style>
  <style type="text/css" media="all">
  table {
    border-collapse: collapse;
    font-size: 12px;
  }
  table, th, td {
    border: 1px solid grey;
  }
  th, td {
    text-align: center;
    vertical-align: middle;
  }
  p {
    font-weight: bold;
    margin-left:20px;
  }
  table {
    width:94%;
    margin-left:3%;
    margin-right:3%;
  }
  div.bs-table-print {
    text-align:center;
  }
  </style>
  </head>
  <title>Print Table</title>
  <body>
  <div class="bs-table-print">${val}</div>
  </body>
</html>`
      }
    })
    }
    ))
</script>
@endsection
@endauth