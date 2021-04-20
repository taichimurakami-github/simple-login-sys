<?php
namespace App\common;
use App\model\UserModel;
require_once("DbHandler.php");
require_once("LoginHandler.php");
require_once("../Models/UserModel.php");

class AccountHandler {

  public static function regist()
  {
    if(!filter_input_array(INPUT_POST)){
      throw new \Exception("invalid error");
    }

    $post_userName = filter_input(INPUT_POST, "userName");
    $post_email = filter_input(INPUT_POST, "email");
    $post_password = filter_input(INPUT_POST, "password");

    /**
     * DbHandler::insertを利用
     */
    $sql = sprintf("INSERT INTO %s(userName, email, password,) VALUES (:userName, :email, :password)" , DbHandler::TBL_NAME);
    $arr = array(
      ":userName" =>  $post_userName,
      ":email" => $post_email,
      ":password" => $post_password
    );
    return DbHandler::insert($sql, $arr);

    /**
     * アカウント登録成功
     * 自動的にログイン処理を行い、index.phpに飛ばす
     * 
     * ユーザーモデル作成
     * ->メールアドレスよりユーザー情報をモデルに登録
     * ->session変数にserialize化したモデルを保存
     */
    $userModel = new UserModel();
    $userModel->getModelByEmail($post_email);
    session_start();
    $_SESSION['UserModel'] = serialize($userModel);
    header(sprintf("location: %s", "index.php"));
    return true;
  }

  /**
   * アカウント情報のアップデート
   * 
   * POST経由で値を受け取る
   * ->入力値がなければ
   */
  public static function updateAccountInfo()
  {
    if(!filter_input_array(INPUT_POST)){
      header("location: index.php");
      return;
    }
    $USER = unserialize($_SESSION['UserModel']);
    if(strlen($_POST['email']) === 0){echo "!!!!!";}

    $post_userName = strlen($_POST['userName']) === 0 ? $USER->getUserName() : filter_input(INPUT_POST, 'userName');
    $post_email = strlen($_POST['email']) === 0 ? $USER->getEmail() : filter_input(INPUT_POST, 'email');
    $post_password = strlen($_POST['password']) === 0 ? $USER->getPassword() : filter_input(INPUT_POST, 'password');

    echo $post_userName.$post_email.$post_password;
    echo " len: ".strlen($_POST['userName']).strlen($_POST['email']).strlen($_POST['password']);
    $sql = sprintf("UPDATE %s SET userName=:userName, email=:email, password=:password WHERE userId=%s", DbHandler::TBL_NAME, $USER->getUserId());
    $arr = array(
      ':userName' => $post_userName,
      ':email' => $post_email,
      ':password' => $post_password
    );

    DbHandler::update($sql, $arr);
    $USER->getModelByUserId($USER->getUserId());
    $_SESSION['UserModel'] = serialize($USER);
    header("location: index.php");
    return;
  }

  /**
   * アカウント消去
   * ユーザーモデルを渡し、対象となるテーブル内のデータを消去する。
   * @param object $UserModel
   * @return array $r
   */
  public static function erace($target)
  {
    echo "erace";
    $UserModel = unserialize($target);
    
    /**
     * result用の配列を用意
     */
    $r = array(
      'userId' => $UserModel->getUserId(),
      'userName' => $UserModel->getUserName(),
      'sqlDeleteResult' => null
    );

    /**
     * DbHandler::delete()を用いて、$UserModel->getUserId()で得たIDと一致する対象を消去
     */
    $sql = sprintf("DELETE FROM %s WHERE userId = :userId", DbHandler::TBL_NAME);
    $arr = array(
      ':userId' => $UserModel->getUserId()
    );
    $r['sqlDeleteResult'] = DbHandler::delete($sql, $arr);

    /**
     * sessionを消去し、result配列を返す
     */
    return LoginHandler::logout();
  }
}