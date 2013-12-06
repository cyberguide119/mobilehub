
        <form action="<?php echo site_url('auth/authenticate');?>" method="POST" role="form" class="form-signin" id="loginForm">
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
                <button class="btn btn-large btn-primary" type="submit" id="btnSubmit">Log in</button>
                <button type="reset" class="btn btn-large btn-default">Reset</button>
            </div>
            <div id="error" class="alert alert-danger"></div>
        </form>
