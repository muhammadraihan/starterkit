@extends('layouts.page')

@section('title', 'Menu Edit')

@section('css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/formplugins/select2/select2.bundle.css')}}">
@endsection

@section('content')
<div class="row">
    <div class="col-xl-6">
        <div id="panel-1" class="panel">
            <div class="panel-hdr">
                <h2>Edit <span class="fw-300"><i>Menu</i></span></h2>
                <div class="panel-toolbar">
                    <a class="nav-link active" href="{{route('menus.index')}}"><i class="fal fa-arrow-alt-left">
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
                    {!! Form::open(['route' => ['menus.update',$menu->uuid],'method' => 'PUT','class' =>
                    'needs-validation','novalidate']) !!}
                    <div class="form-row">
                        <div class="form-group col-md-4 mb-3">
                            {!! Form::label('menu_title', 'Menu Title', ['class' => 'required form-label']) !!}
                            {!! Form::text('menu_title', $menu->menu_title, ['placeholder' => 'Menu Title','class' =>
                            'form-control
                            '.($errors->has('menu_title') ? 'is-invalid':''),'required']) !!}
                            @if ($errors->has('menu_title'))
                            <div class="invalid-feedback">{{ $errors->first('menu_title') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-4 mb-3">
                            {!! Form::label('route_name', 'Route Name', ['class' => 'form-label']) !!}
                            <select id="route_name" class="custom-select select2 route_name @if ($errors->has('route_name'))
                                is-invalid
                            @endif" name="route_name">
                                @if (isset($menu->route_name))
                                <option value="{{$menu->route_name}}">{{$menu->route_name}}</option>
                                @else
                                <option value="" disabled selected>Select Route Name ...</option>
                                @endif
                                @foreach ($filtered_routes as $key => $value)
                                <option value="{{$value->getName()}}">{{$value->getName()}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('route_name'))
                            <div class="invalid-feedback">{{ $errors->first('route_name') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-2 mb-3">
                            {!! Form::label('order', 'Order Position', ['class' => 'required form-label']) !!}
                            {!! Form::text('order', $menu->order, ['placeholder' => 'Order Position','class' =>
                            'form-control
                            '.($errors->has('order') ? 'is-invalid':''),'required']) !!}
                            @if ($errors->has('order'))
                            <div class="invalid-feedback">{{ $errors->first('order') }}</div>
                            @endif
                        </div>
                        <div class="form-group col-md-2 mb-3">
                            {!! Form::label('icon_class', 'Icon Class', ['class' => 'form-label']) !!}
                            {!! Form::text('icon_class', $menu->icon_class, ['placeholder' => 'Icon Class','class' =>
                            'form-control
                            '.($errors->has('icon_class') ? 'is-invalid':''),'required']) !!}
                            @if ($errors->has('icon_class'))
                            <div class="invalid-feedback">{{ $errors->first('icon_class') }}</div>
                            @endif
                        </div>
                        <div id="parent-div" class="form-group col-md-4 mb-3" style="">
                            {!! Form::label('parent', 'Parent Menu', ['class' => 'required form-label']) !!}
                            <select id="parent" class="custom-select select2 parent @if ($errors->has('parent'))
                                is-invalid
                            @endif" name="parent">
                                @if ($menu->parent_id != 0)
                                <option value="{{$menu->parent_id}}" selected>{{$menu->parent->menu_title}}</option>
                                @else
                                <option value="" disabled selected>Select parent ...</option>
                                @endif
                                @foreach ($parent_menu as $item)
                                <option value="{{$item->id}}">{{$item->menu_title}}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('parent'))
                            <div class="invalid-tooltip">{{ $errors->first('parent') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="frame-wrap">
                        <div class="custom-control custom-checkbox custom-control-inline">
                            <input type="checkbox" class="custom-control-input" id="is_child" name="is_child" value="1"
                                {{$menu->parent_id?"checked":''}}>
                            <label class="custom-control-label" for="is_child">is child menu ?</label>
                        </div>
                    </div>
                </div>
                <div
                    class="panel-content border-faded border-left-0 border-right-0 border-bottom-0 d-flex flex-row align-items-center">
                    <button class="btn btn-primary ml-auto" type="submit">Submit</button>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script src="{{asset('js/formplugins/select2/select2.bundle.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.select2').select2();
        $('#is_child').click(function(){
            if ($('#is_child').is(":checked")) {
                $('#parent-div').show(200);
            }
            else{
                $('#parent-div').hide(300);
            }
        })
    });
</script>
@endsection