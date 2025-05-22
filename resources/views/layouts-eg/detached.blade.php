@extends('layouts.detached', ['page_title' => 'Layout Detached', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    @vite(['node_modules/daterangepicker/daterangepicker.css', 'node_modules/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css'])
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">

        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <form class="d-flex">
                            <div class="input-group">
                                <input type="text" class="form-control shadow border-0" id="dash-daterange">
                                <span class="input-group-text bg-primary border-primary text-white">
                                    <i class="ri-calendar-todo-fill fs-13"></i>
                                </span>
                            </div>
                            <a href="javascript: void(0);" class="btn btn-primary ms-2">
                                <i class="ri-refresh-line"></i>
                            </a>
                        </form>
                    </div>
                    <h4 class="page-title">Detached</h4>
                </div>
            </div>
        </div>

        <div class="row row-cols-1 row-cols-xxl-5 row-cols-lg-3 row-cols-md-2">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="text-muted fw-normal mt-0" title="Number of Customers">Customers</h5>
                                <h3 class="my-3">54,214</h3>
                                <p class="mb-0 text-muted text-truncate">
                                    <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i> 2,541</span>
                                    <span>Since last month</span>
                                </p>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="widget-customers" class="apex-charts" data-colors="#47ad77,#e3e9ee"></div>
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
                                    <span class="badge bg-danger me-1"><i class="ri-arrow-down-line"></i> 1.08%</span>
                                    <span>Since last month</span>
                                </p>
                            </div>
                            <div id="widget-orders" class="apex-charts" data-colors="#3e60d5,#e3e9ee"></div>
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
                                    <span class="badge bg-danger me-1"><i class="ri-arrow-down-line"></i> 7.00%</span>
                                    <span>Since last month</span>
                                </p>
                            </div>
                            <div id="widget-revenue" class="apex-charts" data-colors="#16a7e9,#e3e9ee"></div>
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
                                    <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i> 4.87%</span>
                                    <span>Since last month</span>
                                </p>
                            </div>
                            <div id="widget-growth" class="apex-charts" data-colors="#ffc35a,#e3e9ee"></div>
                        </div>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col col-lg-6 col-md-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div class="flex-grow-1 overflow-hidden">
                                <h5 class="text-muted fw-normal mt-0" title="Conversation Ration">Conversation</h5>
                                <h3 class="my-3">9.62%</h3>
                                <p class="mb-0 text-muted text-truncate">
                                    <span class="badge bg-success me-1"><i class="ri-arrow-up-line"></i> 3.07%</span>
                                    <span>Since last month</span>
                                </p>
                            </div>
                            <div id="widget-conversation" class="apex-charts" data-colors="#f15776,#e3e9ee"></div>
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
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
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
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Current Week</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>$1705.54</span>
                                    </h3>
                                </div>
                                <div class="col">
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Previous Week</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>$6,523.25 <i class="ri-corner-right-up-fill text-success"></i></span>
                                    </h3>
                                </div>
                                <div class="col">
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Conversation</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>8.27%</span>
                                    </h3>
                                </div>
                                <div class="col">
                                    <p class="text-muted mt-3"><i class="ri-donut-chart-fill"></i> Customers</p>
                                    <h3 class="fw-normal mb-3">
                                        <span>69k <i class="ri-corner-right-down-line text-danger"></i></span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-0">
                        <div >
                            <div id="revenue-chart" class="apex-charts mt-3" data-colors="#3e60d5,#47ad77"></div>
                        </div>
                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div> <!-- end col-->
            <div class="col-lg-4">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Total Sales</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
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
                        <div class="alert alert-warning rounded-0 mb-0 border-end-0 border-start-0" role="alert">
                            Something went wrong. Please <strong><a href="#!"
                                    class="alert-link text-decoration-underline">refresh</a></strong> to get new data!
                        </div>
                    </div>

                    <div class="card-body pt-0">
                        <div id="average-sales" class="apex-charts mb-3" data-colors="#3e60d5,#47ad77,#fa5c7c,#16a7e9">
                        </div>

                        <h5 class="mb-1 mt-0 fw-normal">Brooklyn, New York</h5>
                        <div class="progress-w-percent">
                            <span class="progress-value fw-bold">72k </span>
                            <div class="progress progress-sm">
                                <div class="progress-bar" role="progressbar" style="width: 72%;" aria-valuenow="72"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <h5 class="mb-1 mt-0 fw-normal">The Castro, San Francisco</h5>
                        <div class="progress-w-percent">
                            <span class="progress-value fw-bold">39k </span>
                            <div class="progress progress-sm">
                                <div class="progress-bar" role="progressbar" style="width: 39%;" aria-valuenow="39"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>

                        <h5 class="mb-1 mt-0 fw-normal">Kovan, Singapore</h5>
                        <div class="progress-w-percent mb-0">
                            <span class="progress-value fw-bold">61k </span>
                            <div class="progress progress-sm">
                                <div class="progress-bar" role="progressbar" style="width: 61%;" aria-valuenow="61"
                                    aria-valuemin="0" aria-valuemax="100"></div>
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
                            <table class="table table-borderless table-hover table-nowrap table-centered m-0">
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
                            <a href="#!" class="text-primary text-decoration-underline fw-bold btn mb-2">View All</a>
                        </div>
                    </div>
                </div>
            </div> <!-- end col -->

            <div class="col-xl-7">
                <div class="card">
                    <div class="d-flex card-header justify-content-between align-items-center">
                        <h4 class="header-title">Revenue By Locations</h4>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown"
                                aria-expanded="false">
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
@endsection

@section('script')
    @vite(['resources/js/pages/demo.dashboard.js'])
@endsection
