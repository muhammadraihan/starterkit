@extends('layouts.master')

@section('title', 'Error 500')

@section('body')
<!-- BEGIN Page Wrapper -->
<div class="page-wrapper alt">
    <!-- BEGIN Page Content -->
    <!-- the #js-page-content id is needed for some plugins to initialize -->
    <main id="js-page-content" role="main" class="page-content">
        <div class="h-alt-f d-flex flex-column align-items-center justify-content-center text-center">
            <h1 class="page-error color-fusion-500">
                ERROR <span class="text-gradient">500</span>
                <small class="fw-500">
                    Something <u>went</u> wrong!
                </small>
            </h1>
            <h3 class="fw-500 mb-5">
                You have experienced a technical error. We apologize.
            </h3>
            <h4>
                We are working hard to correct this issue. Please wait a few moments and try again.
                <br><a href="{{url('/')}}">Return Home</a></p>
            </h4>
        </div>
    </main>
    <!-- END Page Content -->
    <!-- BEGIN Page Footer -->
    <footer class="page-footer" role="contentinfo">
        <div class="d-flex align-items-center flex-1 text-muted">
            <span class="hidden-md-down fw-700">{{date('Y')}} &copy; <a href='#' class='text-primary fw-500' title=''
                    target='_blank'>{{env('APP_DEVELOPER','')}}</a> - v{{env('APP_VERSION','')}}</span>
        </div>
        <div>
            <ul class="list-table m-0">
                <li><a href="#" class="text-secondary fw-700">About</a></li>
                <li class="pl-3"><a href="#" class="text-secondary fw-700">License</a>
                </li>
                <li class="pl-3"><a href="#" class="text-secondary fw-700">Documentation</a>
                </li>
            </ul>
        </div>
    </footer>
    <!-- END Page Footer -->
    @endsection