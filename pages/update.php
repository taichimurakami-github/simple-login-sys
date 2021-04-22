<?php
  session_start();
  require_once("../common.php");
  require_once("../Models/UserModel.php");
  require_once("../Handler/AccountHandler.php");

  $USER = unserialize($_SESSION['UserModel']);

  if($_SERVER['REQUEST_METHOD'] === 'POST'){
    App\common\AccountHandler::updateAccountInfo();
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
   <h1>Update account info</h1>
   <div>
    <a href="index.php">TOPに戻る</a>

    <h3>現在の<?php echo $USER->getUserName(); ?>さんのユーザーアカウント情報は以下の通りです。</h3>

    <p>ユーザーID: <?php echo $USER->getUserId(); ?></p>
    <p>ユーザーネーム: <?php echo $USER->getUserName(); ?></p>
    <p>メールアドレス: <?php echo $USER->getEmail(); ?></p>
    <p>パスワード: <?php echo $USER->getPassword(); ?></p>
    <p>トークン: <?php echo $USER->getToken(); ?></p>
    <p>ログイン失敗回数: <?php echo $USER->getLoginFailureCount(); ?></p>
    <p>最新のログイン失敗日時: <?php echo $USER->getLoginFailureDatetime(); ?></p>

    <form action="" method="post">
      <style>
        form{padding: 20px 20px 35px; margin: 50px 0; border: 3px solid red;}
        input{display: block; margin-bottom: 15px;}
      </style>
      <p>アカウント情報を変更したい場合、以下を記入したうえで送信ボタンを押してください。</p>
      <p>更新の必要がない項目は、入力しないまま送信しても大丈夫です。</p>
      <!-- <p>更新の必要がない場合、該当箇所は空欄のまま送信してください。</p> -->
      <input type="text" name="userName" placeholder="ユーザーネーム"/>
      <input type="text" name="email" placeholder="メールアドレス" />
      <input type="text" name="password" placeholder="パスワード" />
      <button type="submit">送信してアカウント情報をアップデート</button>
    </form>
   </div>
   <footer>&copy; 2021 Taichi Murakami All rights reserved.</footer>
</body>
</html>