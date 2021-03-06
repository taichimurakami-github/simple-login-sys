<?php
session_start();
require_once("../common.php");
require_once("../Models/UserModel.php");
$IS_LOGINED = false;
/**
 * ログイン状態のチェックを行う
 */
if(isset($_SESSION['UserModel'])){
   if( !is_null($_SESSION['UserModel']) ){
      /**
       * ログインしていたら
       * セッションを開始し、ユーザーモデルを変数に格納
       */
      $USER = unserialize($_SESSION['UserModel']);
      $IS_LOGINED = true;
   }
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
   <h1>Login Demo Page</h1>
   <?php
      /**
       * ログイン済み：ようこそ○○さん！
       * 未ログイン：<a href="./login.php">こちら</a>よりログインしてください。
       */
      if($IS_LOGINED):
   ?>
      <p>ようこそ <?php echo $USER->getUserName(); ?> さん！</p>

   <?php else: ?>
      <h2>ようこそ ゲスト さん！</h2>
      <h2><a href="login.php">こちら</a>よりログインしてください。</h2>
   <?php endif; ?>
   <div>
    <?php
      /**
       * ログイン済み：ユーザー情報の提示、ログアウトボタン、アカウント消去ボタンを表示
       * 未ログイン：ログインシステムのでもページです。現在ログインしておりません。
       *            あとログアウトボタン表示
       */
      if($IS_LOGINED):
    ?>
      <a href="logout.php">ログアウト</a>
      <a href="update.php">アカウント情報変更</a>
      <h3><?php echo $USER->getUserName(); ?>さんのユーザーアカウント情報</h3>
      <p>ユーザーID: <?php echo $USER->getUserId(); ?></p>
      <p>ユーザーネーム: <?php echo $USER->getUserName(); ?></p>
      <p>メールアドレス: <?php echo $USER->getEmail(); ?></p>
      <p>パスワード: <?php echo $USER->getPassword(); ?></p>
      <p>トークン: <?php echo $USER->getToken(); ?></p>
      <p>ログイン失敗回数: <?php echo $USER->getLoginFailureCount(); ?></p>
      <p>最新のログイン失敗日時: <?php echo $USER->getLoginFailureDatetime(); ?></p>

      <form action="withdrawal.php" method="post" onsubmit="return submitCheck();">
         <button name="eraceAccount" type="submit">アカウント消去</button>
         <style>button{background:red; color: white; font-weight: bold; font-size: 20px; width: 200px; height: 50px; cursor: pointer; margin: 50px 0 100px;}</style>
      </form>

    <?php else: ?>
      <p>ログインシステムのデモページです。現在ログインしておりません。</p>
      <p>ログインは<a href="login.php">こちら</a></p>
      <p>アカウント登録は<a href="register.php">こちら</a></p>

    <?php endif; ?>
   </div>
   <footer>&copy; 2021 Taichi Murakami All rights reserved.</footer>
</body>
<script>
   const btn = document.getElementsByTagName("button").item(0);

   const submitCheck = () => {
      return window.confirm("アカウントを消去しますか？") ? true : false;
   }
</script>
</html>