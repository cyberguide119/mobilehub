<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/site-theme.css') ?>" rel="stylesheet">
    </head>
    <body>
    <div class="container">
        <form action="<?php echo site_url('auth/authenticate');?>" method="POST" role="form" class="form-signin">
            <legend><span class="glyphicon glyphicon-lock"></span>&nbsp;Log in</legend>
            <p>Please log in using your credentials</p>
            <div class="form-group">
                <input type="text" class="form-control" name='uname' data-validation="required" placeholder="Username"><br/>
                <input type="password" class="form-control" name='pword' data-validation="required" placeholder="Password">
            </div>    
            <div class="checkbox">
                <label>
                    <input type="checkbox" name="remember" value='RememberLogin'>Stay signed in
                </label>
            </div>
            <div class="form-group">
                <a href="/MobileHub/index.php/auth/forgot">Forgot password</a>
            </div>
            <div class="form-group">
                <a href="/MobileHub/index.php/auth/register">Register as a new user</a>
            </div>
            <div class="form-group">
                <button class="btn btn-large btn-primary" type="submit">Log in</button>
                <button type="reset" class="btn btn-large btn-default">Reset</button>
            </div>
            <?php 
                if ($errmsg != NULL){
                    echo '<div class="alert alert-danger">' . $errmsg . '</div>';
                }
            ?>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="<?php echo site_url('../resources/js/bootstrap.min.js')?>"></script>
    <script src="<?php echo site_url('../resources/js/form-validator/jquery.form-validator.min.js') ?>"></script>
    <script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
        $.validate({
            modules : 'date, security'
        });
    </script>
    </body>
</html>
