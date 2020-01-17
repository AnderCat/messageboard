<?php
require_once('./conn.php');
require_once('./count_page.php');
require_once('./message_sql.php');
$subData = [];
$subStmt = $conn->prepare("SELECT c.username,c.id,c.comment, c.created_at, users.nickname FROM AnderCat_comments as c LEFT JOIN AnderCat_users as users ON c.username = users.username WHERE c.parent_id = ? ORDER BY c.id ASC LIMIT ?,?");

$subStmt->bind_param("sss",$row['id'],$start,$per);
$subStmt->execute();
$subResult = $subStmt->get_result();
if ($subResult->num_rows > 0) {
  while($sub_row = $subResult->fetch_assoc()) {
    $mainResponse = $sub_row['username'] === $row['username'] ?  "style='background:#ffc4c1;'" : "";
    $subData[] = array('nickname' => $sub_row['nickname'],'created_at' => $sub_row['created_at'],'username' => $sub_row['username'],'id' => $sub_row['id'],'comment' => $sub_row['comment']);
  }
}
?>