<!-- ========== Left Sidebar Start ========== -->
<div class="leftside-menu d-flex flex-column" style="padding-bottom: 0px !important;">

    <!-- Logo -->
    <a href="{{ route('any', 'index') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="/images/logo.png" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="/images/logo-sm.png" alt="small logo">
        </span>
    </a>
    <a href="{{ route('any', 'index') }}" class="logo logo-dark">
        <span class="logo-lg">
            <img src="/images/logo-dark.png" alt="logo">
        </span>
        <span class="logo-sm">
            <img src="/images/logo-sm.png" alt="small logo">
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
            {{-- Background --}}
            <li class="side-nav-item">
                <a href="javascript:void(0)" onclick="setBackground('/template.jpg')" class="side-nav-link">
                    <i class="ri-database-2-line"></i>
                    <span> Background </span>
                </a>
            </li>

            {{-- Image --}}
            <li class="side-nav-item">
                <a href="javascript:void(0)" onclick="addImage()" class="side-nav-link">
                    <i class="ri-award-line"></i>
                    <span> Image </span>
                </a>
            </li>

            {{-- Text --}}
            <li class="side-nav-item">
                <a href="javascript:void(0)" onclick="addText()" class="side-nav-link">
                    <i class="ri-file-edit-line"></i>
                    <span> Text </span>
                </a>
            </li>

            {{-- PLACEHOLDER --}}
            <li class="side-nav-item mt-2" style="margin-left: 20px">
                <span>PLACEHOLDER</span>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" onclick="addPlaceholder('Nama Lengkap')" class="side-nav-link">
                    <i class="ri-bar-chart-box-line"></i>
                    <span> {Nama Lengkap} </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" onclick="addPlaceholder('Jenis Ujian')" class="side-nav-link">
                    <i class="ri-bar-chart-box-line"></i>
                    <span> {Jenis Ujian} </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" onclick="addPlaceholder('Skor Ujian')" class="side-nav-link">
                    <i class="ri-bar-chart-box-line"></i>
                    <span> {Skor Ujian} </span>
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

</div>
