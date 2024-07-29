<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>coustomer</title>
    <!-- General CSS Files -->
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/app.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/style.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/components.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='public/assets/img/favicon.ico' />
    <link rel="stylesheet" href="assets/css/app.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">


</head>
<style>
/* Style for required field labels */
label.error {
    color: red;
}

.flash-success {
    background-color: #4caf50;
    /* Green */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 10px;
}

/* Styling for flash error message */
.toast.toast-error {
    background-color: #f44336;
    /* Red */
    color: white;
    padding: 10px 20px;
    border-radius: 5px;
    margin-bottom: 10px;
}

/* Positioning for flash error message */
.toast-top-right {
    top: 20px;
    right: 20px;
    position: fixed;
    z-index: 9999;
}

.nav-link {
    color: white;
}

.main-sidebar .sidebar-style-2,
.main-sidebar .sidebar-style-2 .sidebar-menu li a,
.main-sidebar .sidebar-style-2 .sidebar-menu li .dropdown-menu li a,
.main-sidebar .sidebar-style-2 .sidebar-brand a,
.main-sidebar .sidebar-style-2 .sidebar-brand a .logo-name {
    color: white !important;
    font-size: 50px;
}

.main-sidebar .sidebar-style-2 .sidebar-menu li a i {
    color: white !important;
    font-size: 50px;
}

.main-sidebar .sidebar-style-2 .logo-name {
    color: white !important;
    font-size: 50px;
}
</style>

<body>
    <div id="flash-success-container">
        <?php if (session()->has('success')) : ?>
        <div class="flash-success">
            <?= session('success') ?>
        </div>
        <?php endif; ?>
    </div>
    <?php if (session()->has('error')): ?>

    <div id="toast-container" class="toast-top-right">
        <div class="toast toast-error" aria-live="assertive" style="">
            <div class="toast-message">
                <?= session('error') ?>
            </div>
        </div>
    </div>
    <?php endif ?>
    <div class="loader"></div>
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar sticky"
                style="background: linear-gradient(to right, #e2fafb, #48cef6);">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
            
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
           
                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user"> <img alt="image"
                                src="<?=base_url(); ?>public/assets/img/user.png" class="user-img-radious-style"> <span
                                class="d-sm-none d-lg-inline-block"></span></a>
                        <div class="dropdown-menu dropdown-menu-right pullDown">

                            <div class="dropdown-divider"></div>
                            <a href="<?=base_url(); ?>logout" class="dropdown-item has-icon text-danger"> <i
                                    class="fas fa-sign-out-alt"></i>
                                Logout
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2" style="background: linear-gradient(to left, #e2fafb, #48cef6);">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="<?php base_url() ?>product"> <img alt="image" src="<?=base_url(); ?>public/assets/img/logo.png"
                                class="header-logo" /> <span class="logo-name">Delivery App</span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Main</li>

                        <li class="dropdown">
                            <a href="<?=base_url(); ?>profile" class="nav-link"><i
                                    data-feather="monitor"></i>Profile</a>
                        </li>
                        <!-- <li class="dropdown">
                            <a href="<?=base_url(); ?>order" class="nav-link"><i
                                    data-feather="shopping-bag"></i>Order</a>
                        </li> -->
                        <!-- <li class="dropdown">
                            <a href="<?=base_url(); ?>Subscriptions" class="nav-link"><i
                                    data-feather="command"></i>Subscriptions</a>
                        </li> -->
                        <li class="dropdown">
                            <a href="<?=base_url(); ?>ordehistory" class="nav-link"><i
                                    data-feather="briefcase"></i>Order History</a>
                        </li>
                        <li class="dropdown">
                            <a href="<?=base_url(); ?>product" class="nav-link"><i
                                    data-feather="briefcase"></i>Product</a>
                        </li>

                        <!-- <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown"><i
                                    data-feather="mail"></i><span>Order</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?=base_url(); ?>order">Order</a></li>
                                <li><a class="nav-link" href="<?=base_url(); ?>Subscriptions">Subscriptions</a></li>
                                <li><a class="nav-link" href="<?=base_url(); ?>ordehistory">Order History</a></li>
                            </ul>
                        </li> -->
                    </ul>
                </aside>
            </div>
           