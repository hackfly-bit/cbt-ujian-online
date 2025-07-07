<!-- ========== Topbar Start ========== -->
<div class="navbar-custom">
    <div class="topbar container-fluid">
        <div class="d-flex align-items-center gap-lg-2 gap-1">

            <!-- Topbar Brand Logo -->
            <div class="logo-topbar">
                @php
                    $branding = [
                        'logoPutih' =>
                            \App\Models\SystemSetting::where('group', 'branding')
                                ->where('key', 'logoPutih')
                                ->value('value') ?? '',
                        'logoHitam' =>
                            \App\Models\SystemSetting::where('group', 'branding')
                                ->where('key', 'logoHitam')
                                ->value('value') ?? '',
                        'favLogoPutih' =>
                            \App\Models\SystemSetting::where('group', 'branding')
                                ->where('key', 'favLogoPutih')
                                ->value('value') ?? '',
                        'favLogoHitam' =>
                            \App\Models\SystemSetting::where('group', 'branding')
                                ->where('key', 'favLogoHitam')
                                ->value('value') ?? '',
                    ];
                @endphp


                <!-- Logo light -->
                <a href="/" class="logo-light">
                    <span class="logo-lg">
                        <img src="{{ $branding['logoPutih'] ? asset($branding['logoPutih']) : asset('images/placeholder.jpeg') }}"
                            alt="logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ $branding['favLogoPutih'] ? asset($branding['favLogoPutih']) : asset('images/placeholder.jpeg') }}"
                            alt="small logo">
                    </span>
                </a>

                <!-- Logo Dark -->
                <a href="/" class="logo-dark">
                    <span class="logo-lg">
                        <img src="{{ $branding['logoHitam'] ? asset($branding['logoHitam']) : asset('images/placeholder.jpeg') }}"
                            alt="dark logo">
                    </span>
                    <span class="logo-sm">
                        <img src="{{ $branding['favLogoHitam'] ? asset($branding['favLogoHitam']) : asset('images/placeholder.jpeg') }}"
                            alt="small logo">
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
        </div>

        <!-- Aksi: Preview + Simpan + Select -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
            <!-- Preview -->
            <button class="btn btn-outline-secondary d-flex align-items-center" id="preview">
                <i class="ri-eye-line fs-5 me-md-2"></i>
                <span class="fw-semibold d-none d-md-inline">Preview</span>
            </button>

            <!-- Simpan + Select Ukuran -->
            <div class="d-flex align-items-center">
                <button class="btn btn-primary mx-2 d-flex align-items-center" id="updateTemplate">
                    <i class="ri-save-line fs-5 me-md-2"></i>
                    <span class="d-none d-md-inline">Simpan Perubahan</span>
                </button>

                <select id="canvas-size-selector" class="form-select" style="width: auto;">
                    <option value="a4-landscape" selected>A4 Landscape</option>
                    <option value="a4-portrait">A4 Portrait</option>
                    <option value="f4-landscape">F4 Landscape</option>
                    <option value="f4-portrait">F4 Portrait</option>
                </select>
            </div>
        </div>

        <ul class="topbar-menu d-flex align-items-center gap-3 d-none d-lg-flex">
            <li class="dropdown d-lg-none">
                <a class="nav-link dropdown-toggle arrow-none" data-bs-toggle="dropdown" href="#" role="button"
                    aria-haspopup="false" aria-expanded="false">
                    <i class="ri-search-line fs-22"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-animated dropdown-lg p-0">
                    <form class="p-3">
                        <input type="search" class="form-control" placeholder="Search ..."
                            aria-label="Recipient's username">
                    </form>
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
                <a class="nav-link dropdown-toggle arrow-none nav-user px-2" data-bs-toggle="dropdown" href="#"
                    role="button" aria-haspopup="false" aria-expanded="false">
                    <span class="account-user-avatar">
                        <img src="{{ Auth::user()->foto ? asset(Auth::user()->foto) : asset('images/users/avatar-1.jpg') }}"
                            alt="user-image" height="42" class="rounded-circle shadow-sm">
                    </span>
                    <span class="d-lg-flex flex-column gap-1 d-none">
                        <h5 class="my-0">
                            {{ auth()->user()->name }}
                        </h5>
                        <h6 class="my-0 fw-normal">{{ Auth::user()->role }}</h6>
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
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a onclick="event.preventDefault(); this.closest('form').submit();" class="dropdown-item">
                            <i class="ri-logout-box-line fs-18 align-middle me-1"></i>
                            <span>Logout</span>
                        </a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- ========== Topbar End ========== -->
