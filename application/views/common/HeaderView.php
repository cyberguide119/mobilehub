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
        <script src="https://code.jquery.com/jquery.js"></script>
        <script type="text/javascript" src="http://code.jquery.com/jquery-1.6.min.js"></script>
        <link rel="stylesheet" href="<?php echo site_url('../resources/css/reveal.css'); ?>">
        <script src="<?php echo site_url('../resources/js/jquery.reveal.js') ?>" type="text/javascript"></script>
        <script src="<?php echo site_url('../resources/js/form-validator/jquery.form-validator.min.js') ?>"></script>
        <script type="text/javascript">
            // using JQUERY's ready method to know when all dom elements are rendered
            $( document ).ready(function () {
                $.validate({
                    modules : 'date, security',
                    onSuccess : function() {
                       // $.post("/MobileHub/index.php/auth/authenticate", function (content) {
                              //$("#myModal").html(content);
                         //   });
                        return false;
                    }
                });
            });
        </script>
    </head>
    <body>        
        <div class="container">
            <div class="row">
               <div class="col-md-12">
                  <nav class="navbar navbar-default" style="margin-top: 5px;" role="navigation">
                     <!-- Brand and toggle get grouped for better mobile display -->
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
                           <li class="active"><a href="<?php echo site_url(); ?>">Home</a></li>
                           <li><a href="<?php echo site_url(); ?>">About Us</a></li>
                           <li class="dropdown">
                              <a href="<?php echo site_url(); ?>" class="dropdown-toggle" data-toggle="dropdown">Pages <b class="caret"></b></a>
                              <ul class="dropdown-menu">
                                 <li><a href="<?php echo site_url(); ?>">Action</a></li>
                                 <li><a href="<?php echo site_url(); ?>">Another action</a></li>
                                 <li><a href="<?php echo site_url(); ?>">Something else here</a></li>
                                 <li class="divider"></li>
                                 <li><a href="<?php echo site_url(); ?>">Separated link</a></li>
                                 <li class="divider"></li>
                                 <li><a href="<?php echo site_url(); ?>">One more separated link</a></li>
                              </ul>
                           </li>
                        </ul>
                        <form class="navbar-form navbar-left" role="search">
                           <div class="form-group">
                              <input type="text" class="form-control" placeholder="Search">
                           </div>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <?php
                                if($name == NULL){
                                    echo '<li><a href="' . site_url('auth/register') . '">Register</a></li>';
                                    echo '<li><a href="#" data-reveal-id="myModal" data-animation="fade">Login</a></li>';
                                }else{
                                    echo '<li><a href="' . site_url('') . '">' . $name . ' (100 points)</a></li>';
                                    echo '<li><a href="' . site_url('auth/logout') . '">Logout</a></li>';
                                }
                            ?>
                           </li>
                        </ul>
                     </div>
                     <!-- /.navbar-collapse -->
                  </nav>
               </div>
            </div>
            <div id="myModal" class="reveal-modal">
                <?php echo $this->load->view('login/LoginView'); ?>
            </div>
         </div>
