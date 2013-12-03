<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login Page</title>
    </head>
    <body>
    <h3>Log in</h3>
    <form action="/MobileHub/index.php/auth/authenticate" method="POST">
    <table>
    <tr>
        <td><input type="text" name='uname' length="10" size="30" placeholder="Username"></td>
    </tr>
    <tr>
        <td><input type="password" name='pword' length="15" size="30" placeholder="Password"></td>
    </tr>
   
    <tr>
        <td align="right"><input type="checkbox" name="remember" value='RememberLogin'>Stay signed in</td>
    </tr>
    <tr>
        <td align="right"><a href="/MobileHub/index.php/auth/forgot">Forgot password</td>
    </tr>
    <tr>
        <td align="right"><a href="/MobileHub/index.php/auth/register">Register as a new user</td>
    </tr>
    <tr>
        <td align="right"><input type="submit" value='Login'></td>
    </tr>
    </table>
    </form>
    
    <h2 style="color: red"><?php echo $errmsg;?></h2>
    
    </body>
</html>
