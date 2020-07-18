@extends('layouts.master')

@section('themes_css')
@stack('css')
<!-- Custom CSS for this page only -->
@yield('css')
@endsection

@section('body')
<!-- BEGIN Page Wrapper -->
<div class="page-wrapper">
    <div class="page-inner">
        <!-- BEGIN Left Aside -->
        @include('partials.sidebar')
        <!-- END Left Aside -->
        <div class="page-content-wrapper">
            <!-- BEGIN Page Header -->
            @include('partials.header')
            <!-- END Page Header -->
            <!-- BEGIN Page Content -->
            <!-- the #js-page-content id is needed for some plugins to initialize -->
            <main id="js-page-content" role="main" class="page-content">
                <ol class="breadcrumb page-breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('backoffice.dashboard')}}"> Backoffice</a></li>
                    @for ($i = 2; $i <= count(Request::segments()); $i++) 
                    <li class="breadcrumb-item">
                        {{ucwords(strtolower(Request::segment($i)))}}
                    </li>
                    @endfor
                    <li class="position-absolute pos-top pos-right d-none d-sm-block"><span class="js-get-date"></span>
                    </li>
                </ol>
                @yield('content')
            </main>
            <!-- this overlay is activated only when mobile menu is triggered -->
            <div class="page-content-overlay" data-action="toggle" data-class="mobile-nav-on"></div>
            <!-- END Page Content -->
            <!-- BEGIN Page Footer -->
            <footer class="page-footer" role="contentinfo">
                <div class="d-flex align-items-center flex-1 text-muted">
                    @php
                        $json = file_get_contents(base_path('package.json'));
                        $decode = json_decode($json,true);
                        $version = $decode['version'];
                    @endphp
                    <span class="hidden-md-down fw-700">{{date('Y')}} &copy; <a href='#' class='text-primary fw-500'
                            title='' target='_blank'>{{env('APP_DEVELOPER','')}}</a> - v {{$version}}</span>
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
        </div>
    </div>
</div>
<!-- END Page Wrapper -->
<!-- BEGIN Quick Menu -->
<!-- to add more items, please make sure to change the variable '$menu-items: number;' in your _page-components-shortcut.scss -->
@include('partials.quickmenu')
<!-- END Quick Menu -->
<!-- BEGIN Messenger -->
<!-- END Messenger -->
<!-- BEGIN Page Settings -->
@include('partials.settings')
<!-- END Page Settings -->
@endsection

@section('themes_js')
@stack('js')
<!-- Custom JS for this page only -->
@yield('js')
@endsection