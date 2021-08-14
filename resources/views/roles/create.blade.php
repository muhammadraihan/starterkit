@extends('layouts.page')

@section('title', 'Role Create')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        {!! Form::open(['route' => 'roles.store','method' => 'POST','class' =>
        'needs-validation','novalidate']) !!}
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Add New <span class="fw-300"><i>Role</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('roles.index')}}"><i class="fal fa-arrow-alt-left">
                        </i>
                        <span class="nav-link-text">Back</span>
                    </a>
                    <button class="btn btn-panel" data-action="panel-fullscreen" data-toggle="tooltip"
                        data-offset="0,10" data-original-title="Fullscreen"></button>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="panel-tag">
                        Form with <code>*</code> can not be empty.
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-3">
                            {!! Form::label('name', 'Role Name', ['class' => 'required form-label']) !!}
                            {!! Form::text('name', null, ['placeholder' => 'Role Name','class' => 'form-control
                            '.($errors->has('name') ? 'is-invalid':''),'required']) !!}
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-2" class="panel">
            <div class="panel-hdr">
                <h2>Add Permission <span class="fw-300"><i>Role</i></span></h2>
                <div class="custom-control custom-checkbox custom-control-inline">
                    <input type="checkbox" class="custom-control-input" id="all-permissions" name="all-permissions">
                    <label class="custom-control-label" for="all-permissions">Check All Permissions</label>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            @foreach($permissions as $key => $value)
                            <div class="frame-wrap">
                                @foreach ($value as $item)
                                <div class="custom-control custom-checkbox custom-control-inline">
                                    {!! Form::checkbox("permissions[]", $item->id, '',
                                    ['id'=>$item->name,'class'=>'custom-control-input permission']) !!}
                                    <label
                                        class="{{Str::contains($item->name, 'delete') ? 'custom-control-label text-danger' : 'custom-control-label'}}"
                                        for="{{$item->name}}">{{$item->name}}</label>
                                </div>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div id="panel-2" class="panel">
            <div class="panel-hdr">
                <h2>Add Menu <span class="fw-300"><i>Role</i></span></h2>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="all-menus" name="all-menus">
                    <label class="custom-control-label" for="all-menus">Check All Menus</label>
                </div>
            </div>
            <div class="panel-container show">
                <div class="panel-content">
                    <div class="row">
                        <div class="form-group col-md-12 mb-3">
                            @foreach($menus as $key => $value)
                            <div class="frame-wrap col-md-12 mb-2">
                                <div id="menu-check" class="custom-control custom-checkbox">
                                    {!! Form::checkbox("menus[]", $value->id, '',
                                    ['id'=>$value->menu_title,'class'=>'custom-control-input menu']) !!}
                                    <label class="custom-control-label"
                                        for="{{$value->menu_title}}">{{$value->menu_title}}</label>
                                </div>
                            </div>
                            @if (count($value->childs))
                            <div class="form-group col-md-12">
                                @foreach ($value->childs as $item)
                                <div id="submenu-check" class="custom-control custom-checkbox custom-control-inline">
                                    {!! Form::checkbox("menus[]", $item->id, '',
                                    ['id'=>$item->menu_title,'class'=>'custom-control-input submenu']) !!}
                                    <label class="custom-control-label"
                                        for="{{$item->menu_title}}">{{$item->menu_title}}</label>
                                </div>
                                @endforeach
                            </div>
                            @endif
                            @endforeach
                        </div>
                    </div>
                </div>
                <div
                    class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto" type="submit">Submit</button>
                </div>
            </div>
        </div>
        {!! Form::close() !!}
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('#all-permissions').click(function(){
            if ($('#all-permissions').is(":checked")) {
                $('.permission').prop('checked', this.checked);
            }
        })

        $('#all-menus').click(function(){
            if ($('#all-menus').is(":checked")) {
                $('.menu').prop('checked', this.checked);
                $('.submenu').prop('checked', this.checked);
            }
        })

        $('.submenu').click(function(e){
            if($('.submenu').is(":checked")){
                $('#menu-check').find('[type=checkbox]').prop('checked', true);
            }
        });
    });
</script>
@endsection