<?php

include('db.php');

$story = 0;
if (isset($_POST['story'])) {
    $story = intval($_POST['story']);
}

if ($story > 0) {
    $sql = "SELECT uid FROM stories WHERE idx='" . mysqli_real_escape_string($conn, $story) . "'";
    $res = mysqli_query($conn, $sql);
    if (mysqli_num_rows($res) > 0) {
        $row = mysqli_fetch_array($res);
        if ($row['uid'] != $uid) {
            $story = 0;
        }
    } else {
        $story = 0;
    }
    mysqli_free_result($res);
}

if ($story > 0) {
    $sql = "UPDATE stories SET title='" . mysqli_real_escape_string(
            $conn,
            $_POST['title']
        ) . "' WHERE idx='" . mysqli_real_escape_string($conn, $story) . "'";
    mysqli_query($conn, $sql);
}
mysqli_close($conn);

