<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title">Sahan Serasinghe</h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3 col-lg-3 hidden-xs hidden-sm">
                            <img class="img-circle"
                                 src="/Mobilehub/resources/img/default.png"
                                 alt="User Pic">
                        </div>
                        <div class="col-xs-2 col-sm-2 hidden-md hidden-lg">
                            <img class="img-circle"
                                 src="/Mobilehub/resources/img/default.png"
                                 alt="User Pic">
                        </div>
                        <div class="col-xs-10 col-sm-10 hidden-md hidden-lg">
                            <dl>
                                <dt>User level:</dt>
                                <dd>Administrator</dd>
                                <dt>Registered since:</dt>
                                <dd>11/12/2013</dd>
                                <dt>Questions Asked</dt>
                                <dd>15</dd>
                                <dt>Total Points</dt>
                                <dd>0</dd>
                            </dl>
                        </div>
                        <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>User level:</td>
                                        <td>Administrator</td>
                                    </tr>
                                    <tr>
                                        <td>Registered since:</td>
                                        <td>11/12/2013</td>
                                    </tr>
                                    <tr>
                                        <td>Questions Asked</td>
                                        <td>15</td>
                                    </tr>
                                    <tr>
                                        <td>Total Points</td>
                                        <td>0</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel-footer">
                    <div class="span2">
                        <div class="btn-group">
                            <a class="btn dropdown-toggle btn-info" data-toggle="dropdown" href="#">
                                Action 
                                <span class="icon-cog icon-white"></span><span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li><a href="#"><span class="glyphicon glyphicon-wrench"></span> Modify</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-trash"></span> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
        <li><a href="#answers" data-toggle="tab">Answers</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <div class="tab-pane active" id="questions"></div>
        <div class="tab-pane" id="answers"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.get("/MobileHub/index.php/api/user/details/" + "<?php echo $profile?>" , function(resultsData) {
            resultsData = jQuery.parseJSON(resultsData);
            loadUI(resultsData);
            return true;
        });
    });
</script>