<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Forgot Password</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/site-theme.css') ?>" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <form method="POST" action="<?php echo site_url('auth/sendResetLink')?>" role="form" class="form-signup">
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
                    if ($errmsg != NULL){
                        echo '<div class="alert alert-danger">' . $errmsg . '</div>';
                    }
                ?>
            </form>
        </div>
        <script src="<?php echo site_url('../resources/js/form-validator/jquery.form-validator.min.js') ?>"></script>
        <script>
        /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
            $.validate({
                modules : 'date, security'
            });
        </script>
    </body>
</html>
