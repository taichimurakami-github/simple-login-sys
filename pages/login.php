<?php
  require_once("../common.php");
  require_once("../Security.php");
  require_once("../Handler/LoginHandler.php");
  use App\common\Csrf;
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
    <button style="display: block; margin-top: 50px;" type="submit">ログイン</button>
    <input type="hidden" name="csrf_token" value="<?php Csrf::get(); ?>"/>
   </form>
   <footer>&copy; 2021 Taichi Murakami All rights reserved.</footer>
</body>
</html>