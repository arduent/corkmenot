<?php

$dologin = true;
include('db.php');

$content = '
<div class="bgwhite">
<h1>Login</h1>
<form method="post" action="' . root . '/dologin.php">
<table class="table">
<tbody>
<tr><td>Email</td><td><input type="text" name="email" value="" size="32"></td></tr>
<tr><td>Password</td><td><input type="password" name="pwd" value="" size="32"></td></tr>
<tr><td> </td><td><button type="submit" class="button">Log In</button></td></tr>
</tbody>
</table>
</form>

<h1>Sign Up</h1>
<form method="post" action="' . root . '/dosignup.php">
<table class="table">
<tbody>
<tr id="name"><td>Name</td><td><input type="text" id="first_name" name="name" size="32"></td></tr>
<tr><td>Email</td><td><input type="text" name="email' . time() . '" value="" size="32" onfocus="verify();"></td></tr>
<tr id="email"><td>Verify Email</td><td><input type="text" name="verify_email" value="" size="32"></td></tr>
<tr><td>Password</td><td><input type="password" name="pwd" value="" size="32"></td></tr>
<tr><td>Verify Password</td><td><input type="password" name="verify_pwd" value="" size="32"></td></tr>
<tr><td> </td><td><button type="submit" class="button">Register</button></td></tr>
</tbody>
</table>
</form>
</div>
';

mysqli_close($conn);
echo output($content, $layout);

