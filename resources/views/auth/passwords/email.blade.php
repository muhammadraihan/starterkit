@extends('layouts.master')

@section('title')
Reset Password
@endsection

@section('themes_css')
@endsection

@section('body')
<div class="page-wrapper">
    <div class="page-inner bg-brand-gradient">
        <div class="page-content-wrapper bg-transparent m-0">
            <div class="height-10 w-100 shadow-lg px-4 bg-brand-gradient">
                <div class="d-flex align-items-center container p-0">
                    <div
                        class="page-logo width-mobile-auto m-0 align-items-center justify-content-center p-0 bg-transparent bg-img-none shadow-0 height-9">
                        <a href="javascript:void(0)" class="page-logo-link press-scale-down d-flex align-items-center">
                            <img src="{{asset('img/wba_logo.png')}}" alt="App Logo" aria-roledescription="logo">
                            <span class="page-logo-text mr-1">{{ env('APP_NAME') }}</span>
                        </a>
                    </div>
                    <span class="text-white opacity-50 ml-auto mr-2 hidden-sm-down">
                        Already have account ?
                    </span>
                    <a href="{{route('login')}}" class="btn-link text-white ml-auto ml-sm-0">
                        Secure Login
                    </a>
                </div>
            </div>
            <div class="flex-1"
                style="background: url(img/svg/pattern-1.svg) no-repeat center bottom fixed; background-size: cover;">
                <div class="container py-4 py-lg-5 my-lg-5 px-4 px-sm-0">
                    <div class="row">
                        <div class="col-xl-12">
                            <h2 class="fs-xxl fw-500 mt-4 text-white text-center">
                                "I forgot my password :("
                                <small class="h3 fw-300 mt-3 mb-5 text-white opacity-60 hidden-sm-down">
                                    Not a problem, happens to the best of us. Just use the form below to reset it!
                                </small>
                            </h2>
                        </div>
                        <div class="col-xl-6 ml-auto mr-auto">
                            <div class="card p-4 rounded-plus bg-faded">
                                @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                                @endif
                                <form id="js-login" novalidate="" method="POST" action="{{ route('password.email') }}">
                                    @csrf
                                    <div class="form-group">
                                        <label class="form-label" for="lostaccount">Your registered email to app</label>
                                        <input type="email" id="lostaccount"
                                            class="form-control @error('email') is-invalid @enderror" name="email"
                                            value="{{ old('email') }}" placeholder="Recovery email" required>
                                        <div class="invalid-feedback">Please provide your registered email</div>
                                        <div class="help-block">We will email you the instructions</div>
                                    </div>
                                    <div class="row no-gutters">
                                        <div class="col-md-4 ml-auto text-right">
                                            <button id="js-login-btn" type="submit"
                                                class="btn btn-danger">Recover</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-block text-center text-white">
                    {{date('Y')}} © {{env('APP_NAME')}} by&nbsp;<a href='https://www.wbaindonesia.com'
                        class='text-white opacity-40 fw-500' title='wbaindonesia.com' target='_blank'>WBA Indonesia</a>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="js/vendors.bundle.js"></script>
<script src="js/app.bundle.js"></script>
<script>
    $("#js-login-btn").click(function(event)
    {

        // Fetch form to apply custom Bootstrap validation
        var form = $("#js-login")

        if (form[0].checkValidity() === false)
        {
            event.preventDefault()
            event.stopPropagation()
        }

        form.addClass('was-validated');
        // Perform ajax submit here...
    });

</script>
@endsection