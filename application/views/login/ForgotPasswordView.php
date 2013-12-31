<div class="container">
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
</div>