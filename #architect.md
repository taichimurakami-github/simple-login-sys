version: 1.00
commit: 2020.4.15

simple login system powerd by PHP & MySQL
This is only a practice for PHP, MySQL and login system.

# 目的
以前、簡単にログインシステムを作成したが、さらなるPHP,SQLのレベルアップ、オブジェクト指向の習得、また十分なセキュリティ対策に関する勉強もかねて
新たにログインシステムを作成することにした。なお、前回の参考文献もそのまま参考にしつつ、今回はなるべくシンプルで扱いやすいモデルを作成する。

# 仕様

基本設計は前回作成したものを踏襲する。
ver1.xxはほぼ焼き直し版となる。

## データベース定義
+ Xampp 8.0.2(Apatch 2.4.46 + MariaDB 10.4.17 + PHP 8.0.2) 使用
+ データベース名：user01
+ テーブル名：userinfo01
+ 使用カラム：userId(A_I, primary key, int(11) ), email(varchar(128)), password(varchar(255)), userName(varchar(255)), loginFailureCount/Datetime(tinyint(1)/datetime:default null)
  最後のdatetime以外はnot null defaultとする

## 制作にあたっての条件
+ オブジェクト指向で作成すること。
+ なるべく簡素なつくりにし、なおかつ十分な堅牢性とベーシックなセキュリティ強度を持たせること。
+ 使用可能ファイルはphpのみとし、データベースはMySQLとする。
+ POST形式でファイル間のデータのやり取りを行う。
+ login状態はSESSIONで保持する。セキュリティの都合上、後々変更するかも
+ 以下のディレクトリに沿ったファイル作成を行うこと。追加の機能がある場合、以下のディレクトリは更新される。

## ディレクトリ
common.php
Handler/
  | DbHandler.php
  | LoginHandler.php
  | AccountHander.php

models/
  | UserModel.php
  | UserModelBase.php

pages/
  | index.php
  | login.php
  | logout.php
  | regist.php
  | withdrawal.php
  | admin.php


## 各ファイルの説明

### Handlerフォルダ
*DbHandler.php*
PDOを用いてデータベースとのやり取りを行う。
以下の4命令を実行できるメソッドを実装する。引数は$sqlと$arrとする。
+ INSERT, SELECT, DELETE, UPDATE
トランザクション、コミット、ロールバックを実行できるメソッドを定義すること。

*LoginHandler.php*
主にログイン、ログアウトといった、既存のアカウントに対するアプローチを記述する。
loginメソッド、logoutメソッドを実行すると、それぞれlogin,logoutを行い、index.phpに飛ばす。
**なお、adminアカウントでログインした場合のみ、admin.phpに飛ばす。
UserModelクラスの情報を用いて、DbHandler経由でデータベースとやり取りを行うこと。
以下のファイルから参照する。
+ login.php
+ logout.php

*AccountHandler.php*
主にアカウント登録、アカウント消去といった、データベースを操作するアプローチを記述する。
registメソッド、deleteメソッドを定義する。それぞれのメソッドが正常に完了したら、index.phpに飛ばす。
** なお、adminアカウントの消去・登録操作は一切受け付けない。実行されたらエラーを吐くようにすること。
以下のファイルから参照する。
+ regist.php
+ withdrawal.php


### modelsフォルダ
*UserModelBase.php*
ユーザーのアカウント情報を格納する、UserModelBaseクラスを作成する。
id,username,email...など、各要素を格納するprotected arrayプロパティ(初期値はnull)を作成し、
なおかつそれらのsetter,getterを作成する。
後述のUserModelクラスのベースとなる、情報のみの部分を記述することで、可読性とメンテナンス性の向上を目的とする。

*UserModel.php*
UserModelBaseクラスを作成し、これをextendしたUserModelクラスを作成する。
このクラスでは、各Handlerから要求される、ユーザーアカウント関係の処理、およびUserModelBase上のを記述する。
(例えば、getter,setterを起動する仲介処理、パスワードチェックの処理、など)
以下のメソッド以外の作成は自由とする。
+ checkPassword
+ setpropertyAll
+ isAccountLock

### pagesフォルダ
*index.php*
ログインしている/していない状態にかかわらず、このページを表示する。
ただし、ログインしている場合、ログインユーザーのアカウント名を表示すること。

*admin.php*
adminアカウントでログインした場合のみ開くことができる。
データベース全部を管理することができるようにする。すなわち、本ページのGUIにて、登録済みのアカウントのUPDATE, INSERT, DELETE操作を行うことができるようにする。
** なお、GUIの搭載はver2.xx系列より行う。

*その他phpファイル*
名前の通りの操作を行う機能のみを有する。
ログインはemailとpasswordで行い、アカウント登録は上記で定義したデータベースのうち、loginfailure関係以外を入力させる。

## セキュリティ要件
・パスワードはpassword_hash関数を利用して認証・保存を行う
・SQLインジェクション、csrfといった定番の対策を行う