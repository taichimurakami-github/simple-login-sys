<?php
require_once("../Handler/LoginHandler.php");
session_start();
if($_SERVER['REQUEST_METHOD'] === 'POST'){
  App\common\LoginHandler::logout();
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
  <h1>Logout</h1>
  <a href="index.php">TOPに戻る</a>
  <form action="" method="post">
    <p>ログアウトしますか？</p>
    <button type="submit">ログアウト</button>
  </form>
</body>
</html>