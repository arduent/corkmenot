<?php

include('db.php');

$sql = "SELECT * FROM stories WHERE uid='" . mysqli_real_escape_string($conn, $uid) . "' ORDER BY idx DESC";
$res = mysqli_query($conn, $sql);

$content = '
<script>
function showedittitle(idx)
{
	if ($("#e"+idx).text()=="Save Edit")
	{
		$("#s"+idx).text($("#ts"+idx).val());
		$("#e"+idx).text("Edit Title");
		$.post("savestory.php",{ story: idx, title: $("#ts"+idx).val() })

	} else {
		$("#e"+idx).text("Save Edit");
	}
	$("#s"+idx).toggle();
	$("#ts"+idx).toggle();
}
</script>
<div class="bgwhite">
<h1>Your Stories</h1>
<p><a href="' . root . '/index.php" class="button">Return to Cards</a> <a href="' . root . '/newstory.php" class="button">New Story</a></p>

<p>If you have less than 100 remaining blank cards you may add 100 more, up to 1,000 total cards per story.</p>
<table class="table" style="width:100%;max-width:1000px;">
<thead>
<tr>
<th></th>
<th>Title</th>
<th>Date</th>
<th># Cards</th>
<th>Add</th>
</tr>
</thead>
<tbody>
';

while ($row = mysqli_fetch_array($res)) {
    $content .= '
<tr>
<td width="40"><a href="' . root . '/index.php?story=' . $row['idx'] . '" class="bluebutton">Go</a></td>
<td colspan="4" style="background-color:#ccc;">
<span id="s' . $row['idx'] . '">' . htmlentities($row['title']) . '</span>
<input type="text" id="ts' . $row['idx'] . '" style="display:none;" value="' . htmlentities($row['title']) . '"></td>
</tr>
<tr><td> </td>
<td><a href="javascript:void(0);" onclick="showedittitle(' . $row['idx'] . ');" class="button"><span id="e' . $row['idx'] . '">Edit Title</span></a></td>
<td style="text-align:center;">' . date('Y-m-d') . '</td>
<td style="text-align:center;">';

    $sql = "SELECT COUNT(idx) FROM cards WHERE oby='" . $row['idx'] . "' AND msg!=''";
    $xres = mysqli_query($conn, $sql);
    $xrow = mysqli_fetch_array($xres);
    $filled = $xrow[0];
    mysqli_free_result($xres);
    $sql = "SELECT COUNT(idx) FROM cards WHERE oby='" . $row['idx'] . "'";
    $xres = mysqli_query($conn, $sql);
    $xrow = mysqli_fetch_array($xres);
    $content .= $filled . '/' . $xrow[0] . '</td>';
    if ($xrow[0] < 1000) {
        if (($xrow[0] - $filled) < 100) {
            $content .= '
<td style="text-align:center;"><a href="' . root . '/addcards.php?story=' . $row['idx'] . '" class="button">Add 100</a></td>
';
        } else {
            $content .= '
<td style="text-align:center;">(100+ unused)</td>
';
        }
    } else {
        $content .= '<td style="text-align:center;">(max reached)</td>';
    }
    mysqli_free_result($xres);
    $content .= '
</tr>
<tr><td colspan="5"><br> </td></tr>
';
}
$content .= '
</table>
</div>
';
mysqli_close($conn);
echo output($content, $layout);


