@extends('layouts.page')

@section('title', 'Role Management')

@section('content')
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-universal-access'></i> Module: <span class='fw-300'>Role</span>
        <small>
            Module for manage roles.
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>
                    Roles <span class="fw-300"><i>List</i></span>
                </h2>
                <div class="panel-toolbar">
                    @can('add_roles')
                    <a class="nav-link active" href="#" data-toggle="modal" data-target="#role-modal"><i
                            class="fal fa-plus-circle"></i>
                        <span class="nav-link-text">Add New</span>
                    </a>
                    @endcan
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- role add modal start -->
<div class="modal fade" id="role-modal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Add New Role
                    <small class="m-0 text-muted">
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            {!! Form::open(['method'=>'POST','class' => 'needs-validation','novalidate']) !!}
            <div class="modal-body">
                <div class="form-group col-md-6 mb-3">
                    {{ Form::label('name','Role Name',['class' => 'required form-label'])}}
                    {{ Form::text('name',null,['placeholder' => 'Role Name','class' => 'form-control '.($errors->has('name') ? 'is-invalid':''),'required'])}}
                    @if ($errors->has('name'))
                    <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary">Add New</button>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<!-- end modal -->

@forelse ($roles as $role)
<!-- editing form for roles permissions -->
{{ Form::model($role, ['method' => 'PUT', 'route' => ['roles.update',  $role->id ], 'class' => 'm-b']) }}
@if($role->name === 'superadmin')
@include('roles._permission', [
'title' => $role->name .' Permissions',
'options' => ['disabled'] ])
@else
@include('roles._permission', [
'title' => $role->name .' Permissions','model' => $role ])
@can('edit_roles')
<button type="submit" class="btn btn-primary">Save</button>
@endcan
@endif
{{ Form::close() }}
@empty
<p>No Roles defined, please run <code>php artisan db:seed</code> to seed user role data.</p>
@endforelse

@endsection

@section('js')
<script type="text/javascript">
    @if (count($errors) > 0)
    $('#role-modal').modal('show');
    @endif
  </script>
@endsection