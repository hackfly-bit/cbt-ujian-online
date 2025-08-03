@extends('layouts.app-simple')

@section('title', 'Ujian Telah Berakhir')

@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
@endsection

@section('content')
<div class="container-fluid min-vh-100 d-flex align-items-center">
    <div class="row justify-content-center w-100">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <!-- Icon -->
                    <div class="mb-4">
                        <i class="bi bi-clock-history text-warning" style="font-size: 4rem;"></i>
                    </div>

                    <!-- Title -->
                    <h2 class="fw-bold text-dark mb-3">{{ $title }}</h2>

                    <!-- Message -->
                    <p class="text-muted mb-4 fs-5">{{ $message }}</p>

                    @if(isset($ujian))
                    <!-- Ujian Info -->
                    <div class="bg-light rounded p-3 mb-4">
                        <h5 class="fw-semibold text-primary mb-2">{{ $ujian->nama_ujian }}</h5>
                        @if($ujian->deskripsi)
                            <p class="text-muted mb-0">{{ $ujian->deskripsi }}</p>
                        @endif
                    </div>
                    @endif

                    <!-- Additional Info -->
                    <div class="alert alert-warning border-0 mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Informasi:</strong> Silakan hubungi administrator jika Anda merasa ini adalah kesalahan.
                    </div>

                    <!-- Action Button -->
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ url('/') }}" class="btn btn-primary btn-lg px-4">
                            <i class="bi bi-house me-2"></i>Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>

            <!-- Footer Info -->
            <div class="text-center mt-4">
                <small class="text-muted">
                    <i class="bi bi-shield-check me-1"></i>
                    Sistem Ujian Online - Secure & Reliable
                </small>
            </div>
        </div>
    </div>
</div>

<style>
.card {
    border-radius: 15px;
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn {
    border-radius: 10px;
    transition: all 0.3s ease;
}

.btn:hover {
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
}

.alert {
    border-radius: 10px;
}

.bg-light {
    border-radius: 10px;
}
</style>
@endsection
