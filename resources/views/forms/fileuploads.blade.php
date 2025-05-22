@extends('layouts.vertical', ['page_title' => 'File Uploads', 'mode' => $mode ?? '', 'demo' => $demo ?? ''])

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
                            <li class="breadcrumb-item"><a href="javascript: void(0);">Forms</a></li>
                            <li class="breadcrumb-item active">File Uploads</li>
                        </ol>
                    </div>
                    <h4 class="page-title">File Uploads</h4>
                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="header-title">Dropzone File Upload</h4>
                        <p class="text-muted fs-14">
                            DropzoneJS is an open source library that provides drag’n’drop file uploads with image previews.
                        </p>

                        <form action="/" method="post" class="dropzone" id="myAwesomeDropzone" data-plugin="dropzone" data-previews-container="#file-previews" data-upload-preview-template="#uploadPreviewTemplate">
                            <div class="fallback">
                                <input name="file" type="file" multiple />
                            </div>

                            <div class="dz-message needsclick">
                                <i class="h1 text-muted ri-upload-cloud-2-line"></i>
                                <h3>Drop files here or click to upload.</h3>
                                <span class="text-muted fs-13">(This is just a demo dropzone. Selected files are
                                    <strong>not</strong> actually uploaded.)</span>
                            </div>
                        </form>

                        <!-- Preview -->
                        <div class="dropzone-previews mt-3" id="file-previews"></div>

                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card-->
            </div>
            <!-- end col-->
        </div>
        <!-- end row -->

    </div>
    <!-- container -->


    <!-- file preview template -->
    <div class="d-none" id="uploadPreviewTemplate">
        <div class="card mt-1 mb-0 shadow-none border">
            <div class="p-2">
                <div class="row align-items-center">
                    <div class="col-auto">
                        <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                    </div>
                    <div class="col ps-0">
                        <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                        <p class="mb-0" data-dz-size></p>
                    </div>
                    <div class="col-auto">
                        <!-- Button -->
                        <a href="" class="btn btn-link btn-lg text-danger" data-dz-remove>
                            <i class="ri-close-line"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    @vite(['resources/js/pages/component.fileupload.js'])
@endsection
