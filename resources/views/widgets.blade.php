@extends('layouts.vertical', ['page_title' => 'Widgets', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Extras</a></li>
                            <li class="breadcrumb-item active">Widgets</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Widgets</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-bit-coin-line widget-icon text-bg-danger rounded-circle fs-24"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Revenue">Revenue</h5>
                        <h3 class="my-3">$6,254</h3>
                        <p class="mb-0 text-muted">
                            <span class="badge bg-info me-1">7.00%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-arrow-up-circle-fill widget-icon fs-24"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Growth">Growth</h5>
                        <h3 class="my-3">+ 30.56%</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2">4.87%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat bg-success text-white">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-user-voice-line widget-icon bg-white text-success"></i>
                        </div>
                        <h6 class="text-uppercase mt-0" title="Customers">Customers</h6>
                        <h3 class="my-3">36,254</h3>
                        <p class="mb-0">
                            <span class="badge bg-white bg-opacity-10 me-1">5.27%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div>
                </div>
            </div> <!-- end col-->

            <div class="col-xxl-3 col-sm-6">
                <div class="card widget-flat bg-primary text-white">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-shopping-basket-line widget-icon bg-light-subtle rounded-circle text-primary"></i>
                        </div>
                        <h5 class="fw-normal mt-0" title="Orders">Orders</h5>
                        <h3 class="my-3 text-white">$10,245</h3>
                        <p class="mb-0">
                            <span class="badge bg-info me-1">17.26%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div>
                </div>
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row row-cols-1 row-cols-lg-5">
            <div class="col col-md-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-group-line text-bg-info widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Customers</h5>
                        <h3 class="my-3">54,214</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 5.27%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col col-md-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-shopping-cart-2-line text-bg-warning widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Number of Orders">Orders</h5>
                        <h3 class="my-3">7,543</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-danger me-2"><i class="ri-arrow-down-line"></i> 1.08%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col col-md-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-exchange-dollar-line text-bg-primary widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Average Revenue">Revenue</h5>
                        <h3 class="my-3">$9,254</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-danger me-2"><i class="ri-arrow-down-line"></i> 7.00%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col col-md-6">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-line-chart-line text-bg-success widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Growth">Growth</h5>
                        <h3 class="my-3">+ 20.06%</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 4.87%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col col-md-12">
                <div class="card widget-flat">
                    <div class="card-body">
                        <div class="float-end">
                            <i class="ri-dashboard-2-line bg-danger text-white widget-icon"></i>
                        </div>
                        <h5 class="text-muted fw-normal mt-0" title="Conversation Ration">Conversation</h5>
                        <h3 class="my-3">9.62%</h3>
                        <p class="mb-0 text-muted">
                            <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 5.27%</span>
                            <span class="text-nowrap">Since last month</span>
                        </p>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div> <!-- end row -->


        <div class="row">

            <div class="col-sm-6 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Campaign Sent">Campaign Sent</h5>
                                <h3 class="my-2 py-1">9,184</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 3.27%</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <div id="campaign-sent-chart" data-colors="#3e60d5"></div>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-sm-6 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="New Leads">New Leads</h5>
                                <h3 class="my-2 py-1">3,254</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 5.38%</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <div id="new-leads-chart" data-colors="#47ad77"></div>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-sm-6 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Deals">Deals</h5>
                                <h3 class="my-2 py-1">861</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 4.87%</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <div id="deals-chart" data-colors="#f15776"></div>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->

            <div class="col-sm-6 col-xxl-3">
                <div class="card">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-6">
                                <h5 class="text-muted fw-normal mt-0 text-truncate" title="Booked Revenue">Booked Revenue</h5>
                                <h3 class="my-2 py-1">$253k</h3>
                                <p class="mb-0 text-muted">
                                    <span class="text-success me-2"><i class="ri-arrow-up-line"></i> 11.7%</span>
                                </p>
                            </div>
                            <div class="col-6">
                                <div class="text-end">
                                    <div id="booked-revenue-chart" data-colors="#ffc35a"></div>
                                </div>
                            </div>
                        </div> <!-- end row-->
                    </div> <!-- end card-body -->
                </div> <!-- end card -->
            </div> <!-- end col -->
        </div>
        <!-- end row -->


        <div class="row">
            <div class="col-xl-4">
                <!-- Chat-->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Chat</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div class="chat-conversation">
                        <div class="card-body py-0 mb-3" data-simplebar style="height: 322px;">
                            <ul class="conversation-list">
                                <li class="clearfix">
                                    <div class="chat-avatar">
                                        <img src="/images/users/avatar-5.jpg" alt="male">
                                        <i>10:00</i>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <i>Geneva</i>
                                            <p>
                                                Hello!
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="clearfix odd">
                                    <div class="chat-avatar">
                                        <img src="/images/users/avatar-1.jpg" alt="Female">
                                        <i>10:01</i>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <i>Dominic</i>
                                            <p>
                                                Hi, How are you? What about our next meeting?
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="clearfix">
                                    <div class="chat-avatar">
                                        <img src="/images/users/avatar-5.jpg" alt="male">
                                        <i>10:01</i>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <i>Geneva</i>
                                            <p>
                                                Yeah everything is fine
                                            </p>
                                        </div>
                                    </div>
                                </li>
                                <li class="clearfix odd">
                                    <div class="chat-avatar">
                                        <img src="/images/users/avatar-1.jpg" alt="male">
                                        <i>10:02</i>
                                    </div>
                                    <div class="conversation-text">
                                        <div class="ctext-wrap">
                                            <i>Dominic</i>
                                            <p>
                                                Wow that's great
                                            </p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body pt-0">
                            <form class="needs-validation" novalidate name="chat-form" id="chat-form">
                                <div class="row align-items-start">
                                    <div class="col">
                                        <input type="text" class="form-control chat-input" placeholder="Enter your text" required>
                                        <div class="invalid-feedback">
                                            Please enter your messsage
                                        </div>
                                    </div>
                                    <div class="col-auto d-grid">
                                        <button type="submit" class="btn btn-danger chat-send waves-effect waves-light">Send</button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div> <!-- end .chat-conversation-->

                </div> <!-- end card-->
            </div> <!-- end col-->

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                        <span class="float-start m-2 me-4">
                            <img src="/images/users/avatar-2.jpg" style="height: 100px;" alt="avatar-2" class="rounded-circle img-thumbnail">
                        </span>
                        <div class="">
                            <h4 class="mt-1 mb-1">Michael Franklin</h4>
                            <p class="fs-13"> Authorised Brand Seller</p>

                            <ul class="mb-0 list-inline">
                                <li class="list-inline-item me-3">
                                    <h5 class="mb-1">$ 25,184</h5>
                                    <p class="mb-0 fs-13">Total Revenue</p>
                                </li>
                                <li class="list-inline-item">
                                    <h5 class="mb-1">5482</h5>
                                    <p class="mb-0 fs-13">Number of Orders</p>
                                </li>
                            </ul>
                        </div>
                        <!-- end div-->
                    </div>
                    <!-- end card-body-->
                </div>

                <div class="card cta-box text-bg-info">
                    <div class="card-body">
                        <div class="text-center">
                            <h3 class="m-0 fw-normal cta-box-title">Enhance your <b>Campaign</b> for better outreach</h3>

                            <img class="my-3" src="/images/svg/startman.svg" width="138" alt="Generic placeholder image">

                            <br />

                            <a href="javascript:void(0);" class="btn btn-sm btn-light rounded-pill">Know More <i class="ri-arrow-right-line"></i></a>
                        </div>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->

            </div> <!-- end col-->

            <div class="col-xl-4">
                <!-- Todo-->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Todo</h4>
                        <div class="dropdown float-end">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div class="todoapp">
                        <div class="card-body py-0">
                            <div class="row">
                                <div class="col">
                                    <h5 id="todo-message"><span id="todo-remaining"></span> of <span id="todo-total"></span> remaining</h5>
                                </div>
                                <div class="col-auto">
                                    <a href="" class="float-end btn btn-light btn-sm" id="btn-archive">Archive</a>
                                </div>
                            </div>
                        </div>

                        <div class="card-body py-0 mb-0" style="max-height: 298px;" data-simplebar>
                            <ul class="list-group list-group-flush todo-list" id="todo-list"></ul>
                        </div>

                        <div class="card-body pt-2">
                            <form name="todo-form" id="todo-form" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col">
                                        <input type="text" id="todo-input-text" name="todo-input-text" class="form-control" placeholder="Add new todo" required>
                                        <div class="invalid-feedback">
                                            Please enter your task name
                                        </div>
                                    </div>
                                    <div class="col-auto d-grid">
                                        <button class="btn-primary btn-md btn waves-effect waves-light" type="submit" id="todo-btn-submit">Add</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div> <!-- end .todoapp-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row-->

        <div class="row">
            <div class="col-xl-4">
                <!-- Messages-->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Messages</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div class="inbox-widget">
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="/images/users/avatar-2.jpg" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Tomaslau</p>
                                <p class="inbox-item-text">I've finished it! See you so...</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info fs-13"> Reply </a>
                                </p>
                            </div>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="/images/users/avatar-3.jpg" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Stillnotdavid</p>
                                <p class="inbox-item-text">This theme is awesome!</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info fs-13"> Reply </a>
                                </p>
                            </div>
                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="/images/users/avatar-4.jpg" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Kurafire</p>
                                <p class="inbox-item-text">Nice to meet you</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info fs-13"> Reply </a>
                                </p>
                            </div>

                            <div class="inbox-item">
                                <div class="inbox-item-img"><img src="/images/users/avatar-5.jpg" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Shahedk</p>
                                <p class="inbox-item-text">Hey! there I'm available...</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info fs-13"> Reply </a>
                                </p>
                            </div>
                            <div class="inbox-item pb-0">
                                <div class="inbox-item-img"><img src="/images/users/avatar-6.jpg" class="rounded-circle" alt=""></div>
                                <p class="inbox-item-author">Adhamdannaway</p>
                                <p class="inbox-item-text">This theme is awesome!</p>
                                <p class="inbox-item-date">
                                    <a href="#" class="btn btn-sm btn-link text-info fs-13"> Reply </a>
                                </p>
                            </div>
                        </div> <!-- end inbox-widget -->
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
            <!-- end col-->

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Recent Activity</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body py-0 mb-3" data-simplebar style="max-height: 315px;">
                        <div class="timeline-alt py-0">
                            <div class="timeline-item">
                                <i class="ri-upload-line text-bg-info timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-info fw-bold mb-1 d-block">You sold an item</a>
                                    <small>Paul Burgess just purchased “Attex - Admin Dashboard”!</small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">5 minutes ago</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="ri-rocket-line text-bg-primary timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-primary fw-bold mb-1 d-block">Product on the Bootstrap Market</a>
                                    <small>Dave Gamache added
                                        <span class="fw-bold">Admin Dashboard</span>
                                    </small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">30 minutes ago</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="ri-chat-2-line text-bg-success timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-info fw-bold mb-1 d-block">Robert Delaney</a>
                                    <small>Send you message
                                        <span class="fw-bold">"Are you there?"</span>
                                    </small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">2 hours ago</small>
                                    </p>
                                </div>
                            </div>

                            <div class="timeline-item">
                                <i class="ri-upload-line text-bg-warning timeline-icon"></i>
                                <div class="timeline-item-info">
                                    <a href="#" class="text-primary fw-bold mb-1 d-block">Audrey Tobey</a>
                                    <small>Uploaded a photo
                                        <span class="fw-bold">"Error.jpg"</span>
                                    </small>
                                    <p class="mb-0 pb-2">
                                        <small class="text-muted">14 hours ago</small>
                                    </p>
                                </div>
                            </div>
                        </div>
                        <!-- end timeline -->
                    </div> <!-- end slimscroll -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->

            <div class="col-xl-4">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="header-title">Transactions</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Settings</a>
                                <!-- item-->
                                <a href="javascript:void(0);" class="dropdown-item">Action</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body py-0 mb-3" data-simplebar style="max-height: 315px;">
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-up-line text-danger fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Purchased Attex Admin Template</a>
                                <p class="mb-0 text-muted"><small>Today</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-danger fw-bold pe-2">-$489.30</span>
                            </div>
                        </div>
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-down-line text-success fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Payment received Bootstrap Marketplace</a>
                                <p class="mb-0 text-muted"><small>Yesterday</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-success fw-bold pe-2">+$1578.54</span>
                            </div>
                        </div>
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-down-line text-success fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Freelance work - Shane</a>
                                <p class="mb-0 text-muted"><small>16 Sep 2018</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-success fw-bold pe-2">+$247.5</span>
                            </div>
                        </div>
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-up-line text-danger fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Hire new developer for work</a>
                                <p class="mb-0 text-muted"><small>09 Sep 2018</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-danger fw-bold pe-2">-$185.14</span>
                            </div>
                        </div>
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-down-line text-success fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Money received from paypal</a>
                                <p class="mb-0 text-muted"><small>28 Aug 2018</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-success fw-bold pe-2">+$684.45</span>
                            </div>
                        </div>
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-up-line text-danger fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Zairo landing purchased</a>
                                <p class="mb-0 text-muted"><small>17 Aug 2018</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-danger fw-bold pe-2">-$21.00</span>
                            </div>
                        </div>
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-up-line text-danger fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Purchased Ubold admin template</a>
                                <p class="mb-0 text-muted"><small>17 Aug 2018</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-danger fw-bold pe-2">-$32.89</span>
                            </div>
                        </div>
                        <div class="row py-1 align-items-center">
                            <div class="col-auto">
                                <i class="ri-arrow-down-line text-success fs-18"></i>
                            </div>
                            <div class="col ps-0">
                                <a href="javascript:void(0);" class="text-body">Interest received</a>
                                <p class="mb-0 text-muted"><small>09 Sep 2018</small></p>
                            </div>
                            <div class="col-auto">
                                <span class="text-success fw-bold pe-2">+$784.55</span>
                            </div>
                        </div>
                    </div> <!-- end slimscroll -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->
@endsection

@section('script')
    @vite(['resources/js/pages/demo.widgets.js', 'resources/js/pages/component.chat.js'])
@endsection
