@extends('layouts.master')

@section('title')
    Login
@endsection

@section('themes_css')
<link rel="stylesheet" media="screen, print" href="{{asset('css/page-login.css')}}">
@endsection

@section('body')
<div class="blankpage-form-field">
    <div class="page-logo m-0 w-100 align-items-center justify-content-center rounded border-bottom-left-radius-0 border-bottom-right-radius-0 px-4">
        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
            <img src="{{asset('img/logo.png')}}" alt="SmartAdmin WebApp" aria-roledescription="logo">
        <span class="page-logo-text mr-1">{{env('APP_NAME')}} - Login</span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <div class="card p-4 border-top-left-radius-0 border-top-right-radius-0">
        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="form-group">
                <label class="form-label" for="email">Email</label>
                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="email">
                <span class="help-block">
                    Your registered email to app
                </span>
                @error('email')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="password" name="password" required autocomplete="current-password">
                <span class="help-block">
                    Your password
                </span>

                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
                @enderror
            </div>
            <div class="form-group text-left">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" name="remember" id="rememberme" {{ old('remember') ? 'checked' : '' }}>
                    <label class="custom-control-label" for="rememberme"> Remember me</label>
                </div>
            </div>
            <button type="submit" class="btn btn-default float-right">Secure login</button>
        </form>
    </div>
    <div class="blankpage-footer text-center">
        {{-- @if (Route::has('password.reset'))
        <a href="{{ route('password.request') }}"><strong>Recover Password</strong></a>    
        @endif --}}
    </div>
</div>
<div class="login-footer p-2">
    <div class="row">
        <div class="col col-sm-12 text-center">
            {{-- <i><strong>System Message:</strong> You were logged out from 198.164.246.1 on Saturday, March, 2017 at 10.56AM</i> --}}
        </div>
    </div>
</div>
<video poster="{{asset('img/backgrounds/clouds.png')}}" id="bgvid" playsinline autoplay muted loop>
    <source src="{{asset('media/video/cc.webm')}}" type="video/webm">
    <source src="{{asset('media/video/cc.mp4')}}" type="video/mp4">
</video>
@endsection