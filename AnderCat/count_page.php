<?php
require_once('./conn.php');

	$commentsCount = $conn->prepare("SELECT COUNT(parent_id) FROM AnderCat_comments where parent_id = 0");
	$commentsCount->execute();
	$countResult = $commentsCount->get_result();
	$sum1 = $countResult->fetch_assoc(); 
	$sum = $sum1['COUNT(parent_id)'];
	$per = 20; 
	$pages = ceil($sum/$per);
	if(!isset($_GET['page'])) {
		$page = 1;
	} else {
		$page = intval($_GET['page']);
	}
 	$start = ($page - 1) * $per;	
?>
		