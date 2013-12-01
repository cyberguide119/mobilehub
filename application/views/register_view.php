<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Register</title>
    </head>
    <body>
        <h3>Create Account</h3>
        <form action="/MobileHub/index.php/auth/createaccount" method="POST">
        <table>
        <tr>
            <td align="right">Choose a display name (max 10 characters):</td>
            <td><input type="text" name='uname' length="10" size="10" placeholder="Username"></td>
        </tr>
        <tr>
            <td align="right">Your first name and last name (max 50 characters):</td>
            <td><input type="text" name='name' length="20" size="50" placeholder="Full name (Optional)"></td>
        </tr>
        <td>
        <tr>   
            <td align="right">Website:</td>
            <td><input type="text" name='website' length="50" size="50" placeholder="URL of your personal blog or website"></td>
        </tr>
        <tr>
            <td align="right">Account password:</td>
            <td><input type="password" name='pword' length="15" size="30" placeholder="Password"></td>
        </tr>
        <tr>
            <td align="right">Confirm password:</td>
            <td><input type="password" name='conf_pword' length="15" size="30" placeholder="Please retype password"></td>
        </tr>
        <tr>
            <td align="right">Email:</td>
            <td><input type="text" name='email' length="50" size="50" placeholder="Please enter your email"></td>
        </tr>
            <tr><td></td><td align="right"><input type="submit" value='Register'></td></tr>
        </table>
    </form>
    <span style="color: red"><?php echo $errmsg ?></span> <br>
    </body>
</html>
