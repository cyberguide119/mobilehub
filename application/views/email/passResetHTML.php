<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN">
<html xmlns="http://www.w3.org/1999/xhtml" lang="en" xml:lang="en">
    <head>
        <meta charset='utf-8'></meta>
        <title>Create a new password on MobileHub</title>
    </head>

    <body>
        <p>Hi <?php echo $fullName . ','; ?></p>
        <p>Forgot your password, huh? No big deal!</p>
        <p>Please visit the following link to reset your password</p>
        <pre><h4>localhost/MobileHub/auth/updateNewPassword/<?php echo $email . '/' . $emailCode; ?></h4></pre>
        <p>Thank you!</p>
        <p>MobileHub Team</p>
    </body>
</html>