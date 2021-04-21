<?php
  require_once("../common.php");
  require_once("../Handler/AccountHandler.php");

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    App\common\AccountHandler::regist();
  }
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo APP_TITLE; ?></title>
</head>
<body>
   <h1>Regist</h1>
   <a href="index.php">TOPに戻る</a>
   <form action="" method="post" onsubmit="return submitCheck();">
    <p>ユーザー名</p>
    <input type="text" name="userName" />
    <br>
    <p>メールアドレス</p>
    <input type="text" name="email" />
    <br>
    <p>パスワード</p>
    <input type="text" name="password" />

    <button type="submit">上記の内容でアカウント登録する</button>
   </form>
   <footer>&copy; 2021 Taichi Murakami All rights reserved.</footer>
</body>
<script>
   const btn = document.getElementsByTagName("button").item(0);

   const submitCheck = () => {
      return window.confirm("この内容で新規アカウントを登録しますか？") ? true : false;
   }
</script>
</html>