<!DOCTYPE html>
<html lang="en">

<head>
    @include('layouts.shared/title-meta', ['title' => 'Recover Password'])
    @include('layouts.shared/head-css')
    @vite(['resources/js/head.js'])
</head>

<body class="authentication-bg pb-0">

    <div class="auth-fluid">
        <!--Auth fluid left content -->
        <div class="auth-fluid-form-box">
            <div class="card-body d-flex flex-column h-100 gap-3">

                <!-- Logo -->
                <div class="auth-brand text-center text-lg-start">
                    <a href="{{ route('any', 'index') }}" class="logo-dark">
                        <span><img src="/images/logo-dark.png" alt="dark logo" height="22"></span>
                    </a>
                    <a href="{{ route('any', 'index') }}" class="logo-light">
                        <span><img src="/images/logo.png" alt="logo" height="22"></span>
                    </a>
                </div>

                <div class="my-auto">
                    <!-- title-->
                    <h4>Reset Password</h4>
                    <p class="text-muted mb-4">Enter your email address and we'll send you an email with instructions to reset your password.</p>

                    <!-- form -->
                    <form action="#">
                        <div class="mb-3">
                            <label for="emailaddress" class="form-label">Email address</label>
                            <input class="form-control" type="email" id="emailaddress" required="" placeholder="Enter your email">
                        </div>
                        <div class="mb-0 text-center d-grid">
                            <button class="btn btn-primary" type="submit">Reset Password </button>
                        </div>
                    </form>
                    <!-- end form-->
                </div>

                <!-- Footer-->
                <footer class="footer footer-alt">
                    <p class="text-muted">Back to <a href="{{ route('second', ['auth', 'login-2']) }}" class="text-muted ms-1"><b>Log In</b></a></p>
                </footer>

            </div> <!-- end .card-body -->
        </div>
        <!-- end auth-fluid-form-box-->

        <!-- Auth fluid right content -->
        <div class="auth-fluid-right text-center">
            <div class="auth-user-testimonial">
                <div id="carouselExampleFade" class="carousel slide carousel-fade" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <h2 class="mb-3">I love the color!</h2>
                            <p class="lead"><i class="ri-double-quotes-l"></i> Everything you need is in this template. Love the overall look and feel. Not too flashy, and still very professional and smart.
                            </p>
                            <p>
                                - Admin User
                            </p>
                        </div>
                        <div class="carousel-item">
                            <h2 class="mb-3">Flexibility !</h2>
                            <p class="lead"><i class="ri-double-quotes-l"></i> Pretty nice theme, hoping you guys could add more features to this. Keep up the good work.
                            </p>
                            <p>
                                - Admin User
                            </p>
                        </div>
                        <div class="carousel-item">
                            <h2 class="mb-3">Feature Availability!</h2>
                            <p class="lead"><i class="ri-double-quotes-l"></i> This is a great product, helped us a lot and very quick to work with and implement.
                            </p>
                            <p>
                                - Admin User
                            </p>
                        </div>
                    </div>
                </div>
            </div> <!-- end auth-user-testimonial-->
        </div>
        <!-- end Auth fluid right content -->
    </div>
    <!-- end auth-fluid-->
    
    @vite(['resources/js/app.js'])
    @include('layouts.shared/footer-script')
</body>

</html>