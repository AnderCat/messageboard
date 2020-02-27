<?php
require_once('./conn.php');

function login($username){
  if (isset($username) && !empty($username)) {
    echo "<div class='hello'>你好 ,".$username . "</div>";
    echo "<a href='./logout.php' style='text-decoration:none' class='right'> 登出</a>";
  } else {
    echo "<a href='./login.php' style='text-decoration:none;'>登入 </a>";
    echo "<a href='./register.php' style='text-decoration:none;'>註冊</a>";
  }
}

function submitBtn($username){
  if (isset($username) && !empty($username)) {
    echo "<button class='message_btn btn btn-primary' type='submit'>送出</button>";
  } else {
    echo "<div>登入後可以留言</div>";
  }
}

function speacialChars($context){
  echo htmlspecialchars($context,ENT_QUOTES, 'utf-8');
}


function pages($pages) {
  echo "<div class=" . "pages" . ">";
  echo "第 ";
  for($i=1; $i <= $pages; $i += 1) {
      echo ' <a href="./index.php?page='.$i.'">' . $i . '</a>';
    }
  echo " 頁";
  echo "</div>";
}


?>