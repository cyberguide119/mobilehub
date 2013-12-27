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
        <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
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
                        <li class="active"><a href="<?php echo site_url('admin/?user=' . $name); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="<?php echo site_url('admin/questions/?user=' . $name); ?>"><i class="fa fa-bar-chart-o"></i> Questions</a></li>
                        <li><a href="<?php echo site_url('admin/answers/?user=' . $name); ?>"><i class="fa fa-table"></i> Answers</a></li>
                        <li><a href="<?php echo site_url('admin/users/?user=' . $name); ?>"><i class="fa fa-edit"></i> Users</a></li>
                        <li><a href="<?php echo site_url('admin/requests/?user=' . $name); ?>"><i class="fa fa-font"></i> Requests</a></li>
                    </ul>

                    <ul class="nav navbar-nav navbar-right navbar-user">
                        <li class="dropdown messages-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell"></i> Alerts <span class="badge">7</span> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li class="dropdown-header">7 New Messages</li>
                                <li class="message-preview">
                                    <a href="#">
                                        <span class="avatar"><img src="http://placehold.it/50x50"></span>
                                        <span class="name">John Smith:</span>
                                        <span class="message">Hey there, I wanted to ask you something...</span>
                                        <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li class="message-preview">
                                    <a href="#">
                                        <span class="avatar"><img src="http://placehold.it/50x50"></span>
                                        <span class="name">John Smith:</span>
                                        <span class="message">Hey there, I wanted to ask you something...</span>
                                        <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li class="message-preview">
                                    <a href="#">
                                        <span class="avatar"><img src="http://placehold.it/50x50"></span>
                                        <span class="name">John Smith:</span>
                                        <span class="message">Hey there, I wanted to ask you something...</span>
                                        <span class="time"><i class="fa fa-clock-o"></i> 4:34 PM</span>
                                    </a>
                                </li>
                                <li class="divider"></li>
                                <li><a href="#">View Inbox <span class="badge">7</span></a></li>
                            </ul>
                        </li>
                        <li class="dropdown user-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $name ?> <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<? echo site_url('profile/?user=' . $name); ?>"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>
                                <li><a href="#"><i class="fa fa-gear"></i> Settings</a></li>
                                <li class="divider"></li>
                                <li><a href="<? echo site_url('auth/logout'); ?>"><i class="glyphicon glyphicon-off"></i> Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                </div><!-- /.navbar-collapse -->
            </nav>