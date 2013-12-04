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
                <legend>Create Account</legend><br>
                <div class="form-group">
                    <label class="control-label col-sm-4">Username</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='uname' data-validation='length alphanumeric' data-validation-length='4-12' 
		 data-validation-error-msg='Between 3-12 chars, only alphanumeric characters' placeholder="Choose a display name (max 12 characters)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Full Name</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='name' data-validation="length" data-validation-length="max50" data-validation-optional="true" placeholder="Your first name and last name (Optional)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Website</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='website' data-validation="url" data-validation-optional="true" placeholder="URL of your personal blog or website">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Password</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="pword_confirmation" data-validation="length" data-validation-length="min8" placeholder="Account Password (Min. 8 characters)">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Password (Confirm)</label>
                    <div class="col-sm-8">
                        <input type="password" class="form-control" name="pword" data-validation="confirmation" placeholder="Please retype password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="control-label col-sm-4">Email</label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name='email' data-validation="email" placeholder="Please enter your email">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-8">
                        <button type="submit" class="btn btn-success">Register</button>
                        <button type="reset" class="btn btn-large btn-default">Reset</button>
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
    <script src="<?php echo site_url('../resources/js/form-validator/jquery.form-validator.min.js') ?>"></script>
    <script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
        $.validate({
            modules : 'date, security',
            
            onModulesLoaded : function() {
            var optionalConfig = {
              fontSize: '10pt',
              padding: '4px',
              bad : 'Very bad',
              weak : 'Weak',
              good : 'Good',
              strong : 'Strong'
            };

            $('input[name="pword_confirmation"]').displayPasswordStrength(optionalConfig);
            }
        });
    </script>
    </body>
</html>
