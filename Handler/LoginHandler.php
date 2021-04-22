<?php
namespace App\common;
require_once("../Security.php");
require_once("../Models/UserModel.php");
require_once("../ErrorHandler/ErrorHandler.php");
require_once("../ErrorHandler/ExceptionCode.php");

use __PHP_Incomplete_Class;
use App\model\UserModel;

class LoginHandler {
  /**
   * メールアドレスとパスワードを照合し、ログイン操作を行う
   * @return void
   */
  public static function login()
  {
    if(!filter_input_array(INPUT_POST))
    {
      throw new InvalidErrorException(ExceptionCode::EMPTY_INPUT);
    }

    $post_password = filter_input(INPUT_POST, 'password');
    $post_email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

    /**
     * csrf対策
     */
    Csrf::verify();

    /**
     * 入力値が空かどうかチェック
     */
    if($post_password == '' || $post_email == '')
    {
      throw new InvalidErrorException(ExceptionCode::EMPTY_INPUT);
    }

    /**
     * トランザクション開始
     */
    DbHandler::transaction();

    /**
     * POSTされたemail情報をもとにユーザー情報を扱うUserModelクラスを作成する
     * データベースより各プロパティを取り出し、objにセット
     */
    $userModel = new UserModel();
    if(!$userModel->getModelByEmail($post_email))
    {
      throw new InvalidErrorException(ExceptionCode::DB_CONNECT_GET_ERROR);
    }
   
    /**
     * アカウントがロックされているかどうかを確認する
     * ロックされていたら、トランザクションを消去し、エラーを投げる
     * ロックされていなかったら、LF系の定数をリセットする
     */
    if($userModel->isAccountLock())
    {
      DbHandler::commit();//commit, rollbackどっちでもよし
      throw new InvalidErrorException(ExceptionCode::ACCOUNT_LOCKED);
    }

    /**
     * 作成されたUserModelクラスのpassword情報(=データベースのpassword)と、
     * POSTされたpassword情報を照合
     */
    if(!$userModel->checkPassword($post_password))
    {
      /**
       * パスワード認証失敗
       * アカウントのloginFailureCount,Datetimeを更新し、コミット->エラーを投げる
       */
      $userModel->loginFailure();
      DbHandler::commit();
      echo $userModel->getLoginFailureCount();
      throw new InvalidErrorException(ExceptionCode::LOGIN_FAILED);
    }

    /**
     * ログイン失敗回数、失敗日時のリセット
     */
    $userModel->loginFailureReset();

    /**
     * コミット
     */
    DbHandler::commit();

    /**
     * ログイン成功！
     * セッション変数に$userModelを保存する
     * 
     * 管理者アカウントでのログインを行う->admin.phpへ
     * そうでなければ一般アカウントとしてログイン->index.phpへ
     */
    session_start();
    $_SESSION['UserModel'] = serialize($userModel);

    if($userModel->getUserId === 9)
    {
      echo "logined as an admin.";
      header(sprintf("location: %s", "./admin.php"));
      return;
    } else {
      echo "login successed.";
      header(sprintf("location: %s", "./index.php"));
      return;
    }
  }


  /**
   * ログアウトを行うメソッド
   * セッションを破棄する
   * UserModelのログインコンディションをfalseに設定する
   * @return void
   */
  public static function logout()
  {
    $_SESSION = [];
    session_destroy();
    header(sprintf("location: %s", "./index.php"));
    return;
  }
}