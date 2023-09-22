<?= $this->include('Layouts/header'); ?>

<body>

    <!-- Begin page -->
    <div id="layout-wrapper">
        <?= $this->include('Layouts/topbar'); ?>

        <?= $this->include('Layouts/sidebar'); ?>

        <!-- Vertical Overlay-->
        <div class="vertical-overlay"></div>

        <!-- ============================================================== -->
        <!-- Start right Content here -->
        <!-- ============================================================== -->
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <div class="row">
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
                        <?php if (session()->has('error')) : ?>
                            <div class="alert alert-danger" role="alert">
                                <?= session('error') ?>
                            </div>
                        <?php endif ?>
                    </div>
                    <?= $this->renderSection('content') ?>

                </div>
                <!-- container-fluid -->
            </div>
            <!-- End Page-content -->
            <?= $this->include('Layouts/footer_content'); ?>
        </div>
        <!-- END layout-wrapper -->
        <?= $this->include('Layouts/footer'); ?>