<?php

include('db.php');

$story = intval($_POST['story']);
if ($story < 1) {
    mysqli_close($conn);
    exit();
}

$sql = "SELECT uid FROM stories WHERE idx='" . mysqli_real_escape_string($conn, $story) . "'";
$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_array($res);
    if ($row['uid'] != $uid) {
        mysqli_free_result($res);
        mysqli_close($conn);
        exit();
    }
} else {
    mysqli_free_result($res);
    mysqli_close($conn);
    exit();
}
mysqli_free_result($res);


$card = $_POST['card'];
$msg = $_POST['msg'];

$sql = "SELECT idx FROM cards WHERE cardid='" . mysqli_real_escape_string($conn, $card) . "' AND oby='" .
    mysqli_real_escape_string($conn, $story) . "'";

$res = mysqli_query($conn, $sql);
if (mysqli_num_rows($res) > 0) {
    $row = mysqli_fetch_array($res);
    $idx = $row['idx'];
    $sql = "UPDATE cards SET msg='" . mysqli_real_escape_string($conn, $msg) . "' WHERE idx='" . $idx . "'";
    mysqli_query($conn, $sql);
}
mysqli_free_result($res);
mysqli_close($conn);

echo format_message($msg);

