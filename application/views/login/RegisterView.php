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
            <form action="<?php echo site_url('/auth/createaccount') ?>" method="POST" class="form-horizontal form-signup">
                <h2>Create Account</h2><br>
                <div class="form-group">
                    <label class="control-label col-sm-4">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='uname' length="10" size="10" placeholder="Choose a display name (max 10 characters)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='name' length="20" size="50" placeholder="Your first name and last name (Optional)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Website</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='website' length="50" size="50" placeholder="URL of your personal blog or website">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name='pword' length="15" size="30" placeholder="Account Password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Password (Confirm)</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name='conf_pword' length="15" size="30" placeholder="Please retype password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='email' length="50" size="50" placeholder="Please enter your email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-success">Register</button>
                    </div>
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
