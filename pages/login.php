<?php
  require_once("../common.php");
  require_once("../Handler/LoginHandler.php");

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    App\common\LoginHandler::login();
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
   <h1>Login</h1>
   <a href="index.php">TOPに戻る</a>
   <form action="" method="post">
    <p>メールアドレス</p>
    <input type="text" name="email" />
    <br>
    <p>パスワード</p>
    <input type="text" name="password" />

    <button type="submit">ログイン</button>
   </form>
   <footer>&copy; 2021 Taichi Murakami All rights reserved.</footer>
</body>
</html>