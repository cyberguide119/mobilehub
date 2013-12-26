<script src="<?php echo site_url('../resources/js/moment.min.js') ?>"></script>
<script src="<?php echo site_url('../resources/js/syntax/jquery.syntax.min.js') ?>" type="text/javascript"></script>
<div class="container">
    <div class="row">
        <div class="col-md-1" style="margin-top: 26px;">
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
                <span class="badge badge-success" id="qAskedOn"></span>
                <div class="pull-right">
                    <div class="action" id="qTags"></div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" style=" -webkit-box-shadow: none; box-shadow: none; border:0;">
                <div class="panel-heading" style="color: black; background: none">
                    <span class="glyphicon glyphicon-comment"></span> Your previous answer
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
                            //window.location = "/MobileHub/index.php/custom404/";
                            return false;
                        } else {
                            $("#qVotes")
                                    .html(resultsData.questionDetails.votes);
                            $("#qTitle").html("<h2>" + resultsData.questionDetails.questionTitle + "</h2>");
                            $("#qDesc").html("<p>" + resultsData.questionDetails.questionDescription + "</p>");
                            $("#qAskedOn").html("Posted On " + resultsData.questionDetails.askedOn);

                            $("#qTags").html(getTagsString(resultsData.questionDetails.tags));

                            if (resultsData.questionDetails.answers === null || resultsData.questionDetails.answers.length === 0) {
                                $("#answersList").html("<h4>No answers for this question yet!</h4>");
                            } else {
                                for (var i = 0; i < resultsData.questionDetails.answers.length; i++) {
                                    var result = resultsData.questionDetails.answers[i];
                                    if (result.answerId === "<?php echo $answerId ?>") {
                                        var answersList = "<li class='left clearfix' style='background: gold;padding: 5px;'><span class='chat-img pull-left'><div class=''><div class='vote-box' title='Votes'>"
                                                + "<span class='vote-count' id='ans" + result.answerId + "'>" + result.votes + "</span><span class='vote-label'>votes</span></div>"
                                                + "<div class='action'></div></div></span>"
                                                + "<div class='chat-body clearfix'><div class='header'>"
                                                + "<strong class='primary-font'><a href='/MobileHub/index.php/profile/?user=" + result.answerdUsername + "'>" + result.answerdUsername + "</a></strong><small class='pull-right text-muted'>"
                                                + "<span class='glyphicon glyphicon-time'></span>" + moment(result.answeredOn, "YYYY-MM-DD hh:mm Z").fromNow() + "</small></div>"
                                                + "<p>" + result.description + "</p></div></li></ul>";
                                        $("#answersList")
                                                .append(answersList);
                                        $("#ansDesc").val(result.description);
                                        break;
                                    }
                                }
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

                    function voteQuestion(isUpVote) {
                        var $jsonObj = {'questionId': "<?php echo $questionId; ?>", 'username': "<?php echo $name; ?>"};

                        if (isUpVote) {
                            $url = "/MobileHub/index.php/api/vote/voteup/question";
                        } else {
                            $url = "/MobileHub/index.php/api/vote/votedown/question";
                        }

                        $.post($url, $jsonObj, function(content) {

                            // Deserialise the JSON
                            content = jQuery.parseJSON(content);
                            console.log(content);
                            if (content.message === "Success") {
                                $('#qVotes').html(content.votes);
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