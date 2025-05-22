<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Log Out'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
</head>

<body class="authentication-bg position-relative">

    <div class="position-absolute start-0 end-0 start-0 bottom-0 w-100 h-100">
        <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:svgjs="http://svgjs.com/svgjs" width="100%" height="100%" preserveAspectRatio="none" viewBox="0 0 1920 1028">
            <g mask="url(&quot;#SvgjsMask1166&quot;)" fill="none">
                <use xlink:href="#SvgjsSymbol1173" x="0" y="0"></use>
                <use xlink:href="#SvgjsSymbol1173" x="0" y="720"></use>
                <use xlink:href="#SvgjsSymbol1173" x="720" y="0"></use>
                <use xlink:href="#SvgjsSymbol1173" x="720" y="720"></use>
                <use xlink:href="#SvgjsSymbol1173" x="1440" y="0"></use>
                <use xlink:href="#SvgjsSymbol1173" x="1440" y="720"></use>
            </g>
            <defs>
                <mask id="SvgjsMask1166">
                    <rect width="1920" height="1028" fill="#ffffff"></rect>
                </mask>
                <path d="M-1 0 a1 1 0 1 0 2 0 a1 1 0 1 0 -2 0z" id="SvgjsPath1171"></path>
                <path d="M-3 0 a3 3 0 1 0 6 0 a3 3 0 1 0 -6 0z" id="SvgjsPath1170"></path>
                <path d="M-5 0 a5 5 0 1 0 10 0 a5 5 0 1 0 -10 0z" id="SvgjsPath1169"></path>
                <path d="M2 -2 L-2 2z" id="SvgjsPath1168"></path>
                <path d="M6 -6 L-6 6z" id="SvgjsPath1167"></path>
                <path d="M30 -30 L-30 30z" id="SvgjsPath1172"></path>
            </defs>
            <symbol id="SvgjsSymbol1173">
                <use xlink:href="#SvgjsPath1167" x="30" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="30" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="30" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="30" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="30" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="30" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="90" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="90" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="90" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="90" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="90" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="150" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="150" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="150" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="150" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="150" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="150" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="210" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="210" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="210" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="210" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="210" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="270" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="270" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="270" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="270" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="270" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="270" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1172" x="270" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)" stroke-width="3"></use>
                <use xlink:href="#SvgjsPath1171" x="270" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="330" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="330" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="330" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="330" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="330" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="390" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="390" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="390" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="390" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="390" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="390" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="390" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="390" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="390" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="450" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="450" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="450" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="450" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="450" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="450" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="450" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1172" x="450" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)" stroke-width="3"></use>
                <use xlink:href="#SvgjsPath1168" x="450" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="510" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="510" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1172" x="510" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)" stroke-width="3"></use>
                <use xlink:href="#SvgjsPath1171" x="510" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="510" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="510" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="510" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="510" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="510" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="510" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="510" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="510" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="570" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="570" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="570" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="570" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="570" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="570" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="570" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="570" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="570" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="630" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="630" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="630" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="630" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="630" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="630" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="630" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="690" y="30" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="90" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1170" x="690" y="150" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="210" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="270" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="330" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="390" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1167" x="690" y="450" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="690" y="510" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1169" x="690" y="570" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1168" x="690" y="630" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
                <use xlink:href="#SvgjsPath1171" x="690" y="690" stroke="rgba(var(--ct-primary-rgb), 0.20)"></use>
            </symbol>
        </svg>
    </div>

    <div class="account-pages pt-2 pt-sm-5 pb-4 pb-sm-5 position-relative">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-4 col-lg-5">
                    <div class="card">

                        <!-- Logo -->
                        <div class="card-header py-4 text-center bg-primary">
                            <a href="/auth/login">
                                <span><img src="/images/logo.png" alt="logo" height="22"></span>
                            </a>
                        </div>

                        <div class="card-body p-4">
                            
                            <div class="text-center w-75 m-auto">
                                <h4 class="text-dark-50 text-center mt-0 fw-bold">See You Again !</h4>
                                <p class="text-muted mb-4">You are now successfully sign out.</p>
                            </div>

                            <div class="logout-icon m-auto">
                                <svg version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                viewBox="0 0 161.2 161.2" enable-background="new 0 0 161.2 161.2" xml:space="preserve">
                                    <path class="path" fill="none" stroke="#0acf97" stroke-miterlimit="10" d="M425.9,52.1L425.9,52.1c-2.2-2.6-6-2.6-8.3-0.1l-42.7,46.2l-14.3-16.4
                                        c-2.3-2.7-6.2-2.7-8.6-0.1c-1.9,2.1-2,5.6-0.1,7.7l17.6,20.3c0.2,0.3,0.4,0.6,0.6,0.9c1.8,2,4.4,2.5,6.6,1.4c0.7-0.3,1.4-0.8,2-1.5
                                        c0.3-0.3,0.5-0.6,0.7-0.9l46.3-50.1C427.7,57.5,427.7,54.2,425.9,52.1z"/>
                                    <circle class="path" fill="none" stroke="#0acf97" stroke-width="4" stroke-miterlimit="10" cx="80.6" cy="80.6" r="62.1"/>
                                    <polyline class="path" fill="none" stroke="#0acf97" stroke-width="6" stroke-linecap="round" stroke-miterlimit="10" points="113,52.8
                                        74.1,108.4 48.2,86.4 "/>

                                    <circle class="spin" fill="none" stroke="#0acf97" stroke-width="4" stroke-miterlimit="10" stroke-dasharray="12.2175,12.2175" cx="80.6" cy="80.6" r="73.9"/>
                                </svg>
                            </div> <!-- end logout-icon-->

                        </div> <!-- end card-body-->
                    </div> <!-- end card-->

                    <div class="row mt-3">
                        <div class="col-12 text-center">
                            <p class="text-muted bg-body">Back to <a href="{{ route('second', ['auth', 'login']) }}" class="text-muted ms-1 link-offset-3 text-decoration-underline"><b>Log In</b></a></p>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->

    <footer class="footer footer-alt fw-medium">
        <span class="bg-body">
            <script>
                document.write(new Date().getFullYear())
            </script> © Attex - Coderthemes.com
        </span>
    </footer>
    @vite(['resources/js/app.js'])
    @include('layouts.shared/footer-script')
</body>

</html>
