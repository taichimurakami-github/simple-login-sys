<?php
namespace App\common;
require_once("../Models/UserModel.php");
use App\model\UserModel;
class LoginHandler {

  /**
   * メールアドレスとパスワードを照合し、ログイン操作を行う
   * @return void
   */
  public static function login()
  {
    if(!filter_input_array(INPUT_POST)){
      throw new \Exception("invalid error");
    }

    $post_password = filter_input(INPUT_POST, 'password');
    $post_email = filter_input(INPUT_POST, 'email');

    if($post_password == '' || $post_email == ''){
      throw new \Exception("invalid error");
      return;
    }

    /**
     * POSTされたemail情報をもとにユーザー情報を扱うUserModelクラスを作成する
     * データベースより各プロパティを取り出し、objにセット
     */
    $userModel = new UserModel();
    if(!$userModel->getModelByEmail($post_email)){
      throw new \Exception("Applicaton Error");
    }

    /**
     * 作成されたUserModelクラスのpassword情報(=データベースのpassword)と、
     * POSTされたpassword情報を照合
     */
    if(!$userModel->checkPassword($post_password)){
      //パスワード認証失敗
      //アカウントのloginFailureCount,Datetimeを更新
      $userModel->loginFailure();
      throw new \Exception("invalid Error");
    }

    /**
     * アカウントがロックされているかどうかを確認する
     */
    if($userModel->isAccountLock()){
      throw new \Exception("Application Error");
    } else {
      $userModel->loginFailureReset();
    }


    /**
     * ログイン成功
     * セッションにUserModelを保存
     * index.phpへ移動
     */
    session_start();
    $_SESSION['UserModel'] = serialize($userModel);
    header(sprintf("location: %s", "./index.php"));
    return;
  }

  /**
   * ログアウトを行うメソッド
   * 
   * セッションを破棄する
   * UserModelのログインコンディションをfalseに設定する
   * @return void
   */
  public static function logout()
  {
    session_destroy();
    header(sprintf("location: %s", "./index.php"));
    return;
  }
}