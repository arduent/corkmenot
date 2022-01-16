<?php

include('db.php');

if (isset($_GET['story'])) {
    $story = intval($_GET['story']);
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
    $sql = "SELECT COUNT(idx),MAX(idx) FROM cards WHERE oby='" . mysqli_real_escape_string($conn, $story) . "'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $count = $row[0];
    $max = $row[0];
    mysqli_free_result($res);
    if ($count < 1000) {
        $sql = "SELECT cardid FROM cards WHERE idx='" . $max . "'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_array($res);
        $cid = intval(str_replace('c', '', $row['cardid']));
        mysqli_free_result($res);
        for ($i = 0; $i < 100; $i++) {
            $cid++;
            $sql = "INSERT INTO cards (idx,cardid,oby,msg,sequence) VALUES (NULL,'" .
                "c" . ($cid) . "','" . mysqli_real_escape_string($conn, $story) . "',''," . time() . ")";
            mysqli_query($conn, $sql);
        }
    }
}

mysqli_close($conn);
Header("Location: " . root . "/stories.php");
exit();
