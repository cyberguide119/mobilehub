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
                    <div id="dailyLoginsChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
    </div><!-- /.row -->

    <div class="row">
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-long-arrow-right"></i> Daily New Registrations</h3>
                </div>
                <div class="panel-body">
                    <div id="dailyRegChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-clock-o"></i> Daily New Answers</h3>
                </div>
                <div class="panel-body">
                    <div id="dailyAnsChart" style="height: 250px;"></div>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-money"></i> Daily New Questions</h3>
                </div>
                <div class="panel-body">
                    <div id="dailyQueChart" style="height: 250px;"></div>
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
            element: 'dailyLoginsChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
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

    function loadDailyRegistrations(dataArr) {
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'dailyRegChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: dataArr.data.regChart,
            // The name of the data record attribute that contains x-values.
            xkey: 'regDate',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Value'],
            xLabels: "day"
        });
    }

    function loadDailyAns(dataArr) {
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'dailyAnsChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: dataArr.data.ansChart,
            // The name of the data record attribute that contains x-values.
            xkey: 'ansDate',
            // A list of names of data record attributes that contain y-values.
            ykeys: ['value'],
            // Labels for the ykeys -- will be displayed when you hover over the
            // chart.
            labels: ['Value'],
            xLabels: "day"
        });
    }

    function loadDailyQue(dataArr) {
        new Morris.Line({
            // ID of the element in which to draw the chart.
            element: 'dailyQueChart',
            // Chart data records -- each entry in this array corresponds to a point on
            // the chart.
            data: dataArr.data.queChart,
            // The name of the data record attribute that contains x-values.
            xkey: 'queDate',
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
            loadDailyRegistrations(content);
            loadDailyAns(content);
            loadDailyQue(content);
        } else if (content.message === "Error") {
            $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
            $('#errorModal').modal('show');
        }
    }
</script>
