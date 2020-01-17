<?php
require_once('./conn.php');
require_once('./handle_verify.php');
require_once('./count_page.php');
require_once('./utils.php');
require_once('./message_sql.php');
?>

<!DOCTYPE html>
<html>
<head>
	<title>留言板</title>
	<meta charset="utf-8">
	<link rel="stylesheet" type="text/css" href="./message_board.css" charset="utf-8">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
	<script type="text/javascript" async src="./message_board.js"></script>
</head>
<body>
	<nav class="navbar navbar-dark bg-primary">
		<a href="./index.php" class="home" style="text-decoration: none;">留言板</a>
		<div class='form-line my-2 my-lg-0'>
		<?php login($username); ?>
		</div>
	</nav>


	<div class="container col-6">
		<form method="POST" action="./handle_post.php" class="post col-12" >
			<input type="hidden" value="0" name="parent_id">
			<textarea type="textarea" name="message" class="user_message" placeholder="留言"></textarea>
			<?php submitBtn($username); ?>
		</form>
		<div class="board_comment"> </div>
		<input type="hidden" class="edit_message edit_submit">
		<?php
			foreach ($data as $row ) {
		  		?>
		  		<div class="comments col-12">
		  			<div class="comment">
						<div class="name">
							<h3 class="mainName"><?php echo htmlspecialchars($row['nickname'],ENT_QUOTES, 'utf-8'); ?></h3>
							<span class="time"><?php echo $row['created_at'];?></span>
						</div>
						<div >
						<?php
							if (isset($username) && !empty($username) && $username === $row['username']) {
								?>
								<div class="right">
									<button class="edit btn btn-success" >編輯</button>
									<button class="delete_btn btn btn-success" name= '<?php echo $row['id']; ?>' href= '<?php echo"handle_delete.php?id=" . $row['id']; ?>'>刪除</button>
								</div>
								<?php
							}
							?>
						<pre><?php echo htmlspecialchars($row['comment'],ENT_QUOTES, 'utf-8');?></pre>
						</div>
					</div>
					<?php
					  include('./subMessage_sql.php');
						foreach ($subData as $sub_row) {
					?>
					<div class="sub-comments">
						<div class="sub-comment" <?php echo $mainResponse; ?>>
							<div class="name">
								<h3><?php echo htmlspecialchars($sub_row['nickname'],ENT_QUOTES, 'utf-8'); ?></h3>
							<span class="time"><?php echo $sub_row['created_at'];?></span>
							</div>
							<div>
								<?php
									if (isset($username) && !empty($username) && $username === $sub_row['username']) {
									?>
										<div class="right">
											<button class="sub_edit_btn btn btn-success" href= ' <?php echo "edit.php?id=" . $sub_row['id'];?>'>編輯 </button>
											<button class="sub_delete_btn btn btn-success"  name= "<?php echo $sub_row['id']; ?>" href= '<?php echo"handle_delete.php?id=" . $sub_row['id']; ?>'> 刪除</button>
										</div>
								<?php
									}
							?>
										<pre><?php echo htmlspecialchars($sub_row['comment'],ENT_QUOTES, 'utf-8');?></pre>
							</div>
						</div>
					</div>
						<?php
		  				}
		  			?>
					<form method="POST" action="./handle_post.php" class="post-sub">
						<h3 class="newSub">新增留言</h3>
						<input type="hidden" value="<?php echo $row['id']?>"name="parent_id">
						<textarea type="textarea" name="message" class="user_sub_message" placeholder="留言"></textarea>
						<?php
							if (isset($username) && !empty($username)) {
								echo "<button class='sub_message_btn btn btn-primary'>送出</button>";
							} else {
								echo "<div>登入後可以留言</div>";
							}
						?>
					</form>
				</div>

			<?php

		  }
		pages($pages);
			?>

	</div>
</body>
</html>
