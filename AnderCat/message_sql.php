<?php
require_once('./conn.php');
require_once('./count_page.php');
$stmt = $conn->prepare("SELECT c.username,c.id,c.comment, c.created_at, users.nickname FROM AnderCat_comments as c LEFT JOIN AnderCat_users as users ON c.username = users.username WHERE c.parent_id = 0 ORDER BY c.id DESC LIMIT ?,?");
$stmt->bind_param("ss",$start,$per);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $data[] = array('nickname' => $row['nickname'],'created_at' => $row['created_at'],'username' => $row['username'],'id' => $row['id'],'comment' => $row['comment']);
  }
}

?>