<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>MobileHub</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/site-theme.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/bootstrap-tagsinput.css') ?>" rel="stylesheet">
        <script src="<?php echo site_url('../resources/js/jquery-1.7.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('../resources/js/bootstrap-tagsinput.min.js') ?>" type="text/javascript"></script>
        <link rel="stylesheet" href="<?php echo site_url('../resources/css/reveal.css'); ?>">
        <script src="<?php echo site_url('../resources/js/jquery.reveal.js') ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('../resources/js/bootstrap-maxlength.min.js') ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('../resources/js/form-validator/jquery.form-validator.min.js') ?>"></script>
        <script src="<?php echo site_url('../resources/js/bootstrap3-typeahead.min.js') ?>"></script>

        <script type="text/javascript">
            // using JQUERY's ready method to know when all dom elements are rendered
            $(document).ready(function() {
                $.validate({
                    modules: 'date, security',
                    onSuccess: function() {
                        return false;
                    }
                });
            });
        </script>
    </head>
    <body>        
        <nav class="navbar navbar-default" role="navigation" style="padding: 5px;">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url(); ?>">MobileHub</a>
                </div>
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo site_url(); ?>">Tutorials</a></li>
                        <li class="dropdown">
                            <a href="<?php echo site_url(); ?>" class="dropdown-toggle" data-toggle="dropdown">Categories <b class="caret"></b></a>
                            <ul class="dropdown-menu">
                                <li><a href="<?php echo site_url(); ?>">Android</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url(); ?>">iOS</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url(); ?>">Windows Phone</a></li>
                                <li class="divider"></li>
                                <li><a href="<?php echo site_url(); ?>">General</a></li>
                            </ul>
                        </li>
                        <li><a href="<?php echo site_url('homepage/about'); ?>">About Us</a></li>
                    </ul>
                    <div class="col-sm-3 col-md-3 pull-left">
                        <form action="/MobileHub/index.php/question/search" class="navbar-form" method="get" role="search" id="searchForm" name="searchForm">
                            <div class="input-group">
                                <input class="form-control" id="search-term" name="q" placeholder="Search" type="text">
                                <div class="input-group-btn">
                                    <button style="height: 43px;" class="btn btn-warning" type="submit" onclick="search();"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <ul class="nav navbar-nav navbar-right">
                        <?php
                        if ($name == NULL) {
                            echo '<li><a href="' . site_url('#') . '" data-reveal-id="myError" data-animation="fade" style="padding: 0; margin-right: 10px; margin-top: 14px"><button class="btn btn-success askBtnStyle" role="button">Ask a question</button></a></li>';
                            echo '<li><a href="#" data-reveal-id="myModal" data-animation="fade">Login</a></li>';
                        } else {
                            echo '<li><a href="' . site_url('question/ask') . '" style="padding: 0; margin-right: 10px; margin-top: 14px"><button class="btn btn-success askBtnStyle" role="button">Ask a question</button></a></li>';
                            echo '<div class="pull-right"><ul class="nav pull-right"><li class="dropdown">';
                            echo '<a href="' . site_url('') . '" class="dropdown-toggle" data-toggle="dropdown" style="margin-top: 4%; color: white;">' . $name . '<b class="caret"></b></a>';
                            echo '<ul class="dropdown-menu">';
                            if($isAdmin){
                                echo '<li><a href="' . site_url('admin/?user=' . $name) . '"><i class="glyphicon glyphicon-wrench"></i> Admin Panel</a></li>';
                            }
                            echo '<li><a href="' . site_url('profile/?user=' . $name) . '"><i class="glyphicon glyphicon-user"></i> My Profile</a></li>';
                            echo '<li><a href="' . site_url('/help/support') . '"><i class="glyphicon glyphicon-envelope"></i> Contact Support</a></li>';
                            echo '<li class="divider"></li>';
                            echo '<li><a href="' . site_url('auth/logout') . '"><i class="glyphicon glyphicon-off"></i> Logout</a></li>';
                            echo '</ul></li></ul></div>';
                        }
                        ?>
                        </li>
                    </ul>
                </div>
                <!-- /.navbar-collapse -->
            </div>
        </nav>
        <div class="container">
            <div id="myModal" class="reveal-modal">
                <?php echo $this->load->view('login/LoginView'); ?>
            </div>
            <div id="myError" class="reveal-modal" style="left: 45%">
                <?php echo $this->load->view('errors/ErrorNotLoggedIn'); ?>
            </div>
        </div>
