<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>Login Page</title>
    </head>
    <body>
    <h3>Login Page</h3>
    <form action="/MobileHub/index.php/auth/authenticate" method="POST">
        Username : <input type="text" name='uname' length="10" size="10">  <br>
        Password: <input type="password" name='pword' length="15" size="30"> <br>
        <input type="submit" value='Login'>
    </form>
    </body>
</html>
