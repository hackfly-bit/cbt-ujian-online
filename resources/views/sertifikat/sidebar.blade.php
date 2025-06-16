<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu d-flex flex-column px-2" style="padding-bottom: 0px !important;">

    @php
        $branding = [
            'logoPutih' =>
                \App\Models\SystemSetting::where('group', 'branding')->where('key', 'logoPutih')->value('value') ?? '',
            'logoHitam' =>
                \App\Models\SystemSetting::where('group', 'branding')->where('key', 'logoHitam')->value('value') ?? '',
            'favLogoPutih' =>
                \App\Models\SystemSetting::where('group', 'branding')->where('key', 'favLogoPutih')->value('value') ??
                '',
            'favLogoHitam' =>
                \App\Models\SystemSetting::where('group', 'branding')->where('key', 'favLogoHitam')->value('value') ??
                '',
        ];
    @endphp

    <!-- Logo -->
    <a href="{{ route('any', 'index') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ $branding['logoPutih'] ? asset($branding['logoPutih']) : asset('images/placeholder.jpeg') }}"
                alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ $branding['favLogoPutih'] ? asset($branding['favLogoPutih']) : asset('images/placeholder.jpeg') }}"
                alt="small logo">
        </span>
    </a>
    <a href="{{ route('any', 'index') }}" class="logo logo-dark">
        <span class="logo-lg">
            <img src="{{ $branding['logoHitam'] ? asset($branding['logoHitam']) : asset('images/placeholder.jpeg') }}"
                alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ $branding['favLogoHitam'] ? asset($branding['favLogoHitam']) : asset('images/placeholder.jpeg') }}"
                alt="small logo">
        </span>
    </a>

    <!-- Optional toggle button -->
    <div class="button-sm-hover" data-bs-toggle="tooltip" data-bs-placement="right" title="Show Full Sidebar">
        <i class="ri-checkbox-blank-circle-line align-middle"></i>
    </div>
    <div class="button-close-fullsidebar">
        <i class="ri-close-fill align-middle"></i>
    </div>

    <!-- Sidebar scrollable content -->
    <div id="leftside-menu-container" class="flex-grow-1 mt-3" data-simplebar style="min-height: 0;">

        <!--- Sidemenu -->
        <ul class="side-nav">

            {{-- Image --}}
            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="btn-add-image">
                    <i class="ri-image-line"></i>
                    <span> Image </span>
                </a>
            </li>

            <!-- Tombol menu sidebar untuk tambah teks -->
            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="btn-add-text">
                    <i class="ri-file-edit-line"></i>
                    <span> Text </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="nama-peserta">
                    <i class="ri-text"></i>
                    <span> [Nama Lengkap] </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="ujian">
                    <i class="ri-file-list-3-line"></i>
                    <span> [Ujian] </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="tanggal-ujian">
                    <i class="ri-calendar-line"></i>
                    <span> [Tanggal Ujian] </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="nilai-ujian">
                    <i class="ri-medal-line"></i>
                    <span> [Nilai Ujian] </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="qr-code">
                    <i class="ri-qr-code-line"></i>
                    <span> [QR Code] </span>
                </a>
            </li>
        </ul>

        <!--- End Sidemenu -->

        <div class="clearfix"></div>
    </div>

    <!-- Logout button fixed at bottom -->
    <div class="back-fixed">
        <a href="{{ route('any', 'index') }}"
            class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 back-button">
            <i class="ri-arrow-left-line"></i>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="logout-fixed">
        <a href="{{ route('any', 'index') }}"
            class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 logout-button">
            <i class="ri-arrow-left-line"></i>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

</div>
