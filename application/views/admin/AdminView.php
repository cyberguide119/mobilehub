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
                            <p class="announcement-heading" id="totalQuestions"></p>
                            <p class="announcement-text">Total Questions</p>
                        </div>
                    </div>
                </div>
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
                            <p class="announcement-heading" id="totalAnswers"></p>
                            <p class="announcement-text">Total Answers</p>
                        </div>
                    </div>
                </div>
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
                            <p class="announcement-heading" id="totalMembers"></p>
                            <p class="announcement-text">Total Members</p>
                        </div>
                    </div>
                </div>
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
                            <p class="announcement-heading" id="totalLogins"></p>
                            <p class="announcement-text">  Total<br> Logins</p>
                        </div>
                    </div>
                </div>
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
<!-- Modal -->
<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Error</h4>
            </div>
            <div class="modal-body" id="errModalBody">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
</div>
</div><!-- /#wrapper -->

<script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
<script src="http://cdn.oesmith.co.uk/morris-0.4.3.min.js"></script>
<script>

    $(document).ready(function() {
        jsonObj = {"username": "<?php echo $name; ?>"};
        $.post("/MobileHub/index.php/api/admin/details/basic", jsonObj, function(resultsData) {
            resultsData = jQuery.parseJSON(resultsData);
            loadUI(resultsData);
            return true;
        }).fail(function() {
            $('#errModalBody').html("<p><center>Oops! something went wrong! Please try again</center></p>");
            $('#errorModal').modal('show');
        }), "json";
        return true;
    });

    function loadDailyLogins(dataArr) {
        new Morris.Area({
            // ID of the element in which to draw the chart.
            element: 'myfirstchart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
//            data: [
//                {year: '2008', value: 20},
//                {year: '2009', value: 10},
//                {year: '2010', value: 5},
//                {year: '2011', value: 5},
//                {year: '2012', value: 20}
//            ],
            data: dataArr.data.loginsChart,
            // The name of the data record attribute that contains x-values.
            xkey: 'loginDate',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Value'],
            xLabels: "day"
        });
    }



    function loadUI(content) {
        if (content.message === "Success") {
            console.log();
            $('#totalQuestions').text(content.data.totalQuestions);
            $('#totalAnswers').text(content.data.totalAnswers);
            $('#totalMembers').text(content.data.totalUsers);
            $('#totalLogins').text(content.data.totalLogins);

            loadDailyLogins(content);
        } else if (content.message === "Error") {
            $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
            $('#errorModal').modal('show');
        }
    }

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
