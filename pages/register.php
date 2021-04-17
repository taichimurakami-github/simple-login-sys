<?php
  require("../Handler/AccountHandler.php");

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
  <title>Simple Login System v1.0</title>
</head>
<body>
   <h1>Regist</h1>
   <form action="" method="post">
    <p>ユーザー名</p>
    <input type="text" name="userName" />
    <br>
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