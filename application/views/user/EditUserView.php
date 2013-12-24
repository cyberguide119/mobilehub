

<div class="container">
    <form action="<?php echo site_url('api/auth/create') ?>" method="POST" class="form-horizontal form-signup" id="registerForm">
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
                <input type="text" class="form-control" name='website' data-validation="url" data-validation-optional="true" placeholder="URL of your personal blog or website (Optional)">
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
        <div id="reg-error"></div>
    </form>
</div>
<script>
    /* important to locate this script AFTER the closing form element, so form object is loaded in DOM before setup is called */
    $.validate({
        modules: 'date, security',
        onModulesLoaded: function() {
            var optionalConfig = {
                fontSize: '10pt',
                padding: '4px',
                bad: 'Very bad',
                weak: 'Weak',
                good: 'Good',
                strong: 'Strong'
            };

            $('input[name="pword_confirmation"]').displayPasswordStrength(optionalConfig);
        },
        
         onSuccess : function() {
                $dataToSend = new Array();
                $registerForm = $("#registerForm");
                $serializedData = $registerForm.serializeArray();
                $.post("/MobileHub/index.php/api/auth/create", $serializedData, function (content){
                    
                    // Deserialise the JSON
                    content = jQuery.parseJSON(content);
                    console.log(content);
                    if(content.message === "success"){
                        $("#registerForm div[id=reg-error]").removeClass('alert alert-danger');
                        $("#registerForm div[id=reg-error]").addClass('alert alert-success');
                        $("#registerForm div[id=reg-error]").text('Account created successful!');
                    }else{
                        $("#registerForm div[id=reg-error]").addClass('alert alert-danger');
                        $("#registerForm div[id=reg-error]").text(content.message);
                    }
                    }), "json";
                return true;
            }
    });
</script>