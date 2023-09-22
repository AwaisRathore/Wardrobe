<!doctype html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="light" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable">

<head>

    <meta charset="utf-8" />
    <title> <?= $this->renderSection('pageTitle'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= site_url('public/assets/images/favicon.ico') ?>">

    <!-- jsvectormap css -->
    <link href="<?= site_url('public/assets/libs/jsvectormap/css/jsvectormap.min.css') ?>" rel="stylesheet" type="text/css" />

    <!--Swiper slider css-->
    <link href="<?= site_url('public/assets/libs/swiper/swiper-bundle.min.css') ?>" rel="stylesheet" type="text/css" />

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
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <?= $this->renderSection('pageCSS'); ?>


</head>