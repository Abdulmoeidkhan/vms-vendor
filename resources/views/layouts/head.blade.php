<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="shortcut icon" type="image/png" href="{{asset('images/icons/Badar-icon-128x128.png')}}" />
<link rel="stylesheet" href="{{asset('assets/css/styles.min.css')}}" />
<?php $routesIncludedTable = array('pages.delegationsPage'); ?>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
@if(in_array(Route::currentRouteName(), $routesIncludedTable))
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-table@1.22.1/dist/bootstrap-table.min.css">
@endif