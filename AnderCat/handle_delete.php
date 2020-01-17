<?php 
  require_once('./conn.php');
  require_once('./handle_verify.php');
  require_once('./alert.php');
  $id = $_POST['id'];
  $stmt = $conn->prepare("DELETE FROM AnderCat_comments WHERE (id = ? OR parent_id = ?) AND username = ?");
  $stmt->bind_param("iis",$id,$id,$username);
  
  if ($stmt->execute()) {
  	$arr = array('result' => 'delete success');
  	echo json_encode($arr);
  } else {
  	echo json_encode(array('result' => 'delete fail'));
  }

?>