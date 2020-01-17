<?php
  require_once('./conn.php');
  require_once('./alert.php');
  $nickname = $_POST['nickname'];
  $username = $_POST['username'];
  $password = $_POST['password'];
  $passwordHash = password_hash($password, PASSWORD_DEFAULT); 

  if (empty($nickname) || empty($username) || empty($password)){
    alert('輸入不能為空','./register.php');
  } else {
  	$repeatNickname = $conn->prepare("SELECT nickname FROM AnderCat_users WHERE nickname = ?");
  	$repeatNickname->bind_param("s",$nickname);
  	$repeatNickname->execute();
  	$result_nickname = $repeatNickname->get_result();

  	$repeatUsername = $conn->prepare("SELECT username FROM AnderCat_users WHERE username = ?");
  	$repeatUsername->bind_param("s",$username);
  	$repeatUsername->execute();
  	$result_username = $repeatUsername->get_result();
  	if ($result_nickname->num_rows !== 0) {
  		alert('暱稱重複', './register.php');
  		exit();
  	} else if ($result_username->num_rows !== 0) {
  		alert('帳號重複', './register.php');
  		exit();
  	} else {
  		$stmt =$conn->prepare("INSERT INTO AnderCat_users(nickname,username,password) VALUES(?,?,?)");
      $stmt->bind_param("sss",$nickname, $username, $passwordHash);
      $stmt->execute();
      $result = $stmt->get_result();
    	if (!$result) {
      		alert('註冊成功', './login.php');
    	} else {
      		alert('網頁出錯 請重試一次', './register.php');
    	}
  	}
  }
?>