<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login Page</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/site-theme.css') ?>" rel="stylesheet">
    </head>
    <body>
    <div class="container">
        <form action="<?php echo site_url('auth/authenticate');?>" method="POST" role="form" class="form-signin">
            <h2>Log in</h2>
            <div class="form-group">
                <input type="text" class="form-control" name='uname' length="10" size="30" placeholder="Username"><br/>
                <input type="password" class="form-control" name='pword' length="15" size="30" placeholder="Password">
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
    </body>
</html>
