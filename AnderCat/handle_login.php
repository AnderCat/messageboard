<?php
  session_start();
  require_once('./conn.php');
  require_once('./alert.php');
  $username = $_POST['username'];
  $password = $_POST['password'];

  if (empty($username) || empty($password)) {
    alert('帳密不能為空', './login.php');
  } else {
  	$stmt = $conn->prepare("SELECT * FROM AnderCat_users WHERE username=?");
  	$stmt->bind_param("s",$username);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows !== 0){
      while ($row = $result->fetch_assoc()) {
        $hashPassword = password_verify($password, $row["password"]);
        if ($hashPassword) {
          $_SESSION['username'] = $username;
          header('Location: ./index.php');
        } else {
          alert('帳號密碼錯誤', './login.php');
        }
      }
    } else {
      alert('帳號密碼錯誤', './login.php');
    }

  }
 ?>