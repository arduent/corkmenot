<?php

include('db.php');

$sql = "INSERT INTO stories (idx,uid,title,sequence) VALUES (NULL,'" .
    mysqli_real_escape_string($conn, $uid) . "','Untitled'," . time() . ")";
mysqli_query($conn, $sql);
$story = mysqli_insert_id($conn);

for ($i = 0; $i < 300; $i++) {
    $sql = "INSERT INTO cards (idx,cardid,oby,msg,sequence) VALUES (NULL,'" .
        "c" . ($i) . "','" . mysqli_real_escape_string($conn, $story) . "',''," . time() . ")";
    mysqli_query($conn, $sql);
}

mysqli_close($conn);
Header("Location: " . root . "/stories.php");
exit();
