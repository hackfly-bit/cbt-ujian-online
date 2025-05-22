@extends('layouts.vertical', ['page_title' => 'Pricing', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Attex</a></li>
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Pages</a></li>
                            <li class="breadcrumb-item active">Pricing</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Pricing</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row justify-content-center">
            <div class="col-xxl-10">

                <!-- Pricing Title-->
                <div class="text-center">
                    <h3 class="mb-2">Our <b>Plans</b></h3>
                    <p class="text-muted">
                        We have plans and prices that fit your business perfectly. Make your <br> client site a success with our products.
                    </p>
                </div>

                <!-- Plans -->
                <div class="row my-3">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <p class="fw-bold text-uppercase mb-3">Professional Pack</p>
                                <div class="avatar-md mx-auto">
                                    <span class="avatar-title bg-info-subtle border-info border border-opacity-25 text-info fw-normal fs-24 rounded-circle">
                                        <i class="ri-group-line"></i>
                                    </span>
                                </div>
                                <h2 class="my-3">$19 <span class="text-uppercase fs-14 text-muted">/ Month</span></h2>
                                <ul class="list-unstyled d-grid gap-3">
                                    <li>10 GB Storage</li>
                                    <li>500 GB Bandwidth</li>
                                    <li>No Domain</li>
                                    <li>1 User</li>
                                    <li>Email Support</li>
                                    <li>24x7 Support</li>
                                </ul>
                                <button class="btn btn-primary mt-4 w-100">Change Plan</button>
                            </div>
                        </div> <!-- end Pricing_card -->
                    </div> <!-- end col -->

                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body text-center">
                                <p class="fw-bold text-uppercase mb-3">Business Pack</p>
                                <div class="avatar-md mx-auto">
                                    <span class="avatar-title bg-danger-subtle border-danger border border-opacity-25 text-danger fw-normal fs-24 rounded-circle">
                                        <i class="ri-briefcase-2-line"></i>
                                    </span>
                                </div>
                                <h2 class="my-3">$29 <span class="text-uppercase fs-14 text-muted">/ Month</span></h2>
                                <ul class="list-unstyled d-grid gap-3">
                                    <li>50 GB Storage</li>
                                    <li>900 GB Bandwidth</li>
                                    <li>2 Domain</li>
                                    <li>10 User</li>
                                    <li>Email Support</li>
                                    <li>24x7 Support</li>
                                </ul>
                                <button class="btn btn-danger mt-4 w-100 disabled">Current Plan</button>
                            </div>
                        </div> <!-- end Pricing_card -->
                    </div> <!-- end col -->

                    <div class="col-md-4">
                        <div class="card card-pricing">
                            <div class="card-body text-center">
                                <p class="fw-bold text-uppercase mb-3">Enterprise Pack</p>
                                <div class="avatar-md mx-auto">
                                    <span class="avatar-title bg-info-subtle text-info border-info border border-opacity-25 fw-normal fs-24 rounded-circle">
                                        <i class="ri-community-line"></i>
                                    </span>
                                </div>
                                <h2 class="my-3">$39 <span class="text-uppercase fs-14 text-muted">/ Month</span></h2>
                                <ul class="list-unstyled d-grid gap-3">
                                    <li>100 GB Storege</li>
                                    <li>Unlimited Bandwidth</li>
                                    <li>10 Domain</li>
                                    <li>Unlimited User</li>
                                    <li>Email Support</li>
                                    <li>24x7 Support</li>
                                </ul>
                                <button class="btn btn-primary mt-4 w-100">Change Plan</button>
                            </div>
                        </div> <!-- end Pricing_card -->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection
