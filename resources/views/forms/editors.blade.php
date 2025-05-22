@extends('layouts.vertical', ['page_title' => 'Editors', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

@section('css')
    <!-- Quill css -->
    @vite(['node_modules/quill/dist/quill.core.css', 'node_modules/quill/dist/quill.snow.css', 'node_modules/quill/dist/quill.bubble.css'])
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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">Editors</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Editors</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <div class="mb-2">
                                <h4 class="header-title mt-2">Quill Editor</h4>
                                <p class="text-muted fs-14">Snow is a clean, flat toolbar theme.</p>

                                <div id="snow-editor" style="height: 300px;">
                                    <h3><span class="ql-size-large">Hello World!</span></h3>
                                    <p><br></p>
                                    <h3>This is an simple editable area.</h3>
                                    <p><br></p>
                                    <ul>
                                        <li>
                                            Select a text to reveal the toolbar.
                                        </li>
                                        <li>
                                            Edit rich document on-the-fly, so elastic!
                                        </li>
                                    </ul>
                                    <p><br></p>
                                    <p>
                                        End of simple area
                                    </p>
                                </div><!-- end Snow-editor-->
                            </div>
                        </li>

                        <li class="list-group-item">
                            <div class="mb-2">
                                <h5 class="mb-1">Bubble Editor</h5>
                                <p class="text-muted fs-14">Bubble is a simple tooltip based theme.</p>

                                <div id="bubble-editor" style="height: 300px;">
                                    <h3><span class="ql-size-large">Hello World!</span></h3>
                                    <p><br></p>
                                    <h3>This is an simple editable area.</h3>
                                    <p><br></p>
                                    <ul>
                                        <li>
                                            Select a text to reveal the toolbar.
                                        </li>
                                        <li>
                                            Edit rich document on-the-fly, so elastic!
                                        </li>
                                    </ul>
                                    <p><br></p>
                                    <p>
                                        End of simple area
                                    </p>
                                </div> <!-- end Snow-editor-->

                            </div>
                        </li>
                    </ul> <!-- end list-->
                </div> <!-- end card-->
            </div> <!-- end col-->
        </div>
        <!-- end row -->

    </div> <!-- container -->
@endsection


@section('script')
    @vite(['resources/js/pages/demo.quilljs.js'])
@endsection
