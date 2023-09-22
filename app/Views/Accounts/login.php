<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">

<head>

    <meta charset="utf-8" />
    <title>Sign In </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="public/assets/images/favicon.ico">

    <!-- Layout config Js -->
    <script src="<?= site_url('public/assets/js/layout.js') ?>"></script>
    <!-- Bootstrap Css -->
    <link href="<?= site_url('public/assets/css/bootstrap.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="<?= site_url('public/assets/css/icons.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="<?= site_url('public/assets/css/app.min.css') ?>" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="<?= site_url('public/assets/css/custom.min.css') ?>" rel="stylesheet" type="text/css" />
    <style>
        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="auth-page-wrapper pt-5">
        <!-- auth page bg -->
        <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
            <div class="bg-overlay"></div>

            <div class="shape">
                <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                    <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
                </svg>
            </div>
        </div>

        <!-- auth page content -->
        <div class="auth-page-content">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center mt-sm-5 mb-4 text-white-50">
                            <div>
                                <a href="index.html" class="d-inline-block auth-logo">
                                    <!-- <img src="public/assets/images/logo-light.png" alt="" height="20"> -->
                                </a>
                            </div>
                            <p class="mt-3 fs-15 fw-medium"></p>
                        </div>
                    </div>
                </div>
                <!-- end row -->

                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card mt-4">

                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue to the system.</p>
                                    <!-- Error Alert -->
                                    <?php if (session()->has('warning')) : ?>
                                        <div class="alert alert-danger" role="alert">
                                            <b>Error:</b> <?= session('warning') ?>
                                        </div>
                                    <?php endif ?>
                                    <?php if (session()->has('success')) : ?>
                                        <div class="alert alert-success" role="alert">
                                            <?= session('success') ?>
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="p-2 mt-4">
                                    <form action="" method="post">

                                        <div class="mb-3">
                                            <label for="Email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="Email" name="Email" placeholder="Enter Email" required>
                                            <span class="error">
                                                <?= dispalyErrorMessage('errors', 'Email') ?>
                                            </span>
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="<?= site_url('accounts/forgotPassword') ?>" class="text-muted">Forgot password?</a>
                                            </div>
                                            <label class="form-label" for="Password">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input type="password" class="form-control pe-5 password-input" name="Password" placeholder="Enter password" id="password-input" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                            <span class="error">
                                                <?= dispalyErrorMessage('errors', 'Password') ?>
                                            </span>
                                        </div>



                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>


                                    </form>
                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Don't have an account ? <a href="<?= site_url('Accounts/signup') ?>" class="fw-semibold text-primary text-decoration-underline"> Signup</a> </p>
                        </div>

                    </div>
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end auth page content -->

        <!-- footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center">
                            <p class="mb-0 text-muted">&copy;
                                <script>
                                    document.write(new Date().getFullYear())
                                </script> Employees System.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- end Footer -->
    </div>
    <!-- end auth-page-wrapper -->

    <!-- JAVASCRIPT -->
    <script src="<?= site_url('public/assets/libs/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?= site_url('public/assets/libs/simplebar/simplebar.min.js') ?>"></script>
    <script src="<?= site_url('public/assets/libs/node-waves/waves.min.js') ?>"></script>
    <script src="<?= site_url('public/assets/libs/feather-icons/feather.min.js') ?>"></script>
    <script src="<?= site_url('public/assets/js/pages/plugins/lord-icon-2.1.0.js') ?>"></script>
    <script src="<?= site_url('public/assets/js/plugins.js') ?>"></script>

    <!-- particles js -->
    <script src="<?= site_url('public/assets/libs/particles.js/particles.js') ?>"></script>
    <!-- particles app js -->
    <script src="<?= site_url('public/assets/js/pages/particles.app.js') ?>"></script>
    <!-- password-addon init -->
    <script src="<?= site_url('public/assets/js/pages/password-addon.init.js') ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/jquery.validate.min.js"></script>
    <script>
        $('form').validate();
    </script>
</body>

</html>