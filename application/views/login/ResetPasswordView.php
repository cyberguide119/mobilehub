<div class="container">
    <form method="POST" action="<?php echo site_url('auth/sendResetLink') ?>" role="form" class="form-signup">
        <legend>Update your password</legend>
        <p>You will be able to login with the updated password.</p>
        <br>
        <div class="form-group">
            <input type="password" class="form-control" name='pword_confirmation' data-validation="length" data-validation-length="min8" placeholder="New Password" id="newPw">
            <br>
            <input type="password" class="form-control" name='pword' data-validation="length" data-validation-length="min8" placeholder="Confirm New Password" id="newPwConf">
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-large btn-info" onclick="updatePass();">Update Password</button>
        </div>
        <?php
        if ($errmsg != NULL) {
            echo '<div class="alert alert-danger">' . $errmsg . '</div>';
        }
        ?>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Info</h4>
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
                function updatePass() {
                    $pw = $("#newPw").val();
                    $conf_pw = $("#newPwConf").val();
                    jsonObj = {"email": "<?php echo $email; ?>", "hash": "<?php echo $hash ?>", "pass": $pw};

                    if ($pw === $conf_pw) {
                        $.post("/MobileHub/index.php/api/auth/reset", jsonObj, function(resultsData) {
                            resultsData = jQuery.parseJSON(resultsData);
                            if (resultsData.message === "Success") {
                                $('#errorModal').html("<p><center>" + content.type + "</center></p>");
                                $('#errorModal').modal('show');
                            }
                        }).fail(function() {
                            $('#errorModal').html("<p><center>" + content.type + "</center></p>");
                            $('#errorModal').modal('show');
                        });
//                        $.ajax({
//                            type: 'POST',
//                            url: "/MobileHub/index.php/api/auth/reset",
//                            data: {},
//                            success: function(data) {
//                                console.log(data);
//                            },
//                            error: function(xhr, status, errorThrown) {
//                                console.log(xhr); //could be alert if you don't use the dev tools
//                            },
//                            dataType: "json"
//                        });
                    }
                }
</script>