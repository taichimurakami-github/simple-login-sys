<?php
namespace App\common;
use App\model\UserModel,
    App\common\DbHandler;
// require("")

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
     */
    $userModel = new UserModel();
    $AccountData = DbHandler::select($post_email);

    //$post_emailをもとに、アカウント情報をデータベースから取り出し、UserModelクラスにセット
    if(!$userModel->setPropertyAll($AccountData)){
      throw new \Exception("Application Error");
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
    }
  }

  public static function logout()
  {

  }
}