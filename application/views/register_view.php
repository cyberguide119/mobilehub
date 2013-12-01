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
        <form action="/MobileHub/index.php/auth/createaccount" method="POST">
        Enter your name (max 50 characters):
            <input type="text" name='name' length="20" size="50">  <br>
        Choose your username (max 10 characters):
            <input type="text" name='uname' length="10" size="10">  <br>
        Choose password:
            <input type="password" name='pword' length="15" size="30"> <br>
        Confirm password:
            <input type="password" name='conf_pword' length="15" size="30">
        <input type="submit" value='Register!'>
    </form>
    <span style="color: red"><?php echo $errmsg ?></span> <br>
    </body>
</html>
