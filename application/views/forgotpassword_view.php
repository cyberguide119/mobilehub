<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <h3>Reset Password</h3>
        <p>If you are unable to access your account, we will send you a password reset link to your recovery email.</p>
        <form method="POST" action="/MobileHub/index.php/auth/sendResetLink">
            <table>
                <tr>
                   <td><input type="text" name='email' length="10" size="30" placeholder="Email address"></td>
                </tr>
                <tr>
                   <td align="right"><input type="submit" value='Login'></td>
                </tr>
            </table>
        </form>
        
        <?php echo $errmsg;?>
    </body>
</html>
