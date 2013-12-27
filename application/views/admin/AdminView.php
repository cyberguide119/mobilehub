<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">

        <title>Dashboard - SB Admin</title>

        <!-- Bootstrap core CSS -->

        <!-- Add custom CSS here -->
        <link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/sb-admin.css') ?>" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo site_url('../resources/font-awesome/css/font-awesome.min.css') ?>">
        <!-- Page Specific CSS -->
        <link rel="stylesheet" href="http://cdn.oesmith.co.uk/morris-0.4.3.min.css">
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
                    <a class="navbar-brand" href="index.html">MobileHub Admin</a>
                </div>

                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse navbar-ex1-collapse">
                    <ul class="nav navbar-nav side-nav">
                        <li class="active"><a href="index.html"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                        <li><a href="charts.html"><i class="fa fa-bar-chart-o"></i> Charts</a></li>
                        <li><a href="tables.html"><i class="fa fa-table"></i> Tables</a></li>
                        <li><a href="forms.html"><i class="fa fa-edit"></i> Forms</a></li>
                        <li><a href="typography.html"><i class="fa fa-font"></i> Typography</a></li>
                        <li><a href="bootstrap-elements.html"><i class="fa fa-desktop"></i> Bootstrap Elements</a></li>
                        <li><a href="bootstrap-grid.html"><i class="fa fa-wrench"></i> Bootstrap Grid</a></li>
                        <li><a href="blank-page.html"><i class="fa fa-file"></i> Blank Page</a></li>
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
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-user"></i> <?php echo $name?> <b class="caret"></b></a>
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

            <div id="page-wrapper">

                <div class="row">
                    <div class="col-lg-12">
                        <h1>Dashboard <small>Statistics Overview</small></h1>
                        <ol class="breadcrumb">
                            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
                        </ol>
                    </div>
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-lg-3">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-comments fa-5x"></i>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <p class="announcement-heading" id="totalQuestions">456</p>
                                        <p class="announcement-text">Total Questions</p>
                                    </div>
                                </div>
                            </div>
<!--                            <a href="<? echo site_url('homepage'); ?>">
                                <div class="panel-footer announcement-bottom">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            View Questions
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>-->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-check fa-5x green"></i>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <p class="announcement-heading">12</p>
                                        <p class="announcement-text">Total Answers</p>
                                    </div>
                                </div>
                            </div>
<!--                            <a href="#">
                                <div class="panel-footer announcement-bottom">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            Complete Tasks
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>-->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-users fa-5x"></i>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <p class="announcement-heading">18</p>
                                        <p class="announcement-text">Total Members</p>
                                    </div>
                                </div>
                            </div>
<!--                            <a href="#">
                                <div class="panel-footer announcement-bottom">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            Fix Issues
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>-->
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <div class="panel">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-xs-6">
                                        <i class="fa fa-tasks fa-5x"></i>
                                    </div>
                                    <div class="col-xs-6 text-right">
                                        <p class="announcement-heading">56</p>
                                        <p class="announcement-text">  Total<br> Logins</p>
                                    </div>
                                </div>
                            </div>
