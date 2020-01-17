<?php 
  require_once('./conn.php');
  require_once('./handle_verify.php');
  require_once('./alert.php');
  $message = $_POST['message'];
  $parent_id = $_POST['parent_id'];
  $stmt = $conn->prepare("INSERT INTO AnderCat_comments(comment, username, parent_id) VALUES(?,?,?)");
  $stmt->bind_param("ssi", $message, $username, $parent_id);
  $stmt->execute();
  $stmtInf = $conn->prepare("SELECT c.username, c.created_at, users.nickname FROM AnderCat_comments as c LEFT JOIN AnderCat_users as users ON c.username = users.username WHERE c.parent_id = ? ORDER BY c.created_at DESC LIMIT 1");
  $stmtInf->bind_param("i",$parent_id);
  $stmtInf->execute();
  $last_id = $stmt->insert_id;
  $result = $stmtInf->get_result();
  if ($result->num_rows > 0) {
  	while ($row = $result->fetch_assoc()) {
  		$arr = array('result' => 'success', 'nickname' => $row['nickname'] ,'time' => $row['created_at'],'id' => $last_id);
  		echo json_encode($arr);
  	}
  } else {
  	$arr = array('result' => 'fail');
  	echo json_encode($arr);
  }
  	
  

?>