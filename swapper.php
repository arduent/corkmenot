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

$a = intval(str_replace('c', '', $_POST['a']));
$b = intval(str_replace('c', '', $_POST['b']));

if ($a < $b) {
    $sql = "SELECT msg FROM cards WHERE cardid='c" . $a . "' AND oby='" . mysqli_real_escape_string(
            $conn,
            $story
        ) . "'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $tmp = $row['msg'];
    mysqli_free_result($res);
    for ($i = $a; $i < $b; $i++) {
        $sql = "UPDATE cards SET msg = (SELECT msg FROM cards WHERE cardid='c" . ($i + 1) . "' AND oby='" .
            mysqli_real_escape_string($conn, $story) . "') WHERE cardid='c" . $i . "'" .
            " AND oby='" . mysqli_real_escape_string($conn, $story) . "'";
        mysqli_query($conn, $sql);
    }
    $sql = "UPDATE cards SET msg='" . mysqli_real_escape_string($conn, $tmp) . "' WHERE cardid='c" . $b . "'" .
        " AND oby='" . mysqli_real_escape_string($conn, $story) . "'";
    mysqli_query($conn, $sql);
} else {
    $sql = "SELECT msg FROM cards WHERE cardid='c" . $a . "'" .
        " AND oby='" . mysqli_real_escape_string($conn, $story) . "'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $tmp = $row['msg'];
    mysqli_free_result($res);
    for ($i = $a; $i > $b; $i--) {
        $sql = "UPDATE cards SET msg = (SELECT msg FROM cards WHERE cardid='c" . ($i - 1) . "' AND oby='" .
            mysqli_real_escape_string($conn, $story) . "') WHERE cardid='c" . $i . "' " .
            " AND oby='" . mysqli_real_escape_string($conn, $story) . "'";
        mysqli_query($conn, $sql);
    }
    $sql = "UPDATE cards SET msg='" . mysqli_real_escape_string($conn, $tmp) . "' WHERE cardid='c" . $b . "'" .
        " AND oby='" . mysqli_real_escape_string($conn, $story) . "'";
    mysqli_query($conn, $sql);
}
mysqli_close($conn);

