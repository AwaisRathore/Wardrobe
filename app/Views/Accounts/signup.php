<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="disable">


<head>

    <meta charset="utf-8" />
    <title>Sign Up </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= site_url('public/assets/images/favicon.ico') ?>">

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
                                    <h5 class="text-primary">Create New Account</h5>
                                    <p class="text-muted">Get your new account to access the system.</p>
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
                                    <form class="needs-validation" novalidate method="post" action="<?= site_url('Accounts/signup') ?>">

                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="useremail" name="email" placeholder="Enter email address" required>
                                            <div class="invalid-feedback">
                                                Please enter email
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Username <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" name="username" id="username" placeholder="Enter username" required>
                                            <div class="invalid-feedback">
                                                Please enter username
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" name="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" required>
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">
                                                    Please enter password
                                                </div>
                                            </div>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                        </div>



                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign Up</button>
                                        </div>


                                    </form>

                                </div>
                            </div>
                            <!-- end card body -->
                        </div>
                        <!-- end card -->

                        <div class="mt-4 text-center">
                            <p class="mb-0">Already have an account ? <a href="<?= site_url('Accounts') ?>" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
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
                                </script> Virtual Wardrobe System.
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
    <!-- validation init -->
    <script src="<?= site_url('public/assets/js/pages/form-validation.init.js') ?>"></script>
    <!-- password create init -->
    <script src="<?= site_url('public/assets/js/pages/passowrd-create.init.js') ?>"></script>
</body>

</html>