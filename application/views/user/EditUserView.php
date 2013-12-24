<div class="container">
    <div class="well">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
            <li><a href="#profile" data-toggle="tab">Password</a></li>
        </ul>
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane active in" id="home">
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
                            <textarea type="text" id="about" class="form-control" name='website' data-validation="url" data-validation-optional="true" placeholder="About me"></textarea>
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
            <div class="tab-pane fade" id="profile">
                <form id="tab2">
                    <div class="form-group">
                        <label class="control-label col-sm-4">Old Password</label>
                        <div class="col-sm-8">
                            <input type="password" class="form-control" name="pword_confirmation" data-validation="length" data-validation-length="min8" placeholder="Account Password (Min. 8 characters)">
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
    <script>
                            var user;
                            $(document).ready(function() {
                                $.get("/MobileHub/index.php/api/user/fulldetails/" + "<?php echo $user ?>", function(resultsData) {
                                    resultsData = jQuery.parseJSON(resultsData);
                                    if (resultsData.message === "Error") {
                                        window.location = "/MobileHub/index.php/custom403/";
                                        return false;
                                    } else {
                                        user = resultsData;
                                        $("#fName").val(resultsData.user.fullName);
                                        $("#website").val(resultsData.user.website);
                                        $("#about").val(resultsData.user.about);
                                        $("#email").val(resultsData.user.email);
                                        return true;
                                    }
                                });
                            });

                            function postNewData() {
                                jsonData = {"username": "<?php echo $user ?>", 'email': $("#email").val(), "fullName": $("#fName").val(), 'website': $("#website").val()};
                                //console.log(jsonData);

                                $.post("/MobileHub/index.php/api/user/post/" + "<?php echo $user ?>", jsonData, function(content) {

                                    // Deserialise the JSON
                                    content = jQuery.parseJSON(content);
                                    console.log(content);
                                    if (content.message === "Success") {
                                        $("#qError").removeClass('alert alert-danger');
                                        $("#qError").addClass('alert alert-success');
                                        $("#qError").text('Question posted!');
                                        window.location.href = "/MobileHub/index.php/";
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
    </script>