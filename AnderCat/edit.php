<?php
require_once('./conn.php');
require_once('./handle_verify.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>留言板</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./message_board.css">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
</head>
<body>
	<nav class="navbar navbar-dark bg-primary">
		<a href="./index.php" class="home" style="text-decoration: none;">留言板</a>
		<div class='form-line my-2 my-lg-0'>
		<?php
		if (isset($_COOKIE['verify_id']) && !empty($_COOKIE['verify_id'])) {
		    echo "<div class='hello'>你好 ,".$username . "</div>";
		    echo "<a href='./logout.php' style='text-decoration:none' class='right'> 登出</a>";
		} else {
			echo "<a href='./login.php' style='text-decoration:none;'>登入 </a>";
			echo "<a href='./register.php' style='text-decoration:none;'>註冊</a>";
		}?>
		</div>
	</nav>
	<div class="container">	
		<div class="warning" color="black">「本站為練習用網站，因教學用途刻意忽略資安的實作，註冊時請勿使用任何真實的帳號或密碼」 </div>
		<div class="comments col-12">
		  			<div class="comment">
						<div class="name">
							<h3>${res.nickname}</h3>
						<span class="time">${res.time}</span>
						</div>
														<div class="right">
									<a class="edit" name='${res.id}' href= ' edit.php?id=${res.id}'>編輯 </a>
									<a onclick="return confirm('確定要刪除嗎?');" name='${res.id}' class="delete_btn" href= 'handle_delete.php?id=${res.id}'> 刪除</a>
								</div>
														<pre>${message}</pre>
					</div>					
					<form method="POST" action="./handle_post.php" class="post-sub">
						<h3 class="newSub">新增留言</h3>
						<input type="hidden" value="112"name="parent_id">
						<textarea type="textarea" name="message" class="user_sub_message" placeholder="留言"></textarea>
						<button class='user_message_btn btn btn-primary'>送出</button>					
				</div>
		<?php
		  $id = $_GET['id'];
		  $stmt = $conn->prepare("SELECT c.comment FROM AnderCat_comments as c  WHERE c.username = ? AND c.id = ?");
		  $stmt->bind_param("ss",$username,$id);
		  $stmt->execute();
		  $result = $stmt->get_result();
		  if ($result->num_rows > 0) {
		  	while($row = $result->fetch_assoc()) {
		  		?>
		  		<form method="POST" action="./handle_edit.php" class="post">
					<textarea type="textarea" name="message" class="user_message" placeholder="留言"><?php echo htmlspecialchars($row['comment'],ENT_QUOTES, 'utf-8') ;?></textarea>
					<input type="hidden" name="id" value="<?php echo $id?>">
					<button class='user_message_btn'>送出</button>
				</form>
				<?php
		  	}
		  }
		?>
	</div>
</body>
</html>