<!--                            <a href="#">
                                <div class="panel-footer announcement-bottom">
                                    <div class="row">
                                        <div class="col-xs-6">
                                            Complete Orders
                                        </div>
                                        <div class="col-xs-6 text-right">
                                            <i class="fa fa-arrow-circle-right"></i>
                                        </div>
                                    </div>
                                </div>
                            </a>-->
                        </div>
                    </div>
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-bar-chart-o"></i> Daily user logins</h3>
                            </div>
                            <div class="panel-body">
                                <div id="myfirstchart" style="height: 250px;"></div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->

                <div class="row">
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Daily registrations</h3>
                            </div>
                            <div class="panel-body">
                                <div id="myfirstchart1" style="height: 250px;"></div>
                                <div class="text-right">
                                    <a href="#">View Details <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-clock-o"></i> Recent Activity</h3>
                            </div>
                            <div class="panel-body">
                                <div class="list-group">
                                    <a href="#" class="list-group-item">
                                        <span class="badge">just now</span>
                                        <i class="fa fa-calendar"></i> Calendar updated
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">4 minutes ago</span>
                                        <i class="fa fa-comment"></i> Commented on a post
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">23 minutes ago</span>
                                        <i class="fa fa-truck"></i> Order 392 shipped
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">46 minutes ago</span>
                                        <i class="fa fa-money"></i> Invoice 653 has been paid
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">1 hour ago</span>
                                        <i class="fa fa-user"></i> A new user has been added
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">2 hours ago</span>
                                        <i class="fa fa-check"></i> Completed task: "pick up dry cleaning"
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">yesterday</span>
                                        <i class="fa fa-globe"></i> Saved the world
                                    </a>
                                    <a href="#" class="list-group-item">
                                        <span class="badge">two days ago</span>
                                        <i class="fa fa-check"></i> Completed task: "fix error on sales page"
                                    </a>
                                </div>
                                <div class="text-right">
                                    <a href="#">View All Activity <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="panel panel-primary">
                            <div class="panel-heading">
                                <h3 class="panel-title"><i class="fa fa-money"></i> Recent Transactions</h3>
                            </div>
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped tablesorter">
                                        <thead>
                                            <tr>
                                                <th>Order # <i class="fa fa-sort"></i></th>
                                                <th>Order Date <i class="fa fa-sort"></i></th>
                                                <th>Order Time <i class="fa fa-sort"></i></th>
                                                <th>Amount (USD) <i class="fa fa-sort"></i></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>3326</td>
                                                <td>10/21/2013</td>
                                                <td>3:29 PM</td>
                                                <td>$321.33</td>
                                            </tr>
                                            <tr>
                                                <td>3325</td>
                                                <td>10/21/2013</td>
                                                <td>3:20 PM</td>
                                                <td>$234.34</td>
                                            </tr>
                                            <tr>
                                                <td>3324</td>
                                                <td>10/21/2013</td>
                                                <td>3:03 PM</td>
                                                <td>$724.17</td>
                                            </tr>
                                            <tr>
                                                <td>3323</td>
                                                <td>10/21/2013</td>
                                                <td>3:00 PM</td>
                                                <td>$23.71</td>
                                            </tr>
                                            <tr>
                                                <td>3322</td>
                                                <td>10/21/2013</td>
                                                <td>2:49 PM</td>
                                                <td>$8345.23</td>
                                            </tr>
                                            <tr>
                                                <td>3321</td>
                                                <td>10/21/2013</td>
                                                <td>2:23 PM</td>
                                                <td>$245.12</td>
                                            </tr>
                                            <tr>
                                                <td>3320</td>
                                                <td>10/21/2013</td>
                                                <td>2:15 PM</td>
                                                <td>$5663.54</td>
                                            </tr>
                                            <tr>
                                                <td>3319</td>
                                                <td>10/21/2013</td>
                                                <td>2:13 PM</td>
                                                <td>$943.45</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-right">
                                    <a href="#">View All Transactions <i class="fa fa-arrow-circle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /.row -->

            </div><!-- /#page-wrapper -->

        </div><!-- /#wrapper -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
        <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
        <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
        <script src="<?php echo site_url('../resources/js/bootstrap.min.js') ?>"></script>
        
        <script>
            new Morris.Area({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [
                    {year: '2008', value: 20},
                    {year: '2009', value: 10},
                    {year: '2010', value: 5},
                    {year: '2011', value: 5},
                    {year: '2012', value: 20}
                ],
                // The name of the data record attribute that contains x-values.
                xkey: 'year',
                // A list of names of data record attributes that contain y-values.
                ykeys: ['value'],
                // Labels for the ykeys -- will be displayed when you hover over the
                // chart.
                labels: ['Value']
            });

            new Morris.Donut({
                // ID of the element in which to draw the chart.
                element: 'myfirstchart1',
                // Chart data records -- each entry in this array corresponds to a point on
                // the chart.
                data: [
                    {label: "Download Sales", value: 12},
                    {label: "In-Store Sales", value: 30},
                    {label: "Mail-Order Sales", value: 20}]
            });
        </script>

        <!--         JavaScript 
                <script src="js/jquery-1.10.2.js"></script>
                <script src="js/bootstrap.js"></script>
        
                 Page Specific Plugins 
                <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
                <script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
                <script src="js/morris/chart-data-morris.js"></script>
                <script src="js/tablesorter/jquery.tablesorter.js"></script>
                <script src="js/tablesorter/tables.js"></script>-->

    </body>
</html>
