@extends('layouts.page')

@section('title', 'Permission Create')

@section('content')
<div class="row">
    <div class="col-xl-12">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Permission <span class="fw-300"><i>Create</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('permissions.index')}}"><i class="fal fa-arrow-alt-left">
                        </i>
                        <span class="nav-link-text">Back</span>
                    </a>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                {{ Form::open(['route' => 'permissions.store','method'=>'POST','class' => 'needs-validation','novalidate']) }}
                <div class="panel-content">
                    <div class="frame-wrap">
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="basic" name="permission_type" value="basic" {{ (old('permission_type') == 'basic') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="basic" data-toggle="tooltip"
                                title="Form to create Single Permission" data-placement="auto">Basic Permission</label>
                        </div>
                        <div class="custom-control custom-radio custom-control-inline">
                            <input type="radio" class="custom-control-input" id="crud" name="permission_type" value="crud" {{ (old('permission_type') == 'crud') ? 'checked' : '' }}>
                            <label class="custom-control-label" for="crud" data-toggle="tooltip"
                                title="Form to create CRUD Permissions" data-placement="auto">CRUD Permissions</label>
                        </div>
                    </div>
                    <div id="form-1" style="display:none"
                        class="form-group">
                        <div class="panel-tag">
                            <p> Form with <code>*</code> Can not be empty.</p>
                            <p> Use _ for divider between action and slug. i.e : add_users.</p>
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            {{ Form::label('name','Permission Name',['class' => 'required form-label'])}}
                            {{ Form::text('name',null,['placeholder' => 'Permission Name','class' => 'form-control '.($errors->has('name') ? 'is-invalid':''),'required'])}}
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div id="form-2" style="display:none"
                        class="form-group">
                        <div class="panel-tag">
                            <p> Form with <code>*</code> Can not be empty.</p>
                            <p> Use plural word for resource name. i.e : users</p>
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            {{ Form::label('resource','Resource Name',['class' => 'required form-label'])}}
                            {{ Form::text('resource',null,['placeholder' => 'Resource Name','class' =>'form-control '.($errors->has('resource') ? 'is-invalid':''),'required'])}}
                            @if ($errors->has('resource'))
                            <div class="invalid-feedback">{{ $errors->first('resource') }}</div>
                            @endif
                        </div>
                    </div>

                    <div id="form-3" style="display:none" class="form-group">
                        <div class="form-group col-md-6 mb-3">
                            {{ Form::label('crud','CRUD Actions',['class' => 'form-label'])}}
                            <div class="frame-wrap">
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="add" name="action[]" value="add">
                                    <label class="custom-control-label" for="add">Create</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="view" name="action[]" value="view">
                                    <label class="custom-control-label" for="view">Read</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="edit" name="action[]" value="edit">
                                    <label class="custom-control-label" for="edit">Update</label>
                                </div>
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    <input type="checkbox" class="custom-control-input" id="delete" name="action[]" value="delete">
                                    <label class="custom-control-label" for="delete">Delete</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto" type="submit">Submit</button>
                </div>
                {{ Form::close()}}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $('input[name=permission_type]').on('click init-post-format', function() {
            $('#form-1').toggle($('#basic').prop('checked'));
            $('#form-2').toggle($('#crud').prop('checked'));
            $('#form-3').toggle($('#crud').prop('checked'));
        }).trigger('init-post-format');
    });
</script>
@endsection