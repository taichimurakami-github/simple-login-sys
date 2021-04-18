<?php
namespace App\model;
require_once("UserModelBase.php");
require_once("../Handler/DbHandler.php");
use App\common\DbHandler;

class UserModel extends UserModelBase {

  public static $isLogined = false;

  /**
   * POSTされたemail文字列より、データベースからユーザー情報を取得
   * DbHandler::selectを使用する
   * 
   */
  public function getModelByEmail($post_email)
  {
    $sql = "SELECT * FROM user01 WHERE email=:email";
    $arr = array(
      ":email" => $post_email
    );
    $result = DbHandler::select($sql, $arr)[0];
    return is_null($result) ?
      false :
      $this->setPropertyAll($result);
  }

  public function getModelByUserId($userId)
  {
    $sql = "SELECT * FROM user01 WHERE userId=:userId";
    $arr = array(
      ":userId" => $userId
    );
    $result = DbHandler::select($sql, $arr)[0];
    return is_null($result) ?
      false :
      $this->setPropertyAll($result);
  }

  /**
   * パスワードの照合
   * 照合結果の成否をboolで返す
   * @param char $post_password
   * @return boolean
   */
  public function checkPassword($post_password)
  {
    return $this->_password === $post_password ? true : false;
  }

  /**
   * アカウント情報を一括でUserModelクラスのプロパティに指定
   * @param char $data
   * @return bool
   */
  public function setPropertyAll($data)
  {
    $this->setUserId($data['userId']);
    $this->setPassword($data['password']);
    $this->setUserName($data['userName']);
    $this->setEmail($data['email']);
    $this->setToken($data['token']);
    $this->setLoginFailureCount($data['loginFailureCount']);
    $this->setLoginFailureDatetime($data['loginFailureDatetime']);

    return true;
  }

  /**
   * ログイン失敗時に起動
   * loginFailureCountが一定数であれば、アカウントをロックする
   * そうでなければ、loginFailureCount, loginFailureDatetimeを更新・インクリメントする
   * @return void;
   */
  public function loginFailure(){

    $this->_loginFailureDatetime = new \DateTime();
    $this->_loginFailureCount++;

    //Dbと接続

    return;
  }

  /**
   * 
   */
  public function isAccountLock()
  {
    return false;
  }

  public function loginFailureReset()
  {
    return true;
  }

  public function setLoginCondition()
  {
    return self::$isLogined = true;
  }

  public function unsetLoginCondition()
  {
    return self::$isLogined = false;
  }
}