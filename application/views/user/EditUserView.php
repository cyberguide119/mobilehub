<script src="<?php echo site_url('../resources/js/moment.min.js') ?>"></script>
<script src="<?php echo site_url('../resources/js/bootstrap-dialog.js') ?>"></script>
<div class="container">
    <div class="well" style="background-color: white">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#profile" data-toggle="tab">Profile</a></li>
            <li><a href="#password" data-toggle="tab">Password</a></li>
            <li><a href="#questions" data-toggle="tab">Questions</a></li>
            <li><a href="#answers" data-toggle="tab">Answers</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active in" id="profile">
                <form id="tab">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Full Name</label>
                        <div class="col-sm-8">
                            <input type="text" id="fName" class="form-control" name='name' data-validation="length" data-validation-length="max50" data-validation-optional="true" placeholder="Your first name and last name (Optional)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Website</label>
                        <div class="col-sm-8">
                            <input type="text" id="website" class="form-control" name='website' data-validation="url" data-validation-optional="true" placeholder="URL of your personal blog or website (Optional)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">About</label>
                        <div class="col-sm-8">
                            <textarea type="text" id="about" class="form-control" name='name' data-validation="length" data-validation-length="max300" data-validation-optional="true" placeholder="About me"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">Email</label>
                        <div class="col-sm-8">
                            <input type="text" id="email" class="form-control" name='email' data-validation="email" placeholder="Please enter your email">
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary" onclick="postNewData();">Update</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="password">
                <form id="tab2">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Old Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="pwordold_confirmation" data-validation="length" data-validation-length="min8" placeholder="Account Password (Min. 8 characters)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">New Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="pword_confirmation" data-validation="length" data-validation-length="min8" placeholder="Account Password (Min. 8 characters)">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4">New Password (Confirm)</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="pword" data-validation="confirmation" placeholder="Please retype password">
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
            <div class="tab-pane fade" id="questions">
            </div>
            <div class="tab-pane fade" id="answers">
                <ul class="chat" id="answersList"></ul>
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
<script>
                            $(document).ready(function() {
                                $.get("/MobileHub/index.php/api/user/fulldetails/" + "<?php echo $user ?>", function(resultsData) {
                                    resultsData = jQuery.parseJSON(resultsData);
                                    if (resultsData.message === "Error") {
                                        window.location = "/MobileHub/index.php/custom403/";
                                        return false;
                                    } else {
                                        setEditableFields(resultsData);
                                        loadQuestionsUI(resultsData);
                                        loadAnswersUI(resultsData.answers);
                                        return true;
                                    }
                                });
                            });

                            function setEditableFields(resultsData) {
                                $("#fName").val(resultsData.user.fullName);
                                $("#website").val(resultsData.user.website);
                                $("#about").val(resultsData.user.about);
                                $("#email").val(resultsData.user.email);
                            }

                            function postNewData() {
                                jsonData = {'email': $("#email").val(), "fullName": $("#fName").val(), 'website': $("#website").val(), 'about': $("#about").val()};
                                //console.log(jsonData);

                                $.post("/MobileHub/index.php/api/user/post/" + "<?php echo $user ?>", jsonData, function(content) {

                                    // Deserialise the JSON
                                    content = jQuery.parseJSON(content);
                                    console.log(content);
                                    if (content.message === "Success") {
                                        $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                                        $('#errorModal').modal('show');
                                    } else {
                                        $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                                        $('#errorModal').modal('show');
                                    }
                                }).fail(function() {
                                    $('#errModalBody').html("<p><center>" + "Something went wrong when updating. Please try again later" + "</center></p>");
                                    $('#errorModal').modal('show');
                                }), "json";
                                return true;
                            }

                            function loadQuestionsUI(resultsData) {
                                if (resultsData.questions.length < 1) {
                                    $("#questions").html("<h4>This user has not asked any questions yet!</h4>");
                                } else {
                                    $("#questions").html(" ");
                                    $("#questions")
                                            .append("<br>");
                                    for (var i = 0; i < resultsData.questions.length; i++) {
                                        var result = resultsData.questions[i];
                                        dateAsked = result.askedOn.split(' ');
                                        var listItem = "<li class='list-group-item' style='margin-bottom: 5px;'>"
                                                + "<div class='row' style='margin-right: -40px;'><div class='col-xs-2 col-md-2'>"
                                                + "<div class='vote-box' title='Votes'><span class='vote-count'>"
                                                + result.votes + "</span><span class='vote-label'>votes</span></div>"
                                                + "<div class='ans-count-box' title='Answers'><span class='ans-count'>"
                                                + result.answerCount + "</span>"
                                                + "<span class='ans-label'>answers</span></div></div>"
                                                + "<div class='col-xs-10 col-md-9'><div>"
                                                + "<a href='/MobileHub/index.php/question/show/?id=" + result.questionId + "'>" + result.questionTitle + "</a>"
                                                + "<div class='mic-info'> Asked by <a href='#'>" + result.askerName + "</a> on " + dateAsked[0] + "</div></div>"
                                                + "<div class='action'>"
                                                + getTagsString(result.tags)
                                                + "</div></div>" //tags
                                                + "<div class='col-md-1'><a href='javascript:editQuestion(" + result.questionId + "," + result.votes + "," + result.answerCount + ");' class='btn btn-sm btn-primary' title='Edit Question'>"
                                                + "<i class='btn-icon-only glyphicon glyphicon-edit'></i></a><a href='javascript:deleteQuestion(" + result.questionId + ");' class='btn btn-sm btn-danger' title='Delete Question'><i class='btn-icon-only glyphicon glyphicon-remove' ></i></a></div></div></li>";
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
                                    $("#answersList")
                                            .append("<br>");
                                    for (var i = 0; i < answers.length; i++) {
                                        var result = answers[i];
                                        var answersList = "<li class='left clearfix'><span class='chat-img pull-left'><div class=''><div class='vote-box' title='Votes'>"
                                                + "<span class='vote-count' id='ans" + result.answerId + "'>" + result.netVotes + "</span><span class='vote-label'>votes</span></div>"
                                                + "</div></span>"
                                                + "<div class='chat-body clearfix'><div class='header'>"
                                                + "<small class='pull-right text-muted'>"
                                                + "<span class='glyphicon glyphicon-time'></span>" + moment(result.answeredOn, "YYYY-MM-DD").fromNow() + "</small></div>"
                                                + "<a href=/MobileHub/index.php/question/show/?id=" + result.questionId + "><p>" + result.description + "</p></a></div></li></ul>";
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

                            function deleteQuestion(qId) {

                                BootstrapDialog.confirm('Are you sure you want to delete this question?', function(result) {
                                    if (result) {
                                        jsonData = {'username': "<?php echo $name; ?>", "questionId": qId};
                                        //console.log(jsonData);

                                        $.post("/MobileHub/index.php/api/question/delete/", jsonData, function(content) {

                                            // Deserialise the JSON
                                            content = jQuery.parseJSON(content);
                                            console.log(content);
                                            if (content.message === "Success") {
//                                                $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
//                                                $('#errorModal').modal('show');
                                                $.get("/MobileHub/index.php/api/user/fulldetails/" + "<?php echo $user ?>", function(resultsData) {
                                                    resultsData = jQuery.parseJSON(resultsData);
                                                    if (resultsData.message === "Error") {
                                                        window.location = "/MobileHub/index.php/custom403/";
                                                        return false;
                                                    } else {
                                                        //setEditableFields(resultsData);
                                                        loadQuestionsUI(resultsData);
                                                        //loadAnswersUI(resultsData.answers);
                                                        return true;
                                                    }
                                                });
                                            } else {
                                                $('#errModalBody').html("<p><center>" + content.type + "</center></p>");
                                                $('#errorModal').modal('show');
                                            }
                                        }).fail(function() {
                                            $('#errModalBody').html("<p><center>" + "Something went wrong when updating. Please try again later" + "</center></p>");
                                            $('#errorModal').modal('show');
                                        }), "json";
                                        return true;
                                    } else {
                                        // Do nothing
                                    }
                                });

                            }

                            function editQuestion(qId, votes, answers) {
                                //Do the validation here and redirect the user
                                if (votes > 0 || answers > 0) {
                                    //Show error that the user cannot edit this question when it has votes or answers
                                    $('#errModalBody').html("<p><center>" + "Sorry, you cannot edit this question as it has votes or answers" + "</center></p>");
                                    $('#errorModal').modal('show');
                                } else {
                                    window.location = "/MobileHub/index.php/question/edit/?id="+qId;
                                }
                            }
</script>