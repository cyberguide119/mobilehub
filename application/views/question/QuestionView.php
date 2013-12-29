<script src="<?php echo site_url('../resources/js/moment.min.js') ?>"></script>
<script src="<?php echo site_url('../resources/js/syntax/jquery.syntax.min.js') ?>" type="text/javascript"></script>
<div class="container">
    <div class="row">
        <div class="chat-img pull-left" style="margin-top: 26px;">
            <div class="vote-box" title="Votes">
                <span class="vote-count" id="qVotes">0</span>
                <span class="vote-label">votes</span>
            </div>
            <div class="action">
                <button type="button" class="btn btn-success btn-xs" title="Vote Up" onclick="voteQuestion(true);">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                </button>
                <button type="button" class="btn btn-danger btn-xs" title="Vote Down" onclick="voteQuestion(false);">
                    <span class="glyphicon glyphicon-thumbs-down"></span>
                </button>
            </div>
        </div>
        <div class="col-md-11">
            <div id="qTitle"></div>
            <div id="qDesc"></div>
            <div>
                <span class="badge badge-success" id="qAskedOn"></span>&nbsp;
                <div style="display: inline;" id="tutorControls">
                    <a href ="">Edit</a> | 
                    <a href ="">Close</a>
                </div>
                <div class="pull-right">
                    <div class="action" id="qTags"></div>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="margin-top: 10px;">
        <div class="col-md-1">

        </div>
        <div class="col-md-11">
            <div class="user_info pull-right">
                Asked By
                <div class="thumb_with_border">
                    <a href="/cood/users/52af3886a67e6/Sahan"><img src="/cood/img/answerAvatar.png" width="25" height="25" alt="Sahan picture"></a>
                    <a href="#" id="askerName"></a> 
                    <span style="font-size: 8pt;">•</span>
                    <h4 style="display: inline;" id="askerPoints"></h4>
                </div>
                <div style="float: left; line-height: .9;">
                </div>
                <div style="clear: both;"></div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" style=" -webkit-box-shadow: none; box-shadow: none; border:0;">
                <div class="panel-heading" style="color: black; background: none">
                    <span class="glyphicon glyphicon-comment"></span> Answers
                </div>
                <div class="panel-body">
                    <ul class="chat" id="answersList">
                    </ul>
                </div>
            </div>
        </div>
    </div>

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

