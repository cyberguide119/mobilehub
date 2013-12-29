<script src="<?php echo site_url('../resources/js/moment.min.js') ?>"></script>
<div class="container">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="panel-title" id="userName"></h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-2 col-lg-2 hidden-xs hidden-sm">
                            <img class="img-circle"
                                 src="/Mobilehub/resources/img/default.png"
                                 alt="User Pic">
                        </div>
                        <div class="col-xs-1 col-sm-1 hidden-md hidden-lg">
                            <img class="img-circle"
                                 src="/Mobilehub/resources/img/default.png"
                                 alt="User Pic">
                        </div>
                        <div class=" col-md-6 col-lg-6">
                            <table class="table table-user-information">
                                <tbody>
                                    <tr>
                                        <td>User level</td>
                                        <td id="userLevel"></td>
                                    </tr>
                                    <tr>
                                        <td>Registered since</td>
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
                        <div class=" col-md-4 col-lg-4">
                            <center>
                                <p>About Me</p>
                                <textarea id="aboutMe" rows="9" cols="30" readonly></textarea>
                            </center>
                        </div>
                    </div>
                </div>
                <?php
                if ($isOwner) {
                    echo "<div class='panel-footer'>
                    <div class='span2'>
                        <div class='btn-group'>
                            <a class='btn dropdown-toggle btn-info' data-toggle='dropdown' href='#'>
                                Action 
                                <span class='icon-cog icon-white'></span><span class='caret'></span>
                            </a>
                            <ul class='dropdown-menu'>
                                <li><a href='/MobileHub/index.php/profile/edit/?user=" . $user . "'><span class='glyphicon glyphicon-wrench'></span> Modify</a></li>
                                <li><a href='/MobileHub/index.php/profile/delete/?user=" . $user . "'><span class='glyphicon glyphicon-trash'></span> Delete</a></li>
                            </ul>
                        </div>
                    </div>
                </div>";
                }
                ?>

            </div>
        </div>
    </div>
    <h4>Summary</h4>
    <ul class="nav nav-tabs">
        <li class="active"><a href="#questions" data-toggle="tab">Questions</a></li>
        <li><a href="#answers" data-toggle="tab">Answers</a></li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content">
        <br>
        <div class="tab-pane active" id="questions"><p>This user has not asked any questions yet!</p></div>
        <div class="tab-pane" id="answers"><ul class="chat" id="answersList"></ul></div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $.get("/MobileHub/index.php/api/user/details/" + "<?php echo $user ?>", function(resultsData) {
            resultsData = jQuery.parseJSON(resultsData);
            if (resultsData.message === "Error") {
                window.location = "/MobileHub/index.php/custom404/";
                return false;
            } else {
                setupProfileDetails(resultsData.user, resultsData.questions.length);
                loadUI(resultsData);
                loadAnswersUI(resultsData.answers);
                return true;
            }
        });
    });

    function setupProfileDetails(user, questAsked) {
        $("#userName").text(user.fullName);
        $("#userLevel").text(user.userRole);
        $("#joinedDate").text(user.joinedDate);
        $("#questAsked").text(questAsked);
        $("#lPoints").text((user.loyality === null) ? "0" : user.loyality);
        $("#rPoints").text((user.reputation === null) ? "0" : user.reputation);
        $("#tPoints").text(parseInt($("#lPoints").text()) + parseInt($("#rPoints").text()));
        $("#aboutMe").text(user.about);
    }

    function loadUI(resultsData) {
        if (resultsData.questions.length < 1) {
            $("#questions").html("<h4>This user has not asked any questions yet!</h4>");
        } else {
            $("#questions").html(" ");
            for (var i = 0; i < resultsData.questions.length; i++) {
                var result = resultsData.questions[i];
                dateAsked = result.askedOn.split(' ');
                var listItem = "<li class='list-group-item' style='margin-bottom: 5px; border: none; border-bottom: 1px solid #ddd;'>"
                        + "<div class='row' style='margin-right: -40px;'><div class='col-xs-2 col-md-1'>"
                        + "<img src='/MobileHub/resources/img/default.png' class='img-circle img-responsive' alt='' /></div>"
                        + "<div class='col-xs-10 col-md-9'><div>"
                        + "<a href='/MobileHub/index.php/questions/show/?id=" + result.questionId + "'>" + result.questionTitle + "</a>"
                        + "<div class='mic-info'> Asked by <a href='#'>" + result.askerName + "</a> on " + dateAsked[0] + "</div></div>"
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

    function loadAnswersUI(answers) {

        if (answers === null || answers.length === 0) {
            $("#answers").html("<h4>No answers for this question yet!</h4>");
        } else {
            $("#answersList").html(" ");
            for (var i = 0; i < answers.length; i++) {
                var result = answers[i];
                var answersList = "<li class='left clearfix'><span class='chat-img pull-left'><div class=''><div class='vote-box' title='Votes'>"
                        + "<span class='vote-count' id='ans" + result.answerId + "'>" + result.netVotes + "</span><span class='vote-label'>votes</span></div>"
                        + "</div></span>"
                        + "<div class='chat-body clearfix'><div class='header'>"
                        + "<small class='pull-right text-muted'>"
                        + "<span class='glyphicon glyphicon-time'></span>" + moment(result.answeredOn, "YYYY-MM-DD").fromNow() + "</small></div>"
                        + "<a href=/MobileHub/index.php/questions/show/?id=" + result.questionId + "><p>" + result.description + "</p></a></div></li></ul>";
                $("#answersList")
                        .append(answersList);
            }

        }
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