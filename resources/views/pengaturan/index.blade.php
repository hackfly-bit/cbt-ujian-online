@extends('layouts.vertical', ['page_title' => 'Bank Soal', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/datatables.net-bs5/css/dataTables.bootstrap5.min.css', 'node_modules/datatables.net-responsive-bs5/css/responsive.bootstrap5.min.css', 'node_modules/datatables.net-fixedcolumns-bs5/css/fixedColumns.bootstrap5.min.css', 'node_modules/datatables.net-fixedheader-bs5/css/fixedHeader.bootstrap5.min.css', 'node_modules/datatables.net-buttons-bs5/css/buttons.bootstrap5.min.css', 'node_modules/datatables.net-select-bs5/css/select.bootstrap5.min.css'])
@endsection

@section('content')
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show mt-2" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attex</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active">Pengaturan</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pengaturan</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        @php
            $activeTab = request('tab', 'profil'); // default ke 'profil'
        @endphp

        <div class="d-flex justify-content-between align-items-center mb-3">
            <ul class="nav nav-tabs" id="tabPengaturan" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'profil' ? 'active' : '' }}" id="profil-tab"
                        data-bs-toggle="tab" data-bs-target="#profil" type="button" role="tab">Profil</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'branding' ? 'active' : '' }}" id="branding-tab"
                        data-bs-toggle="tab" data-bs-target="#branding" type="button" role="tab">Branding</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'manajemen-user' ? 'active' : '' }}" id="manajemen-user-tab"
                        data-bs-toggle="tab" data-bs-target="#manajemen-user" type="button" role="tab">Manajemen
                        User</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ $activeTab == 'reset-password' ? 'active' : '' }}" id="reset-password-tab"
                        data-bs-toggle="tab" data-bs-target="#reset-password" type="button" role="tab">Reset
                        Password</button>
                </li>
            </ul>
        </div>


        <!-- Konten Tab -->
        <div class="tab-content" id="tabPengaturanContent">
            <div class="tab-pane fade {{ $activeTab == 'profil' ? 'show active' : '' }}" id="profil" role="tabpanel">
                @include('pengaturan.tabs.profil')
            </div>
            <div class="tab-pane fade {{ $activeTab == 'branding' ? 'show active' : '' }}" id="branding" role="tabpanel">
                @include('pengaturan.tabs.branding')
            </div>
            <div class="tab-pane fade {{ $activeTab == 'manajemen-user' ? 'show active' : '' }}" id="manajemen-user"
                role="tabpanel">
                @include('pengaturan.tabs.manajemen-user')
            </div>
            <div class="tab-pane fade {{ $activeTab == 'reset-password' ? 'show active' : '' }}" id="reset-password"
                role="tabpanel">
                @include('pengaturan.tabs.reset-password')
            </div>
        </div>

        <!-- end row-->

    </div>
    <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/main/pengaturan.js'])
@endsection