<script type="text/javascript">

                    jQuery(function($) {
                        // This function highlights (by default) pre and code tags which are annotated correctly.
                        $.syntax();
                    });

                    $('#ansDesc').maxlength({
                        alwaysShow: true
                    });

                    $(document).ready(function() {
                        $.get("/MobileHub/index.php/api/question/details/" + "<?php echo $questionId ?>", function(resultsData) {
                            resultsData = jQuery.parseJSON(resultsData);
                            loadUI(resultsData);
                            return true;
                        });
                    });

                    function loadUI(resultsData) {
                        if (resultsData.message === "Error") {
                            window.location = "/MobileHub/index.php/custom404/";
                            return false;
                        } else {
                            $("#qVotes")
                                    .html(resultsData.questionDetails.votes);
                            $("#qTitle").html("<h2>" + resultsData.questionDetails.questionTitle + "</h2>");
                            $("#qDesc").html("<p>" + resultsData.questionDetails.questionDescription + "</p>");
                            $("#qAskedOn").html("Posted " + moment(resultsData.questionDetails.askedOn, "YYYY-MM-DD hh:mm Z").fromNow());
                            $("#askerName").text(resultsData.questionDetails.asker.username);
                            $("#askerPoints").text(resultsData.questionDetails.asker.netVotes);
                            $("#askerName").attr("href", "/MobileHub/index.php/profile/?user=" + resultsData.questionDetails.asker.username);
                            $("#qTags").html(getTagsString(resultsData.questionDetails.tags));

                            if (resultsData.questionDetails.answers === null || resultsData.questionDetails.answers.length === 0) {
                                $("#answersList").html("<h4>No answers for this question yet!</h4>");
                            } else {
                                for (var i = 0; i < resultsData.questionDetails.answers.length; i++) {
                                    var result = resultsData.questionDetails.answers[i];
                                    var answersList = "<li class='left clearfix'><span class='chat-img pull-left'><div class=''><div class='vote-box' title='Votes'>"
                                            + "<span class='vote-count' id='ans" + result.answerId + "'>" + result.votes + "</span><span class='vote-label'>votes</span></div>"
                                            + "<div class='action'><button type='button' class='btn btn-success btn-xs' title='Vote up' onclick='voteAnswer(" + result.answerId + ",true);'><span class='glyphicon glyphicon-thumbs-up'></span></button>&nbsp"
                                            + "<button type='button' class='btn btn-danger btn-xs' title='Vote down' onclick='voteAnswer(" + result.answerId + ",false);'><span class='glyphicon glyphicon-thumbs-down'></span></button></div></div></span>"
                                            + "<div class='chat-body clearfix'><div class='header'>"
                                            + "<strong class='primary-font'><a href='/MobileHub/index.php/profile/?user=" + result.answerdUsername + "'>" + result.answerdUsername + "</a></strong><small class='pull-right text-muted'>"
                                            + "<span class='glyphicon glyphicon-time'></span>" + moment(result.answeredOn, "YYYY-MM-DD hh:mm Z").fromNow() + "</small></div>"
                                            + "<p>" + result.description + "</p></div></li></ul>";
                                    $("#answersList")
                                            .append(answersList);
                                }

                            }
                        }
                    }

                    function voteAnswer(answerId, isUpVote) {
                        var $jsonObj = {'answerId': answerId, 'username': "<?php echo $name; ?>"};

                        if (isUpVote) {
                            $url = "/MobileHub/index.php/api/vote/voteup/answer";
                        } else {
                            $url = "/MobileHub/index.php/api/vote/votedown/answer";
                        }

                        $.post($url, $jsonObj, function(content) {

                            // Deserialise the JSON
                            content = jQuery.parseJSON(content);
                            if (content.message === "Success") {
                                $('#ans' + answerId).html(content.votes);
                                votes = parseInt($("#askerPoints").text()) + 1;
                            } else if (content.message === "Error") {
                                $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                                $('#errorModal').modal('show');
                            }
                        }).fail(function() {
                            $('#errModalBody').html("<p><center>Oops! something went wrong! Please try again</center></p>");
                            $('#errorModal').modal('show');
                        }), "json";
                        return true;
                    }

                    function getTagsString($tags)
                    {
                        var str = "";
                        for (var i = 0; i < $tags.length; i++) {
                            str += "<button type='button' class='btn btn-info btn-xs' title='Approved' text='Category'>" + $tags[i] + "</button>&nbsp";
                        }
                        return str;
                    }

                    function voteQuestion(isUpVote) {
                        var $jsonObj = {'questionId': "<?php echo $questionId; ?>", 'username': "<?php echo $name; ?>"};
                        amount = 0;
                        if (isUpVote) {
                            $url = "/MobileHub/index.php/api/vote/voteup/question";
                            amount = 1;
                        } else {
                            $url = "/MobileHub/index.php/api/vote/votedown/question";
                            amount = -1;
                        }

                        $.post($url, $jsonObj, function(content) {

                            // Deserialise the JSON
                            content = jQuery.parseJSON(content);
                            if (content.message === "Success") {
                                $('#qVotes').html(content.votes);
                                $("#askerPoints").text(parseInt($("#askerPoints").text()) + amount);
                            } else if (content.message === "Error") {
                                $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                                $('#errorModal').modal('show');
                            }
                        }).fail(function() {
                            $('#errModalBody').html("<p><center>Oops! something went wrong! Please try again</center></p>");
                            $('#errorModal').modal('show');
                        }), "json";
                        return true;
                    }

</script>