<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>MobileHub Admin Dashboard</title>

        <!-- Bootstrap core CSS -->

        <!-- Add custom CSS here -->
        <link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/sb-admin.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo site_url('../resources/font-awesome/css/font-awesome.min.css') ?>">
        <!-- Page Specific CSS -->
        <link href="<?php echo site_url('../resources/css/morris-0.4.3.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/jquery.dataTables.css') ?>" rel="stylesheet">
        <script src="<?php echo site_url('../resources/js/jquery-1.9.min.js') ?>"></script>
    </head>

    <body>

        <div id="wrapper">
            <!-- Sidebar -->
            <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
                <!-- Brand and toggle get grouped for better mobile display -->
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('admin/?user=' . $name); ?>">MobileHub Admin</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="<?php echo $activeLink['index'] ?>"><a href="<?php echo site_url('admin/?user=' . $name); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li class="<?php echo $activeLink['questions'] ?>"><a href="<?php echo site_url('admin/questions/?user=' . $name); ?>"><i class="fa fa-bar-chart-o"></i> Questions</a></li>
                        <li class="<?php echo $activeLink['answers'] ?>"><a href="<?php echo site_url('admin/answers/?user=' . $name); ?>"><i class="fa fa-table"></i> Answers</a></li>
                        <li class="<?php echo $activeLink['users'] ?>"><a href="<?php echo site_url('admin/users/?user=' . $name); ?>"><i class="fa fa-users"></i> Users</a></li>
                        <li class="<?php echo $activeLink['requests'] ?>"><a href="<?php echo site_url('admin/requests/?user=' . $name); ?>"><i class="fa fa-flag"></i> Requests</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right navbar-user">
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $name ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<? echo site_url('profile/?user=' . $name); ?>"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                                <li><a href="/MobileHub/"><i class="fa fa-sitemap"></i> Visit Site</a></li>
                                <li class="divider"></li>
                                <li><a href="<? echo site_url('auth/logout'); ?>"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>