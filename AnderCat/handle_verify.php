<?php
	session_start();
	require_once('./conn.php');
	if (isset($_SESSION['username']) && !empty($_SESSION['username'])){
		$username = $_SESSION['username'];
	} else {
		$username = null;
	}
?>