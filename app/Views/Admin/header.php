<!DOCTYPE html>
<html lang="en">


<!-- index.html  21 Nov 2019 03:44:50 GMT -->

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/app.min.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/style.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/components.css">
    <link rel="stylesheet" href="<?=base_url(); ?>public/assets/css/custom.css">
    <link rel='shortcut icon' type='image/x-icon' href='public/assets/img/favicon.ico' />
    <link rel="stylesheet" href="public/assets/bundles/datatables/datatables.min.css">
    <link rel="stylesheet" href="public/assets/bundles/datatables/DataTables-1.10.16/css/dataTables.bootstrap4.min.css">

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
</style>

<body>

    <?php 
$uri = new \CodeIgniter\HTTP\URI(current_url(true));
$pages = $uri->getSegments();
$page = $uri->getSegment(count($pages));
 
// echo "<pre>"; print_r($page);exit();

?>
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
            <nav class="navbar navbar-expand-lg main-navbar sticky">
                <div class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg
									collapse-btn"> <i data-feather="align-justify"></i></a></li>
                        <li><a href="#" class="nav-link nav-link-lg fullscreen-btn">
                                <i data-feather="maximize"></i>
                            </a></li>
                        <li>
                            <form class="form-inline mr-auto">
                                <div class="search-element">
                                    <input class="form-control" type="search" placeholder="Search" aria-label="Search"
                                        data-width="200">
                                    <button class="btn" type="submit">
                                        <i class="fas fa-search"></i>
                                    </button>
                                </div>
                            </form>
                        </li>
                    </ul>
                </div>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link nav-link-lg message-toggle"><i data-feather="mail"></i>
                            <span class="badge headerBadge1">
                                6 </span> </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Messages
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-message">
                                <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar
											text-white"> <img alt="image" src="<?=base_url(); ?>public/assets/img/users/user-1.png"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">John
                                            Deo</span>
                                        <span class="time messege-text">Please check your mail !!</span>
                                        <span class="time">2 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="<?=base_url(); ?>public/assets/img/users/user-2.png"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                            Smith</span> <span class="time messege-text">Request for leave
                                            application</span>
                                        <span class="time">5 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="<?=base_url(); ?>public/assets/img/users/user-5.png"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jacob
                                            Ryan</span> <span class="time messege-text">Your payment invoice is
                                            generated.</span> <span class="time">12 Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="<?=base_url(); ?>public/assets/img/users/user-4.png"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Lina
                                            Smith</span> <span class="time messege-text">hii John, I have upload
                                            doc
                                            related to task.</span> <span class="time">30
                                            Min Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="<?=base_url(); ?>public/assets/img/users/user-3.png"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Jalpa
                                            Joshi</span> <span class="time messege-text">Please do as specify.
                                            Let me
                                            know if you have any query.</span> <span class="time">1
                                            Days Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span class="dropdown-item-avatar text-white">
                                        <img alt="image" src="<?=base_url(); ?>public/assets/img/users/user-2.png"
                                            class="rounded-circle">
                                    </span> <span class="dropdown-item-desc"> <span class="message-user">Sarah
                                            Smith</span> <span class="time messege-text">Client Requirements</span>
                                        <span class="time">2 Days Ago</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
                    <li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown"
                            class="nav-link notification-toggle nav-link-lg"><i data-feather="bell" class="bell"></i>
                        </a>
                        <div class="dropdown-menu dropdown-list dropdown-menu-right pullDown">
                            <div class="dropdown-header">
                                Notifications
                                <div class="float-right">
                                    <a href="#">Mark All As Read</a>
                                </div>
                            </div>
                            <div class="dropdown-list-content dropdown-list-icons">
                                <a href="#" class="dropdown-item dropdown-item-unread"> <span
                                        class="dropdown-item-icon bg-primary text-white"> <i class="fas
												fa-code"></i>
                                    </span> <span class="dropdown-item-desc"> Template update is
                                        available now! <span class="time">2 Min
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i class="far
												fa-user"></i>
                                    </span> <span class="dropdown-item-desc"> <b>You</b> and <b>Dedik
                                            Sugiharto</b> are now friends <span class="time">10 Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-success text-white"> <i class="fas
												fa-check"></i>
                                    </span> <span class="dropdown-item-desc"> <b>Kusnaedi</b> has
                                        moved task <b>Fix bug header</b> to <b>Done</b> <span class="time">12
                                            Hours
                                            Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-danger text-white"> <i
                                            class="fas fa-exclamation-triangle"></i>
                                    </span> <span class="dropdown-item-desc"> Low disk space. Let's
                                        clean it! <span class="time">17 Hours Ago</span>
                                    </span>
                                </a> <a href="#" class="dropdown-item"> <span
                                        class="dropdown-item-icon bg-info text-white"> <i class="fas
												fa-bell"></i>
                                    </span> <span class="dropdown-item-desc"> Welcome to Otika
                                        template! <span class="time">Yesterday</span>
                                    </span>
                                </a>
                            </div>
                            <div class="dropdown-footer text-center">
                                <a href="#">View All <i class="fas fa-chevron-right"></i></a>
                            </div>
                        </div>
                    </li>
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
            <div class="main-sidebar sidebar-style-2">

                <?php 
      // echo "<pre>";print_r($_SESSION['accesslevel']);exit();
      if ((!empty($_SESSION))) {
            
            ?>
                <?php 
                
                            if (($_SESSION['role']) == 'Admin') { ?>
                <?php
                    if (isset($_SESSION['accesslevel'])) {
                        $access_levels = explode(',', $_SESSION['accesslevel']);
                    ?>
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="<?php echo base_url()?>AdminDashboard"> <img alt="image" src="<?=base_url(); ?>public/assets/img/logo.png"
                                class="header-logo" /> <span class="logo-name">Admin</span>
                        </a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">Admin Dashboard</li>

                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown" <?php if (in_array('adduser', $access_levels) || in_array('addmenu', $access_levels) || in_array('allotdelivery', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>><i data-feather="mail"></i><span>User</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?php base_url()?>adduser" <?php if (in_array('adduser', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Add User</a></li>
                                                             <li><a class="nav-link" href="<?php base_url()?>userlist" <?php if (in_array('userlist', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>User List</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>addmenu" <?php if (in_array('addmenu', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Access level</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>allotdelivery" <?php if (in_array('allotdelivery', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Allot Delivery</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown" <?php if (in_array('addproduct', $access_levels) || in_array('productlist', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>><i data-feather="mail"></i><span>Product</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?php base_url()?>addproduct" <?php if (in_array('addproduct', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Add Product</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>productlist" <?php if (in_array('productlist', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Product List</a></li>
                            </ul>
                        </li>

                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown" <?php if (in_array('addCoustmer', $access_levels) || in_array('Feedback', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>><i data-feather="mail"></i><span>Coustmer</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?php base_url()?>addCoustmer" <?php if (in_array('addCoustmer', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Add Coustmer</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>Feedback" <?php if (in_array('Feedback', $access_levels)) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Feedback</a></li>
                            </ul>
                        </li>
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown" <?php if (in_array('Receivedorder', $access_levels) || in_array('orderpayment', $access_levels) || in_array('yourorder', $access_levels)  ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>><i data-feather="mail"></i><span>Order
                                    Status</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?php base_url()?>Receivedorder" <?php if (in_array('Receivedorder', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Received Order</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>yourorder" <?php if (in_array('yourorder', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Your Orders</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>orderpayment" <?php if (in_array('orderpayment', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Payment Status</a></li>
                            </ul>
                        </li>
                        <!-- <li class="dropdown">
              <a href="<?php base_url()?>" class="nav-link"><i data-feather="monitor"></i>Staff</a>
            </li> -->
                        <li class="dropdown">
                            <a href="#" class="menu-toggle nav-link has-dropdown" <?php if (in_array('coustmerlisting', $access_levels) || in_array('Orderlist', $access_levels) || in_array('Staffdelivery', $access_levels)  ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>><i data-feather="mail"></i><span>Reports</span></a>
                            <ul class="dropdown-menu">
                                <li><a class="nav-link" href="<?php base_url()?>coustmerlisting" <?php if (in_array('coustmerlisting', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Coustmer List</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>Orderlist" <?php if (in_array('Orderlist', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Order List</a></li>
                                <li><a class="nav-link" href="<?php base_url()?>Staffdelivery" <?php if (in_array('Staffdelivery', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Delivery Staff</a></li>
                                                             <li><a class="nav-link" href="<?php base_url()?>deliveredorder" <?php if (in_array('deliveredorder', $access_levels) ) {
                                                                echo "style='display:block'";
                                                            } else {
                                                                echo "style='display:none'";
                                                            } ?>>Delivered order</a></li>
                            </ul>
                        </li>
                    </ul>
                </aside>

                <?php } ?>
                <?php } ?>
                <?php } ?>

            </div>