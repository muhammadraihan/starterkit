@extends('layouts.page')

@section('title', 'Permission Management')

@section('css')
    <link rel="stylesheet" media="screen, print" href="{{asset('css/datagrid/datatables/datatables.bundle.css')}}">
@endsection

@section('content')
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-table'></i> Module: <span class='fw-300'>Permission</span>
        <small>
            Module for manage access permissions.
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Permission <span class="fw-300"><i>List</i></span>
                </h2>
                <div class="panel-toolbar">
                    @can('add_permissions')
                    <a class="nav-link active" href="{{route('permissions.create')}}"><i class="fal fa-plus-circle"> </i>
                        <span class="nav-link-text">Add New</span>
                    </a>
                    @endcan
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <!-- datatable start -->
                    <table id="datatable" class="table table-bordered table-hover table-striped w-100">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Permission Name</th>
                                <th>Date Created</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
    <script src="{{asset('js/datagrid/datatables/datatables.bundle.js')}}"></script>
    <script>
        $(document).ready(function(){
            $('#datatable').DataTable( {
                "processing": true,
                "serverSide": true,
                "order": [[ 0, "asc" ]],
                "ajax":{
                    url:'{{route('permissions.index')}}',
                    type : "GET",
                    dataType: 'json',
                    error: function(data){
                        console.log(data);
                    }
                },
                "columns": [
                    {data: 'rownum',width:'10%',searchable:false,},
                    {data: 'name',width:'*'},
                    {data: 'created_at',width:'*',searchable:false,}
                ]
            });
        });
    </script>
@endsection