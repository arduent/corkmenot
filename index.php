<?php

include('db.php');

$cards = array();

$col = 7;

if (isset($_GET['col'])) {
    $col = intval($_GET['col']);
} elseif (isset($_COOKIE['^col^'])) {
    $col = intval($_COOKIE['^col^']);
}

if ($col < 1) {
    $col = 7;
}

setcookie('^col^', $col, strtotime('+2 years'), '/');

$story = 0;
if (isset($_COOKIE['^story^'])) {
    $story = intval($_COOKIE['^story^']);
}

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

if ($story < 1) {
    $sql = "SELECT MAX(idx) FROM stories WHERE uid='" . mysqli_real_escape_string($conn, $uid) . "'";
    $res = mysqli_query($conn, $sql);
    $row = mysqli_fetch_array($res);
    $story = $row[0];
    mysqli_free_result($res);
}

if ($story < 1) {
    $sql = "INSERT INTO stories (idx,uid,title,sequence) VALUES (NULL,'" .
        mysqli_real_escape_string($conn, $uid) . "','Untitled'," . time() . ")";
    mysqli_query($conn, $sql);
    $story = mysqli_insert_id($conn);

    for ($i = 0; $i < 300; $i++) {
        $sql = "INSERT INTO cards (idx,cardid,oby,msg,sequence) VALUES (NULL,'" .
            "c" . ($i) . "','" . mysqli_real_escape_string($conn, $story) . "',''," . time() . ")";
        mysqli_query($conn, $sql);
    }
}

if ($story < 1) {
    echo 'Internal System Error!';
    exit();
}

$sql = "SELECT COUNT(idx) FROM cards WHERE oby='" . mysqli_real_escape_string($conn, $story) . "'";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);

$cardcount = $row[0];
$rows = floor($cardcount / $col);
mysqli_free_result($res);

setcookie('^story^', $story, strtotime('+30 days'), '/');

$sql = "SELECT title FROM stories WHERE idx='" . mysqli_real_escape_string($conn, $story) . "'";
$res = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($res);
$title = htmlentities($row['title']);
mysqli_free_result($res);


$cid = 0;
for ($i = 0; $i < $rows; $i++) {
    $cards[] = '<tr valign="top">';
    for ($j = 0; $j < $col; $j++) {
        $msg = '';
        $sql = "SELECT msg FROM cards WHERE cardid='c" . $cid . "' AND oby='" . mysqli_real_escape_string(
                $conn,
                $story
            ) . "'";
        $res = mysqli_query($conn, $sql);
        if (mysqli_num_rows($res) > 0) {
            $row = mysqli_fetch_array($res);
            $txt_msg = htmlentities($row['msg']);
            $msg = format_message($row['msg']);
        }
        mysqli_free_result($res);
        $cards[] = '<td class="resize-drag" id="tc' . $cid . '"><div class="event" id="c' . $cid . '" draggable="true" onclick="xclick(' . "'c" . $cid . "');" . '" class="fs">' . $msg . '</div><textarea id="rc' . $cid . '" class="erd" onblur="save(' . "'c" . $cid . "');" . '">' . $txt_msg . '</textarea></td>';
        $cid++;
    }
    $cards[] = '</tr>';
}

$content = '
<script>
var story = ' . $story . ';
</script>
<div class="bgwhite"><a href="' . root . '/stories.php" class="button">Stories</a> ' . $title . '</div>
<table class="table spaced">
<thead>
<tr>
';

for ($i = 1; $i <= $col; $i++) {
    $add = '';
    if ($col == $i) {
        $add = ' <a href="' . root . '/index.php?col=' . ($i + 1) . '" class="button">[+]</a>';
    }
    $content .= ' <th><a href="' . root . '/index.php?col=' . $i . '" class="button">' . $i . '</a>' . $add . '</th>';
}
$content .= '
</tr>
</thead>
<tbody>' . join('', $cards) . '</tbody></table>';

mysqli_close($conn);
echo output($content, $layout);

