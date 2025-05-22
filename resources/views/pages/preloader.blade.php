<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Preloader'])
    @yield('css')
    @include('layouts.shared/head-css', ['mode' => $mode ?? '', 'demo' => $demo ?? ''])
    @vite(['node_modules/daterangepicker/daterangepicker.css', 'node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css', 'resources/js/head.js'])

</head>

<body>

    <!-- Pre-loader -->
    <div id="preloader">
        <div id="status">
            <div class="bouncing-loader">
                <div></div>
                <div></div>
                <div></div>
            </div>
        </div>
    </div>
    <!-- End Preloader-->

    <!-- Begin page -->
    <div class="wrapper">


        <!-- ========== Topbar Start ========== -->
        <div class="navbar-custom">
            <div class="topbar container-fluid">
                <div class="d-flex align-items-center gap-lg-2 gap-1">

                    <!-- Topbar Brand Logo -->
                    <div class="logo-topbar">
                        <!-- Logo light -->
                        <a href="/" class="logo-light">
                            <span class="logo-lg">
                                <img src="/images/logo.png" alt="logo">
                            </span>
                            <span class="logo-sm">
                                <img src="/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>

                        <!-- Logo Dark -->
                        <a href="/" class="logo-dark">
                            <span class="logo-lg">
                                <img src="/images/logo-dark.png" alt="dark logo">
                            </span>
                            <span class="logo-sm">
                                <img src="/images/logo-sm.png" alt="small logo">
                            </span>
                        </a>
                    </div>

                    <!-- Sidebar Menu Toggle Button -->
                    <button class="button-toggle-menu">
                        <i class="ri-menu-2-fill"></i>
                    </button>

                    <!-- Horizontal Menu Toggle Button -->
                    <button class="navbar-toggle" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </button>

                    <!-- Topbar Search Form -->
                    <div class="app-search dropdown d-none d-lg-block">
                        <form>
                            <div class="input-group">
                                <input type="search" class="form-control dropdown-toggle" placeholder="Search..."
                                    id="top-search">
                                <span class="ri-search-line search-icon"></span>
                            </div>
                        </form>

                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg" id="search-dropdown">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h5 class="text-overflow mb-1">Found <b class="text-decoration-underline">08</b> results
                                </h5>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-file-chart-line fs-16 me-1"></i>
                                <span>Analytics Report</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-lifebuoy-line fs-16 me-1"></i>
                                <span>How can I help you?</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="ri-user-settings-line fs-16 me-1"></i>
                                <span>User profile settings</span>
                            </a>

                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow mt-2 mb-1 text-uppercase">Users</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="d-flex">
                                        <img class="d-flex me-2 rounded-circle"
                                            src="/images/users/avatar-2.jpg"
                                            alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 fs-14">Erwin Brown</h5>
                                            <span class="fs-12 mb-0">UI Designer</span>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item notify-item">
                                    <div class="d-flex">
                                        <img class="d-flex me-2 rounded-circle"
                                            src="/images/users/avatar-5.jpg"
                                            alt="Generic placeholder image" height="32">
                                        <div class="w-100">
                                            <h5 class="m-0 fs-14">Jacob Deo</h5>
                                            <span class="fs-12 mb-0">Developer</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <ul class="topbar-menu d-flex align-items-center gap-3">
                    <li class="dropdown d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-search-line fs-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                            <form class="p-3">
                                <input type="search" class="form-control" placeholder="Search ..."
                                    aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="/images/flags/us.jpg" alt="user-image"
                                class="me-0 me-sm-1" height="12">
                            <span class="align-middle d-none d-lg-inline-block">English</span> <i
                                class="ri-arrow-down-s-line d-none d-sm-inline-block align-middle"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated">

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="/images/flags/germany.jpg" alt="user-image"
                                    class="me-1" height="12"> <span class="align-middle">German</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="/images/flags/italy.jpg" alt="user-image"
                                    class="me-1" height="12"> <span class="align-middle">Italian</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="/images/flags/spain.jpg" alt="user-image"
                                    class="me-1" height="12"> <span class="align-middle">Spanish</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item">
                                <img src="/images/flags/russia.jpg" alt="user-image"
                                    class="me-1" height="12"> <span class="align-middle">Russian</span>
                            </a>

                        </div>
                    </li>

                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-notification-3-line fs-22"></i>
                            <span class="noti-icon-badge"></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg py-0">
                            <div class="p-2 border-top-0 border-start-0 border-end-0 border-dashed border">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <h6 class="m-0 fs-16 fw-semibold"> Notification</h6>
                                    </div>
                                    <div class="col-auto">
                                        <a href="javascript: void(0);" class="text-dark text-decoration-underline">
                                            <small>Clear All</small>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div style="max-height: 300px;" data-simplebar>

                                <h5 class="text-muted fs-12 fw-bold p-2 text-uppercase mb-0">Today</h5>
                                <!-- item-->

                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item unread-noti card m-0 shadow-none">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="ri-message-3-line fs-18"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold fs-14">Datacorp <small
                                                        class="fw-normal text-muted float-end ms-1">1 min ago</small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted">Caleb Flakelar commented
                                                    on Admin</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item read-noti card m-0 shadow-none">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-info">
                                                    <i class="ri-user-add-line fs-18"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold fs-14">Admin <small
                                                        class="fw-normal text-muted float-end ms-1">1 hr ago</small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted">New user
                                                    registered</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <h5 class="text-muted fs-12 fw-bold p-2 mb-0 text-uppercase">Yesterday</h5>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item read-noti card m-0 shadow-none">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon">
                                                    <img src="/images/users/avatar-2.jpg"
                                                        class="img-fluid rounded-circle" alt="" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold fs-14">Cristina Pride <small
                                                        class="fw-normal text-muted float-end ms-1">1 day ago</small>
                                                </h5>
                                                <small class="noti-item-subtitle text-muted">Hi, How are you? What
                                                    about our next meeting</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <h5 class="text-muted fs-12 fw-bold p-2 mb-0 text-uppercase">31 Jan 2023</h5>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item read-noti card m-0 shadow-none">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon bg-primary">
                                                    <i class="ri-discuss-line fs-18"></i>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold fs-14">Datacorp</h5>
                                                <small class="noti-item-subtitle text-muted">Caleb Flakelar commented
                                                    on Admin</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                                <!-- item-->
                                <a href="javascript:void(0);"
                                    class="dropdown-item p-0 notify-item read-noti card m-0 shadow-none">
                                    <div class="card-body">
                                        <div class="d-flex align-items-center">
                                            <div class="flex-shrink-0">
                                                <div class="notify-icon">
                                                    <img src="/images/users/avatar-4.jpg"
                                                        class="img-fluid rounded-circle" alt="" />
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 text-truncate ms-2">
                                                <h5 class="noti-item-title fw-semibold fs-14">Karen Robinson</h5>
                                                <small class="noti-item-subtitle text-muted">Wow ! this admin looks
                                                    good and awesome design</small>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <!-- All-->
                            <a href="javascript:void(0);"
                                class="dropdown-item text-center text-primary text-decoration-underline fw-bold notify-item border-top border-light py-2">
                                View All
                            </a>

                        </div>
                    </li>

                    <li class="dropdown d-none d-sm-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#"
                            role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="ri-apps-2-line fs-22"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated dropdown-lg p-0">

                            <div class="p-2">
                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="/images/brands/github.png"
                                                alt="Github">
                                            <span>GitHub</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="/images/brands/bitbucket.png"
                                                alt="bitbucket">
                                            <span>Bitbucket</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="/images/brands/dropbox.png"
                                                alt="dropbox">
                                            <span>Dropbox</span>
                                        </a>
                                    </div>
                                </div>

                                <div class="row g-0">
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="/images/brands/slack.png"
                                                alt="slack">
                                            <span>Slack</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="/images/brands/dribbble.png"
                                                alt="dribbble">
                                            <span>Dribbble</span>
                                        </a>
                                    </div>
                                    <div class="col">
                                        <a class="dropdown-icon-item" href="#">
                                            <img src="/images/brands/behance.png"
                                                alt="Behance">
                                            <span>Behance</span>
                                        </a>
                                    </div>
                                </div> <!-- end row-->
                            </div>

                        </div>
                    </li>

                    <li class="d-none d-sm-inline-block">
                        <a class="nav-link" data-bs-toggle="offcanvas" href="#theme-settings-offcanvas">
                            <i class="ri-settings-3-line fs-22"></i>
                        </a>
                    </li>

                    <li class="d-none d-sm-inline-block">
                        <div class="nav-link" id="light-dark-mode" data-bs-toggle="tooltip" data-bs-placement="left"
                            title="Theme Mode">
                            <i class="ri-moon-line fs-22"></i>
                        </div>
                    </li>


                    <li class="d-none d-md-inline-block">
                        <a class="nav-link" href="" data-toggle="fullscreen">
                            <i class="ri-fullscreen-line fs-22"></i>
                        </a>
                    </li>

                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <span class="account-user-avatar">
                                <img src="/images/users/avatar-1.jpg" alt="user-image"
                                    width="32" class="rounded-circle">
                            </span>
                            <span class="d-lg-flex flex-column gap-1 d-none">
                                <h5 class="my-0">
                                    {{-- {{ auth()->user()->name }} --}}
                                    Tosha Minner
                                </h5>
                                <h6 class="my-0 fw-normal">Founder</h6>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end dropdown-menu-animated profile-dropdown">
                            <!-- item-->
                            <div class=" dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome !</h6>
                            </div>

                            <!-- item-->
                            <a href="{{ route('second', ['pages', 'profile']) }}" class="dropdown-item">
                                <i class="ri-account-circle-line fs-18 align-middle me-1"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('second', ['pages', 'profile']) }}" class="dropdown-item">
                                <i class="ri-settings-4-line fs-18 align-middle me-1"></i>
                                <span>Settings</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('second', ['pages', 'faq']) }}" class="dropdown-item">
                                <i class="ri-customer-service-2-line fs-18 align-middle me-1"></i>
                                <span>Support</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('second', ['auth', 'lock-screen']) }}" class="dropdown-item">
                                <i class="ri-lock-password-line fs-18 align-middle me-1"></i>
                                <span>Lock Screen</span>
                            </a>

                            <!-- item-->
                            <a href="{{ route('second', ['auth', 'logout-2']) }}" class="dropdown-item">
                                <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                                <span>Logout</span>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
        <!-- ========== Topbar End ========== -->

        <!-- ========== Left Sidebar Start ========== -->
        <div class="leftside-menu">

            <!-- Brand Logo Light -->
            <a href="/" class="logo logo-light">
                <span class="logo-lg">
                    <img src="/images/logo.png" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Brand Logo Dark -->
            <a href="/" class="logo logo-dark">
                <span class="logo-lg">
                    <img src="/images/logo-dark.png" alt="logo">
                </span>
                <span class="logo-sm">
                    <img src="/images/logo-sm.png" alt="small logo">
                </span>
            </a>

            <!-- Sidebar Hover Menu Toggle Button -->
            <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right"
                title="Show Full Sidebar">
                <i class="ri-checkbox-blank-circle-line align-middle"></i>
            </div>

            <!-- Full Sidebar Menu Close Button -->
            <div class="button-close-fullsidebar">
                <i class="ri-close-fill align-middle"></i>
            </div>

            <!-- Sidebar -left -->
            <div class="h-100" id="leftside-menu-container" data-simplebar>
                <!-- Leftbar User -->
                <div class="leftbar-user">
                    <a href="{{ route('second', ['pages', 'profile']) }}">
                        <img src="/images/users/avatar-1.jpg" alt="user-image"
                            height="42" class="rounded-circle shadow-sm">
                        <span class="leftbar-user-name mt-2">Tosha Minner</span>
                    </a>
                </div>

                <!--- Sidemenu -->
                <ul class="side-nav">

                    <li class="side-nav-title">Navigation</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarDashboards" aria-expanded="false"
                            aria-controls="sidebarDashboards" class="side-nav-link">
                            <i class="ri-home-4-line"></i>
                            <span class="badge bg-success float-end">2</span>
                            <span> Dashboards </span>
                        </a>
                        <div class="collapse" id="sidebarDashboards">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('any', 'analytics') }}">Analytics</a>
                                </li>
                                <li>
                                    <a href="{{ route('any', 'index') }}">Ecommerce</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-title">Apps</li>

                    <li class="side-nav-item">
                        <a href="{{ route('second', ['apps', 'calendar']) }}" class="side-nav-link">
                            <i class="ri-calendar-event-line"></i>
                            <span> Calendar </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('second', ['apps', 'chat']) }}" class="side-nav-link">
                            <i class="ri-message-3-line"></i>
                            <span> Chat </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarEmail" aria-expanded="false"
                            aria-controls="sidebarEmail" class="side-nav-link">
                            <i class="ri-mail-line"></i>
                            <span> Email </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarEmail">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['email', 'inbox']) }}">Inbox</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['email', 'read']) }}">Read Email</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarTasks" aria-expanded="false"
                            aria-controls="sidebarTasks" class="side-nav-link">
                            <i class="ri-task-line"></i>
                            <span> Tasks </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarTasks">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['task', 'list']) }}">List</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['task', 'details']) }}">Details</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('second', ['apps', 'kanban']) }}" class="side-nav-link">
                            <i class="ri-list-check-3"></i>
                            <span> Kanban Board </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('second', ['apps', 'file-manager']) }}" class="side-nav-link">
                            <i class="ri-folder-2-line"></i>
                            <span> File Manager </span>
                        </a>
                    </li>

                    <li class="side-nav-title">Custom</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPages" aria-expanded="false"
                            aria-controls="sidebarPages" class="side-nav-link">
                            <i class="ri-pages-line"></i>
                            <span> Pages </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPages">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['pages', 'profile']) }}">Profile</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['pages', 'invoice']) }}">Invoice</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['pages', 'faq']) }}">FAQ</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['pages', 'pricing']) }}">Pricing</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['pages', 'maintenance']) }}">Maintenance</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['pages', 'starter']) }}">Starter Page</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['pages', 'preloader']) }}">With Preloader</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['pages', 'timeline']) }}">Timeline</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPagesAuth" aria-expanded="false"
                            aria-controls="sidebarPagesAuth" class="side-nav-link">
                            <i class="ri-shield-user-line"></i>
                            <span> Auth Pages </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPagesAuth">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['auth', 'login']) }}">Login</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'login-2']) }}">Login 2</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'register']) }}">Register</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'register-2']) }}">Register 2</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'logout']) }}">Logout</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'logout-2']) }}">Logout 2</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'recoverpw']) }}">Recover Password</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'recoverpw-2']) }}">Recover Password 2</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'lock-screen']) }}">Lock Screen</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'lock-screen-2']) }}">Lock Screen 2</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'confirm-mail']) }}">Confirm Mail</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['auth', 'confirm-mail-2']) }}">Confirm Mail 2</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarPagesError" aria-expanded="false"
                            aria-controls="sidebarPagesError" class="side-nav-link">
                            <i class="ri-error-warning-line"></i>
                            <span> Error Pages </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarPagesError">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['error', '404']) }}">Error 404</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['error', '404-alt']) }}">Error 404-alt</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['error', '500']) }}">Error 500</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarLayouts" aria-expanded="false"
                            aria-controls="sidebarLayouts" class="side-nav-link">
                            <i class="ri-layout-line"></i>
                            <span> Layouts </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarLayouts">
                            <ul class="side-nav-second-level">
                                <li class="menu-item">
                                    <a class="menu-link"
                                        href="{{ route('second', ['layouts-eg', 'horizontal']) }}"><span
                                            class="menu-text">Horizontal</span></a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link"
                                        href="{{ route('second', ['layouts-eg', 'detached']) }}"><span
                                            class="menu-text">Detached</span></a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link"
                                        href="{{ route('second', ['layouts-eg', 'full-view']) }}"><span
                                            class="menu-text">Full View</span></a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link"
                                        href="{{ route('second', ['layouts-eg', 'fullscreen-view']) }}"><span
                                            class="menu-text">Fullscreen View</span></a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link"
                                        href="{{ route('second', ['layouts-eg', 'hover-menu']) }}"><span
                                            class="menu-text">Hover Menu</span></a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link"
                                        href="{{ route('second', ['layouts-eg', 'compact']) }}"><span
                                            class="menu-text">Compact</span></a>
                                </li>
                                <li class="menu-item">
                                    <a class="menu-link"
                                        href="{{ route('second', ['layouts-eg', 'icon-view']) }}"><span
                                            class="menu-text">Icon View</span></a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-title">Components</li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarBaseUI" aria-expanded="false"
                            aria-controls="sidebarBaseUI" class="side-nav-link">
                            <i class="ri-briefcase-line"></i>
                            <span> Base UI </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarBaseUI">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['ui', 'accordions']) }}">Accordions</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'alerts']) }}">Alerts</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'avatars']) }}">Avatars</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'badges']) }}">Badges</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'breadcrumb']) }}">Breadcrumb</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'buttons']) }}">Buttons</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'cards']) }}">Cards</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'carousel']) }}">Carousel</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'collapse']) }}">Collapse</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'dropdowns']) }}">Dropdowns</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'embed-video']) }}">Embed Video</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'grid']) }}">Grid</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'links']) }}">Links</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'list-group']) }}">List Group</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'modals']) }}">Modals</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'notifications']) }}">Notifications</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'offcanvas']) }}">Offcanvas</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'placeholders']) }}">Placeholders</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'pagination']) }}">Pagination</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'popovers']) }}">Popovers</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'progress']) }}">Progress</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'spinners']) }}">Spinners</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'tabs']) }}">Tabs</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'tooltips']) }}">Tooltips</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'typography']) }}">Typography</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['ui', 'utilities']) }}">Utilities</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarExtendedUI" aria-expanded="false"
                            aria-controls="sidebarExtendedUI" class="side-nav-link">
                            <i class="ri-stack-line"></i>
                            <span> Extended UI </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarExtendedUI">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['extended', 'dragula']) }}">Dragula</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['extended', 'range-slider']) }}">Range Slider</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['extended', 'ratings']) }}">Ratings</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['extended', 'scrollbar']) }}">Scrollbar</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['extended', 'scrollspy']) }}">Scrollspy</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a href="{{ route('any', 'widgets') }}" class="side-nav-link">
                            <i class="ri-pencil-ruler-2-line"></i>
                            <span> Widgets </span>
                        </a>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarIcons" aria-expanded="false"
                            aria-controls="sidebarIcons" class="side-nav-link">
                            <i class="ri-service-line"></i>
                            <span> Icons </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarIcons">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['icons', 'remixicons']) }}">Remix Icons</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['icons', 'bootstrapicons']) }}">Bootstrap Icons</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarCharts" aria-expanded="false"
                            aria-controls="sidebarCharts" class="side-nav-link">
                            <i class="ri-bar-chart-line"></i>
                            <span> Charts </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarCharts">
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarApexCharts" aria-expanded="false"
                                        aria-controls="sidebarApexCharts">
                                        <span> Apex Charts </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarApexCharts">
                                        <ul class="side-nav-third-level">
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-area']) }}">Area</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-bar']) }}">Bar</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-bubble']) }}">Bubble</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-candlestick']) }}">Candlestick</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-column']) }}">Column</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-heatmap']) }}">Heatmap</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-line']) }}">Line</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-mixed']) }}">Mixed</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-timeline']) }}">Timeline</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-boxplot']) }}">Boxplot</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-treemap']) }}">Treemap</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-pie']) }}">Pie</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-radar']) }}">Radar</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-radialbar']) }}">RadialBar</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-scatter']) }}">Scatter</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'apex-polar-area']) }}">Polar
                                                    Area</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'apex-sparklines']) }}">Sparklines</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarChartJSCharts" aria-expanded="false"
                                        aria-controls="sidebarChartJSCharts">
                                        <span> ChartJS </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarChartJSCharts">
                                        <ul class="side-nav-third-level">
                                            <li>
                                                <a href="{{ route('second', ['charts', 'chartjs-area']) }}">Area</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'chartjs-bar']) }}">Bar</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('second', ['charts', 'chartjs-line']) }}">Line</a>
                                            </li>
                                            <li>
                                                <a
                                                    href="{{ route('second', ['charts', 'chartjs-other']) }}">Other</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarForms" aria-expanded="false"
                            aria-controls="sidebarForms" class="side-nav-link">
                            <i class="ri-survey-line"></i>
                            <span> Forms </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarForms">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['form', 'elements']) }}">Basic Elements</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['form', 'advanced']) }}">Form Advanced</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['form', 'validation']) }}">Validation</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['form', 'wizard']) }}">Wizard</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['form', 'fileuploads']) }}">File Uploads</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['form', 'editors']) }}">Editors</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarTables" aria-expanded="false"
                            aria-controls="sidebarTables" class="side-nav-link">
                            <i class="ri-table-line"></i>
                            <span> Tables </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarTables">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['tables', 'basic']) }}">Basic Tables</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['tables', 'datatable']) }}">Data Tables</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarMaps" aria-expanded="false"
                            aria-controls="sidebarMaps" class="side-nav-link">
                            <i class="ri-treasure-map-line"></i>
                            <span> Maps </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarMaps">
                            <ul class="side-nav-second-level">
                                <li>
                                    <a href="{{ route('second', ['maps', 'google']) }}">Google Maps</a>
                                </li>
                                <li>
                                    <a href="{{ route('second', ['maps', 'vector']) }}">Vector Maps</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="side-nav-item">
                        <a data-bs-toggle="collapse" href="#sidebarMultiLevel" aria-expanded="false"
                            aria-controls="sidebarMultiLevel" class="side-nav-link">
                            <i class="ri-share-line"></i>
                            <span> Multi Level </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="sidebarMultiLevel">
                            <ul class="side-nav-second-level">
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarSecondLevel" aria-expanded="false"
                                        aria-controls="sidebarSecondLevel">
                                        <span> Second Level </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarSecondLevel">
                                        <ul class="side-nav-third-level">
                                            <li>
                                                <a href="javascript: void(0);">Item 1</a>
                                            </li>
                                            <li>
                                                <a href="javascript: void(0);">Item 2</a>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                                <li class="side-nav-item">
                                    <a data-bs-toggle="collapse" href="#sidebarThirdLevel" aria-expanded="false"
                                        aria-controls="sidebarThirdLevel">
                                        <span> Third Level </span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <div class="collapse" id="sidebarThirdLevel">
                                        <ul class="side-nav-third-level">
                                            <li>
                                                <a href="javascript: void(0);">Item 1</a>
                                            </li>
                                            <li class="side-nav-item">
                                                <a data-bs-toggle="collapse" href="#sidebarFourthLevel"
                                                    aria-expanded="false" aria-controls="sidebarFourthLevel">
                                                    <span> Item 2 </span>
                                                    <span class="menu-arrow"></span>
                                                </a>
                                                <div class="collapse" id="sidebarFourthLevel">
                                                    <ul class="side-nav-forth-level">
                                                        <li>
                                                            <a href="javascript: void(0);">Item 2.1</a>
                                                        </li>
                                                        <li>
                                                            <a href="javascript: void(0);">Item 2.2</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </li>


                </ul>
                <!--- End Sidemenu -->

                <div class="clearfix"></div>
            </div>
        </div>
        <!-- ========== Left Sidebar End ========== -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">

                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <div class="page-title-right">
                                    <form class="d-flex">
                                        <div class="input-group">
                                            <input type="text" class="form-control shadow border-0"
                                                id="dash-daterange">
                                            <span class="input-group-text bg-primary border-primary text-white">
                                                <i class="ri-calendar-todo-fill fs-13"></i>
                                            </span>
                                        </div>
                                        <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                            <i class="ri-refresh-line"></i>
                                        </a>
                                    </form>
                                </div>
                                <h4 class="page-title">Preloader</h4>
                            </div>
                        </div>
                    </div>

                    <div class="row row-cols-1 row-cols-xxl-5 row-cols-lg-3 row-cols-md-2">
                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Customers">
                                                Customers</h5>
                                            <h3 class="my-3">54,214</h3>
                                            <p class="mb-0 text-muted text-truncate">
                                                <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i>
                                                    2,541</span>
                                                <span>Since last month</span>
                                            </p>
                                        </div>
                                        <div class="flex-shrink-0">
                                            <div id="widget-customers" class="apex-charts"
                                                data-colors="#47ad77,#e3e9ee"></div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Orders</h5>
                                            <h3 class="my-3">7,543</h3>
                                            <p class="mb-0 text-muted text-truncate">
                                                <span class="badge bg-danger me-1"><i class="ri-arrow-down-line"></i>
                                                    1.08%</span>
                                                <span>Since last month</span>
                                            </p>
                                        </div>
                                        <div id="widget-orders" class="apex-charts" data-colors="#3e60d5,#e3e9ee">
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Revenue</h5>
                                            <h3 class="my-3">$9,254</h3>
                                            <p class="mb-0 text-muted text-truncate">
                                                <span class="badge bg-danger me-1"><i class="ri-arrow-down-line"></i>
                                                    7.00%</span>
                                                <span>Since last month</span>
                                            </p>
                                        </div>
                                        <div id="widget-revenue" class="apex-charts" data-colors="#16a7e9,#e3e9ee">
                                        </div>
                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                        <div class="col col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted fw-normal mt-0" title="Growth">Growth</h5>
                                            <h3 class="my-3">+ 20.6%</h3>
                                            <p class="mb-0 text-muted text-truncate">
                                                <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i>
                                                    4.87%</span>
                                                <span>Since last month</span>
                                            </p>
                                        </div>
                                        <div id="widget-growth" class="apex-charts" data-colors="#ffc35a,#e3e9ee">
                                        </div>
                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col col-lg-6 col-md-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between">
                                        <div class="flex-grow-1 overflow-hidden">
                                            <h5 class="text-muted fw-normal mt-0" title="Conversation Ration">
                                                Conversation</h5>
                                            <h3 class="my-3">9.62%</h3>
                                            <p class="mb-0 text-muted text-truncate">
                                                <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i>
                                                    3.07%</span>
                                                <span>Since last month</span>
                                            </p>
                                        </div>
                                        <div id="widget-conversation" class="apex-charts"
                                            data-colors="#f15776,#e3e9ee"></div>
                                    </div>

                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                    </div> <!-- end row -->

                    <div class="row">
                        <div class="col-lg-8">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <h4 class="header-title">Revenue</h4>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="bg-light-subtle border-top border-bottom border-light">
                                        <div class="row text-center">
                                            <div class="col">
                                                <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Current
                                                    Week</p>
                                                <h3 class="fw-normal mb-3">
                                                    <span>$1705.54</span>
                                                </h3>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i>
                                                    Previous Week</p>
                                                <h3 class="fw-normal mb-3">
                                                    <span>$6,523.25 <i
                                                            class="ri-corner-right-up-fill text-success"></i></span>
                                                </h3>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i>
                                                    Conversation</p>
                                                <h3 class="fw-normal mb-3">
                                                    <span>8.27%</span>
                                                </h3>
                                            </div>
                                            <div class="col">
                                                <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i>
                                                    Customers</p>
                                                <h3 class="fw-normal mb-3">
                                                    <span>69k <i
                                                            class="ri-corner-right-down-line text-danger"></i></span>
                                                </h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body pt-0">
                                    <div >
                                        <div id="revenue-chart" class="apex-charts mt-3"
                                            data-colors="#3e60d5,#47ad77"></div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <h4 class="header-title">Total Sales</h4>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body p-0">
                                    <div class="alert alert-warning rounded-0 mb-0 border-end-0 border-start-0"
                                        role="alert">
                                        Something went wrong. Please <strong><a href="#!"
                                                class="alert-link text-decoration-underline">refresh</a></strong> to
                                        get new data!
                                    </div>
                                </div>

                                <div class="card-body pt-0">
                                    <div id="average-sales" class="apex-charts mb-3"
                                        data-colors="#3e60d5,#47ad77,#fa5c7c,#16a7e9"></div>

                                    <h5 class="mb-1 mt-0 fw-normal">Brooklyn, New York</h5>
                                    <div class="progress-w-percent">
                                        <span class="progress-value fw-bold">72k </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" role="progressbar" style="width: 72%;"
                                                aria-valuenow="72" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <h5 class="mb-1 mt-0 fw-normal">The Castro, San Francisco</h5>
                                    <div class="progress-w-percent">
                                        <span class="progress-value fw-bold">39k </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" role="progressbar" style="width: 39%;"
                                                aria-valuenow="39" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>

                                    <h5 class="mb-1 mt-0 fw-normal">Kovan, Singapore</h5>
                                    <div class="progress-w-percent mb-0">
                                        <span class="progress-value fw-bold">61k </span>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" role="progressbar" style="width: 61%;"
                                                aria-valuenow="61" aria-valuemin="0" aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                </div> <!-- end card-body-->
                            </div> <!-- end card-->
                        </div> <!-- end col-->

                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-xl-5">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <h4 class="header-title">Top Selling Products</h4>
                                    <a href="javascript:void(0);" class="btn btn-sm btn-info">Export <i
                                            class="ri-download-line ms-1"></i></a>
                                </div>
                                <div class="card-body p-0">
                                    <div class="table-responsive">
                                        <table
                                            class="table table-borderless table-hover table-nowrap table-centered m-0">
                                            <thead class="border-top border-bottom bg-light-subtle border-light">
                                                <tr>
                                                    <th class="py-1">Product</th>
                                                    <th class="py-1">Price</th>
                                                    <th class="py-1">Orders</th>
                                                    <th class="py-1">Avl. Quantity</th>
                                                    <th class="py-1">Seller</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>ASOS Ridley High Waist</td>
                                                    <td>$79.49</td>
                                                    <td>82</td>
                                                    <td>8,540</td>
                                                    <td>Adidas</td>
                                                </tr>
                                                <tr>
                                                    <td>Marco Lightweight Shirt</td>
                                                    <td>$12.5</td>
                                                    <td>58</td>
                                                    <td>6,320</td>
                                                    <td>Puma</td>
                                                </tr>
                                                <tr>
                                                    <td>Half Sleeve Shirt</td>
                                                    <td>$9.99</td>
                                                    <td>254</td>
                                                    <td>10,258</td>
                                                    <td>Nike</td>
                                                </tr>
                                                <tr>
                                                    <td>Lightweight Jacket</td>
                                                    <td>$69.99</td>
                                                    <td>560</td>
                                                    <td>1,020</td>
                                                    <td>Puma</td>
                                                </tr>
                                                <tr>
                                                    <td>Marco Sport Shoes</td>
                                                    <td>$119.99</td>
                                                    <td>75</td>
                                                    <td>357</td>
                                                    <td>Adidas</td>
                                                </tr>
                                                <tr>
                                                    <td>Custom Women's T-shirts</td>
                                                    <td>$45.00</td>
                                                    <td>85</td>
                                                    <td>135</td>
                                                    <td>Branded</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="text-center">
                                        <a href="#!"
                                            class="text-primary text-decoration-underline fw-bold btn mb-2">View
                                            All</a>
                                    </div>
                                </div>
                            </div>
                        </div> <!-- end col -->

                        <div class="col-xl-7">
                            <div class="card">
                                <div class="d-flex card-header justify-content-between align-items-center">
                                    <h4 class="header-title">Revenue By Locations</h4>
                                    <div class="dropdown">
                                        <a href="#" class="dropdown-toggle arrow-none card-drop"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-end">
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Sales Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Export Report</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Profit</a>
                                            <!-- item-->
                                            <a href="javascript:void(0);" class="dropdown-item">Action</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div id="world-map-markers" class="mt-3 mb-3" style="height: 298px">
                                            </div>
                                        </div>
                                        <div class="col-lg-4" >
                                            <div id="country-chart" class="apex-charts" data-colors="#47ad77"></div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card-->
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div>
                <!-- container -->

            </div>
            <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            <script>
                                document.write(new Date().getFullYear())
                            </script> © Attex - Coderthemes.com
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-end footer-links d-none d-md-block">
                                <a href="javascript: void(0);">About</a>
                                <a href="javascript: void(0);">Support</a>
                                <a href="javascript: void(0);">Contact Us</a>
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->

    </div>
    <!-- END wrapper -->

    <!-- Theme Settings -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="theme-settings-offcanvas">
        <div class="d-flex align-items-center bg-primary p-3 offcanvas-header">
            <h5 class="text-white m-0">Theme Settings</h5>
            <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="offcanvas"
                aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0">
            <div data-simplebar class="h-100">
                <div class="card mb-0 p-3">
                    <div class="alert alert-warning" role="alert">
                        <strong>Customize </strong> the overall color scheme, sidebar menu, etc.
                    </div>

                    <h5 class="my-3 fs-16 fw-bold">Color Scheme</h5>

                    <div class="d-flex flex-column gap-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                id="layout-color-light" value="light">
                            <label class="form-check-label" for="layout-color-light">Light</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-bs-theme"
                                id="layout-color-dark" value="dark">
                            <label class="form-check-label" for="layout-color-dark">Dark</label>
                        </div>
                    </div>

                    <div id="layout-width">
                        <h5 class="my-3 fs-16 fw-bold">Layout Mode</h5>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                    id="layout-mode-fluid" value="fluid">
                                <label class="form-check-label" for="layout-mode-fluid">Fluid</label>
                            </div>

                            <div id="layout-boxed">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                        id="layout-mode-boxed" value="boxed">
                                    <label class="form-check-label" for="layout-mode-boxed">Boxed</label>
                                </div>
                            </div>

                            <div id="layout-detached">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" name="data-layout-mode"
                                        id="data-layout-detached" value="detached">
                                    <label class="form-check-label" for="data-layout-detached">Detached</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <h5 class="my-3 fs-16 fw-bold">Topbar Color</h5>

                    <div class="d-flex flex-column gap-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                id="topbar-color-light" value="light">
                            <label class="form-check-label" for="topbar-color-light">Light</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                id="topbar-color-dark" value="dark">
                            <label class="form-check-label" for="topbar-color-dark">Dark</label>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="data-topbar-color"
                                id="topbar-color-brand" value="brand">
                            <label class="form-check-label" for="topbar-color-brand">Brand</label>
                        </div>
                    </div>

                    <div>
                        <h5 class="my-3 fs-16 fw-bold">Menu Color</h5>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-menu-color"
                                    id="leftbar-color-light" value="light">
                                <label class="form-check-label" for="leftbar-color-light">Light</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-menu-color"
                                    id="leftbar-color-dark" value="dark">
                                <label class="form-check-label" for="leftbar-color-dark">Dark</label>
                            </div>
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-menu-color"
                                    id="leftbar-color-brand" value="brand">
                                <label class="form-check-label" for="leftbar-color-brand">Brand</label>
                            </div>
                        </div>
                    </div>

                    <div id="sidebar-size">
                        <h5 class="my-3 fs-16 fw-bold">Sidebar Size</h5>

                        <div class="d-flex flex-column gap-2">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-default" value="default">
                                <label class="form-check-label" for="leftbar-size-default">Default</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-compact" value="compact">
                                <label class="form-check-label" for="leftbar-size-compact">Compact</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-small" value="condensed">
                                <label class="form-check-label" for="leftbar-size-small">Condensed</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-small-hover" value="sm-hover">
                                <label class="form-check-label" for="leftbar-size-small-hover">Hover View</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-full" value="full">
                                <label class="form-check-label" for="leftbar-size-full">Full Layout</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="data-sidenav-size"
                                    id="leftbar-size-fullscreen" value="fullscreen">
                                <label class="form-check-label" for="leftbar-size-fullscreen">Fullscreen
                                    Layout</label>
                            </div>
                        </div>
                    </div>

                    <div id="layout-position">
                        <h5 class="my-3 fs-16 fw-bold">Layout Position</h5>

                        <div class="btn-group checkbox" role="group">
                            <input type="radio" class="btn-check" name="data-layout-position"
                                id="layout-position-fixed" value="fixed">
                            <label class="btn btn-soft-primary w-sm" for="layout-position-fixed">Fixed</label>

                            <input type="radio" class="btn-check" name="data-layout-position"
                                id="layout-position-scrollable" value="scrollable">
                            <label class="btn btn-soft-primary w-sm ms-0"
                                for="layout-position-scrollable">Scrollable</label>
                        </div>
                    </div>

                    <div id="sidebar-user">
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <label class="fs-16 fw-bold m-0" for="sidebaruser-check">Sidebar User Info</label>
                            <div class="form-check form-switch">
                                <input type="checkbox" class="form-check-input" name="  sidebar-user"
                                    id="sidebaruser-check">
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
        <div class="offcanvas-footer border-top p-3 text-center">
            <div class="row">
                <div class="col-6">
                    <button type="button" class="btn btn-light w-100" id="reset-layout">Reset</button>
                </div>
                <div class="col-6">
                    <a href="#" role="button" class="btn btn-primary w-100">Buy Now</a>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/js/pages/demo.dashboard.js', 'resources/js/app.js', 'resources/js/layout.js'])

</body>

</html>
