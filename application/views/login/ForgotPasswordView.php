<div class="container">
    <form method="POST" action="<?php echo site_url('auth/sendResetLink') ?>" role="form" class="form-signup">
        <legend>Reset Password</legend>
        <p>If you are unable to access your account, we will send you a password reset link to your recovery email.</p>
        <br>
        <div class="form-group">
            <input type="text" class="form-control" name='email' data-validation="email" placeholder="Email address">
        </div>
        <br>
        <div class="form-group">
            <button type="submit" class="btn btn-large btn-info">Send Link</button>
        </div>
        <?php
        if ($errmsg != NULL) {
            echo '<div class="alert alert-danger">' . $errmsg . '</div>';
        }
        ?>
    </form>
</div>
<script src="<?php echo site_url('../resources/js/form-validator/jquery.form-validator.min.js') ?>"></script>
<script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    $.validate({
        modules: 'date, security'
    });
</script>