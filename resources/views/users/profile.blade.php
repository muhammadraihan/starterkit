@extends('layouts.page')

@section('title', 'User Profile')

@section('css')
@endsection

@section('content')
<div class="subheader">
    <h1 class="subheader-title">
        <i class='subheader-icon fal fa-user-circle'></i> {{Auth::user()->name}}
        <small>
            Profile page
        </small>
    </h1>
</div>
<div class="row">
    <div class="col-lg-6 col-xl-3 order-lg-1 order-xl-1">
        <!-- profile summary -->
        <div class="card mb-g rounded-top">
            {!! Form::open(['route' => ['profile.update',$user],'method'=>'PATCH','class' =>
            'form-horizontal','enctype' => 'multipart/form-data']) !!}
            <div class="row no-gutters row-grid">
                <div class="col-12">
                    <div class="p-3">
                        <h2 class="mb-0 fs-xl">
                            Profile Summary
                        </h2>
                    </div>
                    <div class="d-flex flex-column align-items-center justify-content-center p-4">
                        <img id="image-preview" src="{{asset('img/avatar').'/'.$user->avatar}}"
                            class="rounded-circle shadow-2 img-thumbnail" alt="" style="max-height:150px;">
                        <h5 class="mb-0 fw-700 text-center mt-3">
                            Change Avatar
                        </h5>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="custom-file">
                                    <input name="avatar" type="file" class="custom-file-input" id="image"
                                        aria-describedby="image">
                                    <label class="custom-file-label" for="image">Choose file</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="p-3">
                        <div class="form-group">
                            {{ Form::label('name','Full Name',['class' => 'required form-label'])}}
                            {{ Form::text('name',$user->name,['placeholder' => 'Full Name','class' => 'form-control '.($errors->has('name') ? 'is-invalid':''),'required'])}}
                            @if ($errors->has('name'))
                            <div class="invalid-feedback">{{ $errors->first('name') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            {{ Form::label('email','Email Address',['class' => 'required form-label'])}}
                            {{ Form::text('email',$user->email,['placeholder' => 'Email Address','class' => 'form-control ','disabled'])}}
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="p-3">
                        <button class="btn btn-primary ml-auto" type="submit">Update Profile</button>
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
    <div class="col-lg-6 col-xl-3 order-lg-2 order-xl-3">
        <!-- change password -->
        <div class="card mb-2">
            <div class="p-3">
                <h2 class="mb-0 fs-xl">
                    Change Password
                </h2>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => ['profile.password',$user], 'method' => 'PATCH', 'class' =>
                'needs-validation','novalidate']) !!}
                <div class="form-group">
                    {{ Form::label('old-password','Old Password',['class' => 'required form-label'])}}
                    {{ Form::password('old-password',['placeholder' => 'Old Password','class' => 'form-control '.($errors->has('old-password') ? 'is-invalid':''),'required'])}}
                    @if ($errors->has('old-password'))
                    <div class="invalid-feedback">{{ $errors->first('old-password') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('new-password','New Password',['class' => 'required form-label'])}}
                    {{ Form::password('new-password',['placeholder' => 'New Password','class' => 'form-control '.($errors->has('new-password') ? 'is-invalid':''),'required'])}}
                    @if ($errors->has('new-password'))
                    <div class="invalid-feedback">{{ $errors->first('new-password') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    {{ Form::label('confirm-password','New Password Confirmation',['class' => 'required form-label'])}}
                    {{ Form::password('confirm-password',['placeholder' => 'New Password Confirmation','class' => 'form-control '.($errors->has('confirm-password') ? 'is-invalid':''),'required'])}}
                    @if ($errors->has('confirm-password'))
                    <div class="invalid-feedback">{{ $errors->first('old-password') }}</div>
                    @endif
                </div>
                <div class="col-lg-12">
                    <div class="p-3">
                        <button class="btn btn-primary ml-auto" type="submit">Change Password</button>
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        $('#image').change(function(){
            let reader = new FileReader();reader.onload = (e) => { 
                $('#image-preview').attr('src', e.target.result); 
            }
            reader.readAsDataURL(this.files[0]); 
        });
    });
</script>
@endsection