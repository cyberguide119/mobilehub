<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Register</title>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?php echo site_url('../resources/css/bootstrap.min.css') ?>" rel="stylesheet">
        <link href="<?php echo site_url('../resources/css/site-theme.css') ?>" rel="stylesheet">
    </head>
    <body>
    <div class="container">
            <h2>Create Account</h2>
            <form action="<?php echo site_url('/auth/createaccount') ?>" method="POST" class="form-horizontal">
                <div class="form-group">
                    <label class="control-label col-sm-2">Username</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='uname' length="10" size="10" placeholder="Choose a display name (max 10 characters)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Full Name</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='name' length="20" size="50" placeholder="Your first name and last name (Optional)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Website</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='website' length="50" size="50" placeholder="URL of your personal blog or website">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Account password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name='pword' length="15" size="30" placeholder="Password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Confirm password</label>
                    <div class="col-sm-10">
                        <input type="password" class="form-control" name='conf_pword' length="15" size="30" placeholder="Please retype password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-2">Email</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" name='email' length="50" size="50" placeholder="Please enter your email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
                </div>
        <span style="color: red"><?php echo $errmsg ?></span> <br>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery.js"></script>
    <script src="<?php echo site_url('../resources/js/bootstrap.min.js')?>"></script>
    
    </body>
</html>
