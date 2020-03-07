<aside class="page-sidebar">
    <div class="page-logo">
        <a href="#" class="page-logo-link press-scale-down d-flex align-items-center position-relative"
            data-toggle="modal" data-target="#modal-shortcut">
            <img src="{{asset('img/wba_logo.png')}}" alt="{{env('APP_NAME','')}}" aria-roledescription="logo">
            <span class="page-logo-text mr-1">{{env('APP_NAME','')}}</span>
            <span class="position-absolute text-white opacity-50 small pos-top pos-right mr-2 mt-n2"></span>
            <i class="fal fa-angle-down d-inline-block ml-1 fs-lg color-primary-300"></i>
        </a>
    </div>
    <!-- BEGIN PRIMARY NAVIGATION -->
    <nav id="js-primary-nav" class="primary-nav" role="navigation">
        <div class="nav-filter">
            <div class="position-relative">
                <input type="text" id="nav_filter_input" placeholder="Filter menu" class="form-control" tabindex="0">
                <a href="#" onclick="return false;" class="btn-primary btn-search-close js-waves-off"
                    data-action="toggle" data-class="list-filter-active" data-target=".page-sidebar">
                    <i class="fal fa-chevron-up"></i>
                </a>
            </div>
        </div>
        <div class="info-card">
            {{-- <img src="{{asset('img/avatar').'/'.Auth::user()->avatar}}" class="profile-image rounded-circle"
            alt="Dr. Codex Lantern">
            <div class="info-card-text">
                <a href="#" class="d-flex align-items-center text-white">
                    <span class="text-truncate text-truncate-sm d-inline-block">
                        {{Auth::user()->name}}
                    </span>
                </a>
                <span class="d-inline-block text-truncate text-truncate-sm">Toronto, Canada</span>
            </div> --}}
            <img src="{{asset('img/card-backgrounds/cover-2-lg.png')}}" class="cover" alt="cover">
            <a href="#" onclick="return false;" class="pull-trigger-btn" data-action="toggle"
                data-class="list-filter-active" data-target=".page-sidebar" data-focus="nav_filter_input">
                <i class="fal fa-angle-down"></i>
            </a>
        </div>
        <ul id="js-nav-menu" class="nav-menu">
            <li>
                <a href="{{route('backoffice.dashboard')}}" title="Dashboard" data-filter-tags="dashboard">
                    <i class="fal fa-desktop"></i>
                    <span class="nav-link-text">Dashboard</span>
                </a>
            </li>
            @hasanyrole('superadmin')
            <li class="nav-title">ACL & Settings</li>
            <li class="">
                <a href="#" title="Theme Settings" data-filter-tags="theme settings">
                    <i class="fal fa-cog"></i>
                    <span class="nav-link-text" data-i18n="nav.theme_settings">Access Control List</span>
                </a>
                <ul>
                    <li>
                        <a href="{{route('users.index')}}" title="Users Managements"
                            data-filter-tags="users managements">
                            <span class="nav-link-text" data-i18n="nav.users_managements">Users Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('permissions.index')}}" title="Permissions Managements"
                            data-filter-tags="permissions managements">
                            <span class="nav-link-text" data-i18n="nav.permissions_managements">Permissions
                                Management</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('roles.index')}}" title="Roles Managements"
                            data-filter-tags="roles managements">
                            <span class="nav-link-text" data-i18n="nav.roles_managements">Roles
                                Management</span>
                        </a>
                    </li>
                </ul>
            </li>
            @endhasanyrole
        </ul>
        <div class="filter-message js-filter-message bg-success-600"></div>
    </nav>
    <!-- END PRIMARY NAVIGATION -->
    <!-- NAV FOOTER -->
    <div class="nav-footer shadow-top">
        <a href="#" onclick="return false;" data-action="toggle" data-class="nav-function-minify"
            class="hidden-md-down">
            <i class="ni ni-chevron-right"></i>
            <i class="ni ni-chevron-right"></i>
        </a>
    </div> <!-- END NAV FOOTER -->
</aside>