<?php

const username = 'bcardi';
const password = 'bcardi';
const host = '127.0.0.1';
const database = 'bcardi';
const root = '';

$conn = mysqli_connect(host, username, password, database);

$layout = file_get_contents('layout.html');

$authenticated = false;
$uid = 0;

if (isset($_COOKIE['^au^'])) {
    $au = filter_var($_COOKIE['^au^'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH | FILTER_FLAG_STRIP_LOW);
    $au = substr(preg_replace('/[^\da-z]/i', '', $au), 0, 255);

    $sql = "SELECT uid FROM logins WHERE au='" . mysqli_real_escape_string($conn, $au) . "' AND login>0 AND logout<1";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        $uid = $row['uid'];
        $authenticated = true;
    }
    mysqli_free_result($res);
}

if ((!$authenticated) && (!isset($dologin))) {
    Header("Location: " . root . "/login.php");
    exit();
}

function output($content, $layout)
{
    $layout = str_replace('<!--CARDS-->', $content, $layout);
    $layout = str_replace(
        '<!--HEADER IMAGE-->',
        '<img src="' . root . '/corkmenot.png" alt="CorkMeNot" style="width:180px;height:auto;">',
        $layout
    );
    $layout = str_replace(
        '<!--JQUERY-->',
        '<script src="' . root . '/jquery-3.6.0.min.js"></script>',
        $layout
    );
    return $layout;
}

function format_message($msg)
{
    $out = '';
    $r = explode("\n", $msg);

    if (count($r) > 5) {
        $out .= '<span style="color:Red;">*</span>';
    }

    foreach ($r as $v) {
        $out .= htmlentities($v) . '<br>';
    }
    return $out;
}

