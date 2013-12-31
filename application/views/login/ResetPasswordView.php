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
</div>

<script type="text/javascript">
                function updatePass() {
                    $pw = $("#newPw").text();
                    $conf_pw = $("#newPwConf").text();
                    jsonObj = {"email" : <?php echo $email; ?>, "hash" : <?php echo $hash?>, "pass" : $pw};
                    if ($pw !== $conf_pw) {
                        $.post("/MobileHub/index.php/api/auth/reset", jsonObj, function(resultsData) {
                            resultsData = jQuery.parseJSON(resultsData);
                            if (resultsData.message === "Success") {
                                alert("success");
                            }
                            return true;
                        }).fail(function() {
                            alert("error");
                        });
                    }
                }
</script>