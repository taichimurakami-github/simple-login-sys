<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Simple Login System v1.0</title>
</head>
<body>
   <h1>Login Demo Page</h1>
   <h2>
      <?php
        /**
         * ログイン済み：ようこそ○○さん！
         * 未ログイン：<a href="./login.php">こちら</a>よりログインしてください。
         */
      ?>
   </h2>
   <div>
    <?php
      /**
       * ログイン済み：ユーザー情報の提示、ログアウトボタン、アカウント消去ボタンを表示
       * 未ログイン：ログインシステムのでもページです。現在ログインしておりません。
       *            あとログアウトボタン表示
       */
    ?>
   </div>
   <footer>&copy; 2021 Taichi Murakami All rights reserved.</footer>
</body>
</html>