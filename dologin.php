<?php

$dologin = true;
include('db.php');

$authenticated = false;

$allowed_failed = 5;
$allowed_within = strtotime('-15 minutes');
$toomany = '';
$failed = 0;

$email = '';
if (isset($_POST['email'])) {
    $email = $_POST['email'];
}

if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (isset($_POST['pwd'])) {
        $pwd = $_POST['pwd'];
        $sql = "SELECT pwd,idx FROM users WHERE email='" .
            mysqli_real_escape_string($conn, $email) . "'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);

            $check = $row['pwd'];
            $idx = $row['idx'];

            mysqli_free_result($res);

            $failed = 0;

            $sql = "SELECT COUNT(idx) FROM failed_logins WHERE email='" .
                mysqli_real_escape_string($conn, $email) . "' AND sequence>" . $allowed_within;
            $res = mysqli_query($conn, $sql);
            if (mysqli_num_rows($res) > 0) {
                $row = mysqli_fetch_array($res);
                $failed = $row[0];
            }
            mysqli_free_result($res);

            if (($failed < $allowed_failed) && (password_verify($pwd, $check))) {
                $au = bin2hex(random_bytes(120));
                setcookie('^au^', $au, strtotime('+30 days'), '/');

                $sql = "INSERT INTO logins (idx,uid,au,login,logout,ip) VALUES (NULL,'" .
                    mysqli_real_escape_string($conn, $idx) . "','" .
                    mysqli_real_escape_string($conn, $au) . "'," . time() . ",0,'" .
                    mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR']) . "')";
                mysqli_query($conn, $sql);
                $authenticated = true;
            } else {
                $sql = "INSERT INTO failed_logins (idx,email,ip,sequence) VALUES (NULL,'" .
                    mysqli_real_escape_string($conn, $email) . "','" .
                    mysqli_real_escape_string($conn, $_SERVER['REMOTE_ADDR']) . "'," . time() . ")";
                mysqli_query($conn, $sql);
            }
        } else {
            mysqli_free_result($res);
        }
    }
}
mysqli_close($conn);
if ($authenticated) {
    Header("Location: " . root . "/index.php");
    exit();
} else {
    if ($failed >= $allowed_failed) {
        $toomany = '<p><strong>Too Many Failed Login Attempts. Please wait about 15 minutes.</strong></p>
';
    }
    $content = '
<div class="bgwhite">
<h1>OOPS Login Failed</h1>
<p>Please try again.</p>' . $toomany . '
<form method="post" action="' . root . '/dologin.php">
<table class="table">
<tbody>
<tr><td>Email</td><td><input type="text" name="email" value="" size="32"></td></tr>
<tr><td>Password</td><td><input type="password" name="pwd" value="" size="32"></td></tr>
<tr><td> </td><td><button type="submit" class="button">Log In</button></td></tr>
</tbody>
</table>
</form>
';

    echo output($content, $layout);
}

