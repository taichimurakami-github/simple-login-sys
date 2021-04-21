<?php
namespace App\model;
require_once("UserModelBase.php");
require_once("../Handler/DbHandler.php");
use App\common\DbHandler;

class UserModel extends UserModelBase {

  const LF_ACCOUNT_LOCK = 3;

  public static $isLogined = false;

  /**
   * POSTされたemail文字列より、データベースからユーザー情報を取得
   * DbHandler::selectを使用する
   * @return bool
   */
  public function getModelByEmail($post_email)
  {
    $sql = "SELECT * FROM user01 WHERE email=:email";
    $arr = array(
      ":email" => $post_email
    );
    $result = DbHandler::select($sql, $arr)[0];

    return !is_null($result) ?
      $this->setPropertyAll($result) :  
      false ;
  }

  /**
   * 保持されているUserModel内のuserIdプロパティより、
   * ユーザーモデルを取得する
   * @return bool
   */
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
   * loginFailureCountが一定数であれば、アカウントのロックフラグを起動
   * そうでなければ、loginFailureCount, loginFailureDatetimeを更新・インクリメントする
   * @return void;
   */
  public function loginFailure(){
    $date = new \DateTime();
    $a = $this->getLoginFailureCount() + 1;
    echo "failureCount = ".$a."\n";
    $this->setLoginFailureCount($a);
    $this->setLoginFailureDatetime($date->format('Y-m-d H:i:s'));
    echo $this->getLoginFailureCount();
    //Dbと接続
    $sql = sprintf("UPDATE %s SET loginFailureCount=:LFCount, loginFailureDatetime=:LFDatetime WHERE userId=%s" , DbHandler::TBL_NAME, $this->getUserId() );
    $arr = array(
      ":LFCount" => $this->getLoginFailureCount(),
      ":LFDatetime" => $this->getLoginFailureDatetime()
    );

    DbHandler::update($sql, $arr);
    return;
  }

  /**
   * アカウントのロックを判断
   * UserModel::LF_ACCOUNT_LOCKを参照
   * @return boolean
   */
  public function isAccountLock()
  {
    return $this->getLoginFailureCount() > self::LF_ACCOUNT_LOCK ? true : false;
  }

  /**
   * loginFailureCount, loginFailureDatetimeをリセット
   * @return void
   */
  public function loginFailureReset()
  {
    //LFCount,LFDatetimeをリセット
    $this->setLoginFailureCount(0);
    $this->setLoginFailureDatetime(null);

    //Dbと接続
    $sql = sprintf("UPDATE %s SET loginFailureCount=:LFCount, loginFailureDatetime=:LFDatetime WHERE userId=%s" , DbHandler::TBL_NAME, $this->getUserId() );
    // $sql = sprintf("UPDATE %s SET (loginFailureCount, loginFailureDatetime) VALUES (:LFCount, :LFDatetime)" , DbHandler::TBL_NAME );
    $arr = array(
      ":LFCount" => $this->getLoginFailureCount(),
      ":LFDatetime" => $this->getLoginFailureDatetime()
    );

    DbHandler::update($sql, $arr);
    return;
  }
}