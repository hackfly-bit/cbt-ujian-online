@extends('layouts.vertical', ['page_title' => 'Popovers', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Base UI</a></li>
                            <li class="breadcrumb-item active">Popovers</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Popovers</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Simple Popover</h4>
                        <p class="text-muted fs-14">
                            Popover is a component which displays a box with a content after a click on an
                            element - similar to the tooltip but can contain more content.
                        </p>

                        <button type="button" class="btn btn-danger" data-bs-toggle="popover" title="Popover title" data-bs-content="And here's some amazing content. It's very engaging. Right?">Click to toggle
                            popover</button>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Dismiss on Next Click</h4>
                        <p class="text-muted fs-14">Use the <code>focus</code> trigger to dismiss popovers
                            on the user’s next click of a different element than the toggle element.</p>

                        <button type="button" tabindex="0" class="btn btn-success" data-bs-toggle="popover" data-bs-trigger="focus" data-bs-content="And here's some amazing content. It's very engaging. Right?" title="Dismissible popover">
                            Dismissible popover
                        </button>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Hover</h4>
                        <p class="text-muted fs-14">Use the attribute <code>data-bs-trigger="hover"</code>
                            to show the popover on hovering the element.</p>

                        <button type="button" tabindex="0" class="btn btn-dark" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-content="And here's some amazing content. It's very engaging. Right?" title="Ohh Wow !">
                            Please Hover Me
                        </button>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->

            <div class="col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Four Directions</h4>
                        <p class="text-muted fs-14">Four options are available: top, right, bottom, and
                            left aligned.</p>

                        <button type="button" class="btn btn-primary" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="">
                            Popover on top
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="popover" data-bs-placement="bottom" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="">
                            Popover on bottom
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="popover" data-bs-placement="right" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="">
                            Popover on right
                        </button>

                        <button type="button" class="btn btn-primary" data-bs-toggle="popover" data-bs-placement="left" data-bs-content="Vivamus sagittis lacus vel augue laoreet rutrum faucibus." title="Popover title">
                            Popover on left
                        </button>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Custom Popovers </h4>
                        <p class="text-muted fs-14">You can customize the appearance of popovers using CSS variables. We set a custom class with
                            <code>data-bs-custom-class="primary-popover"</code> to scope our custom appearance and use it to override some of the
                            local CSS variables.
                        </p>

                        <div class="d-flex flex-wrap gap-2">
                            <button type="button" class="btn btn-primary" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="primary-popover" data-bs-title="Primary popover" data-bs-content="This popover is themed via CSS variables.">
                                Primary popover
                            </button>

                            <button type="button" class="btn btn-success" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="success-popover" data-bs-title="Success popover" data-bs-content="This popover is themed via CSS variables.">
                                Success popover
                            </button>

                            <button type="button" class="btn btn-danger" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="danger-popover" data-bs-title="Danger popover" data-bs-content="This popover is themed via CSS variables.">
                                Danger popover
                            </button>

                            <button type="button" class="btn btn-info" data-bs-toggle="popover" data-bs-placement="right" data-bs-custom-class="info-popover" data-bs-title="Info popover" data-bs-content="This popover is themed via CSS variables.">
                                Info popover
                            </button>
                        </div>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->

                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Disabled Elements</h4>
                        <p class="text-muted fs-14">Elements with the <code>disabled</code> attribute
                            aren’t interactive, meaning users cannot hover or click them to trigger a
                            popover (or tooltip). As a workaround, you’ll want to trigger the popover from a
                            wrapper <code>&lt;div&gt;</code> or <code>&lt;span&gt;</code> and override the
                            <code>pointer-events</code> on the disabled element.
                        </p>

                        <span class="d-inline-block" data-bs-toggle="popover" data-bs-content="Disabled popover">
                            <button class="btn btn-primary" style="pointer-events: none;" type="button" disabled>Disabled button</button>
                        </span>
                    </div> <!-- end card-body -->
                </div> <!-- end card-->
            </div> <!-- end col -->
        </div>
        <!-- end row -->

    </div> <!-- container -->
    <!-- End Content-->
@endsection
