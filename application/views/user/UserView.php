<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-10 col-lg-10 col-xs-offset-0 col-sm-offset-0 col-md-offset-1 col-lg-offset-1">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" id="userName"></h3>
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
<!--                                <dt>User level:</dt>
                                <dd id="userLevel"></dd>
                                <dt>Registered since:</dt>
                                <dd id='joinedDate'></dd>
                                <dt>Questions Asked</dt>
                                <dd id="questAsked"></dd>
                                <dt>Total Points</dt>
                                <dd id="points"></dd>-->
                            </dl>
                        </div>
                        <div class=" col-md-9 col-lg-9 hidden-xs hidden-sm">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>User level:</td>
                                        <td id="userLevel"></td>
                                    </tr>
                                    <tr>
                                        <td>Registered since:</td>
                                        <td id='joinedDate'></td>
                                    </tr>
                                    <tr>
                                        <td>Questions Asked</td>
                                        <td id="questAsked"></td>
                                    </tr>
                                    <tr>
                                        <td>Loyality Points</td>
                                        <td id="lPoints"></td>
                                    </tr>
                                    <tr>
                                        <td>Reputation Points</td>
                                        <td id="rPoints"></td>
                                    </tr>
                                    <tr>
                                        <td>Total Points</td>
                                        <td id="tPoints"></td>
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
        <br>
        <div class="tab-pane active" id="questions"></div>
        <div class="tab-pane" id="answers"></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.get("/MobileHub/index.php/api/user/details/" + "<?php echo $user ?>", function(resultsData) {
            resultsData = jQuery.parseJSON(resultsData);
            setupProfileDetails(resultsData.user, resultsData.questions.length);
            loadUI(resultsData);
            return true;
        });
    });

    function setupProfileDetails(user, questAsked) {
        $("#userName").text(user.fullName);
        $("#joinedDate").text(user.joinedDate);
        $("#questAsked").text(questAsked);
        $("#lPoints").text(user.loyality);
        $("#rPoints").text((user.reputation === null) ? "0" : user.reputation);
        $("#tPoints").text(parseInt($("#lPoints").text()) + parseInt($("#rPoints").text()));
    }

    function loadUI(resultsData) {
        console.log(resultsData);
        if (resultsData.results === "No results found") {
            $("#questions").html("<p>User has not asked any questions yet!</p>");
        } else {
            //$("ul.list-group").html("<h5><b>" + resultsData.results.length + "</b> result(s) found</h5>");
            for (var i = 0; i < resultsData.questions.length; i++) {
                var result = resultsData.questions[i];
                dateAsked = result.askedOn.split(' ');
                var listItem = "<li class='list-group-item' style='margin-bottom: 5px;'>"
                        + "<div class='row' style='margin-right: -40px;'><div class='col-xs-2 col-md-1'>"
                        + "<img src='/MobileHub/resources/img/default.png' class='img-circle img-responsive' alt='' /></div>"
                        + "<div class='col-xs-10 col-md-9'><div>"
                        + "<a href='/MobileHub/index.php/question/show/?id=" + result.questionId + "'>" + result.questionTitle + "</a>"
                        + "<div class='mic-info'> Asked by <a href='#'>" + result.askerName + "</a> on " + dateAsked[0] + "</div></div>"
//                        + "<div class='comment-text'><br>"
//                        + refineDescription(result.questionDescription) + "</div>"
                        + "<div class='action'>"
                        + getTagsString(result.tags)
                        + "</div></div>" //tags
                        + "<div class='col-md-2'><div class='vote-box' title='Votes'><span class='vote-count'>"
                        + result.votes + "</span><span class='vote-label'>votes</span></div>"
                        + "<div class='ans-count-box' title='Answers'><span class='ans-count'>"
                        + result.answerCount + "</span>"
                        + "<span class='ans-label'>answers</span></div></div></div></li>";
                $("#questions")
                        .append(listItem);
            }
        }
    }

    function refineDescription(desc) {
        if (desc.length > 150) {
            desc = desc.substring(0, 150) + " ...";
        }
        return desc;
    }

    function getTagsString($tags)
    {
        var str = "";
        for (var i = 0; i < $tags.length; i++) {
            str += "<button type='button' class='btn btn-info btn-xs' title='Approved' text='Category'>" + $tags[i] + "</button>&nbsp";
        }
        return str;
    }
</script>