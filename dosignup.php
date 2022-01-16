<?php

$dologin = true;
include('db.php');
$cutoff = strtotime('-15 minutes');

$err = array();
$email = '';
$pwd = '';
if (is_array($_POST)) {
    foreach ($_POST as $k => $v) {
        if (substr($k, 0, 5) == 'email') {
            $time = intval(substr($k, 5));
            if (($time < $cutoff) || ($time > time())) {
                $err[] = '<li>Please submit the form within 15 minutes.</li>';
            } else {
                $email = $v;
            }
        }
    }
}
if (isset($_POST['name']) && (strlen($_POST['name']) > 0)) {
    $email = '';
}
if (!isset($_POST['verify_email']) || (strlen($_POST['verify_email']) < 1) || ($_POST['verify_email'] != $email)) {
    $err[] = '<li>Verification does not match email address.</li>';
}
if (isset($_POST['verify_pwd']) && (isset($_POST['pwd'])) && ($_POST['pwd'] != $_POST['verify_pwd'])) {
    $err[] = '<li>Passwords do not match.</li>';
} else {
    $pwd = trim($_POST['pwd']);
}
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $sql = "SELECT idx FROM users WHERE email='" . mysqli_real_escape_string($conn, $email) . "'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $err[] = '<li>Email is already used.</li>';
    } else {
        if (strlen($pwd) < 8) {
            $err[] = '<li>Password must be at least 8 characters</li>';
        }
    }
    mysqli_free_result($res);
}
if (count($err) < 1) {
    $sql = "INSERT INTO users (idx,email,pwd,ip,sequence) VALUES (NULL,'" .
        mysqli_real_escape_string($conn, $email) . "','" .
        mysqli_real_escape_string($conn, password_hash($pwd, PASSWORD_DEFAULT)) . "','" .
        mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR']) . "'," . time() . ")";
    mysqli_query($conn, $sql);
    $content = '
<div class="bgwhite">
<h1>Welcome</h1>
<p>Thank you for creating an account. Please log in using your email address and password.</p>
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
</div>
';
} else {
    $content = '
<div class="bgwhite">
<h1>Error</h1>
<p>There was a problem creating your account. Please review the errors and try again.</p>
<ul>' . join('', $err) . '</ul>
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
}

mysqli_close($conn);
echo output($content, $layout);

