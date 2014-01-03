<div class="container">
    <ol class="breadcrumb">
        <li><a href="/MobileHub/index.php">Home</a></li>
        <li class="active">Forgot Password</li>
    </ol>
    <form method="POST" action="#" role="form" class="form-signup">
        <legend>Reset Password</legend>
        <p>If you are unable to access your account, we will send you a password reset link to your recovery email.</p>
        <br>
        <div class="form-group">
            <input type="text" class="form-control" name='email' data-validation="email" placeholder="Email address" id="txtResetEmail">
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-large btn-info" onclick="sendLink();">Send Link</button>
        </div>
        <?php
        if ($errmsg != NULL) {
            echo '<div class="alert alert-danger">' . $errmsg . '</div>';
        }
        ?>
    </form>

    <!-- Modal -->
    <div class="modal fade" id="resetModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="resetModalLabel">Info</h4>
                </div>
                <div class="modal-body" id="resetModalBody">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>