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
    <a href="{{ route('home') }}" class="logo logo-light">
        <span class="logo-lg">
            <img src="{{ $branding['logoPutih'] ? asset($branding['logoPutih']) : asset('images/placeholder.jpeg') }}"
                alt="logo">
        </span>
        <span class="logo-sm">
            <img src="{{ $branding['favLogoPutih'] ? asset($branding['favLogoPutih']) : asset('images/placeholder.jpeg') }}"
                alt="small logo">
        </span>
    </a>
    <a href="{{ route('home') }}" class="logo logo-dark">
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
                <a data-bs-toggle="collapse" href="#sidebarDataPeserta" aria-expanded="false"
                    aria-controls="sidebarDataPeserta" class="side-nav-link">
                    <i class="ri-user-3-line"></i>
                    <span> [Data Peserta] </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarDataPeserta">
                    <ul class="side-nav-second-level">
                        <li>
                            <a href="javascript:void(0)" id="nama-peserta">
                                [Nama Lengkap]
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="no-telp">
                                [No. Telp]
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="alamat-peserta">
                                [Alamat]
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="institusi-peserta">
                                [Institusi]
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="tanggal-lahir">
                                [Tanggal Lahir]
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" id="foto-peserta">
                                [Foto Peserta]
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="ujian">
                    <i class="ri-file-list-3-line"></i>
                    <span> [Nama Ujian] </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a href="javascript:void(0)" class="side-nav-link" id="tanggal-ujian">
                    <i class="ri-calendar-line"></i>
                    <span> [Tanggal Ujian] </span>
                </a>
            </li>

            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarSectionUjian" aria-expanded="false"
                    aria-controls="sidebarSectionUjian" class="side-nav-link">
                    <i class="ri-book-2-line"></i>
                    <span> [Section Ujian] </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarSectionUjian">
                    <ul class="side-nav-second-level" id="submenu-section-ujian">
                        @foreach ($sections as $section)
                            @php
                                $id = strtolower(str_replace(' ', '-', $section->nama_section));
                            @endphp
                            <li>
                                <a href="javascript:void(0)" id="{{ $id }}">
                                    {{ $section->nama_section }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>
            </li>


            <li class="side-nav-item">
                <a data-bs-toggle="collapse" href="#sidebarNilaiUjian" aria-expanded="false"
                    aria-controls="sidebarNilaiUjian" class="side-nav-link">
                    <i class="ri-bar-chart-2-line"></i>
                    <span> [Nilai Ujian] </span>
                    <span class="menu-arrow"></span>
                </a>
                <div class="collapse" id="sidebarNilaiUjian">
                    <ul class="side-nav-second-level" id="submenu-nilai-ujian">
                        @foreach ($sections as $section)
                            @php
                                $id = 'nilai-' . strtolower(str_replace(' ', '-', $section->nama_section));
                            @endphp
                            <li>
                                <a href="javascript:void(0)" id="{{ $id }}">
                                    [Nilai {{ $section->nama_section }}]
                                </a>
                            </li>
                        @endforeach
                        <li>
                            <a href="javascript:void(0)" id="total-nilai">
                                [Total Nilai]
                            </a>
                        </li>
                    </ul>
                </div>
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
        <a href="{{ route('sertifikat.index') }}"
            class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 back-button">
            <i class="ri-arrow-left-line"></i>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

    <div class="logout-fixed">
        <a href="{{ route('sertifikat.index') }}"
            class="btn btn-danger w-100 d-flex align-items-center justify-content-center gap-2 logout-button">
            <i class="ri-arrow-left-line"></i>
            <span>Kembali ke Dashboard</span>
        </a>
    </div>

</div>
