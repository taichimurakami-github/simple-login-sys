<?php
namespace App\common;

class DbHandler{
  /**
   * __PDO_SETTINGS__
   * const for login to MariaDB(Xampp 8.0.12) with using PDO methods.
   */
  const DSN = "mysql:dbname=%s;host=%s;charset=%s";

  /**
   * DSN内の情報格納定数群
   * データベースによって変更すること。
   */
  const DB_NAME = "project_login";
  const HOST = "localhost";
  const CHARSET = "utf8mb4";

  /**
   * PDOの第2~4引数群の$username, $password, $driver_optionsの定義
   */
  const PDO_USER_NAME = "root";
  const PDO_PASSWORD = "";
  const PDO_DRIVER_OPTIONS = array(
    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
    \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
    \PDO::ATTR_AUTOCOMMIT => true
  );

  /**
   * PDOインスタンス格納用定数 $PDOinstance
   */
  static private $PDOinstance = null;

  /**
   * その他データベース、テーブル関係の定数
   */
  const TBL_NAME = "user01";

  /**
   * コンストラクタ
   * @return obj $PDOinstance
   */
  public function __construct()
  {
    return self::getInstance();
  }

  /**
   * PDOインスタンスを返すメソッド。
   * @return obj self::$PDOinstance
   */
  private static function getInstance()
  {
    if(is_null(self::$PDOinstance)){

      /**
       * まだ生成されていなかったら、PDOインスタンスを生成し、返す。
       * 上記で定義した定数群を用いて引数の設定を行う。
       */
      try{
        return self::$PDOinstance = new \PDO(
          sprintf(self::DSN, self::DB_NAME, self::HOST, self::CHARSET),
          self::PDO_USER_NAME,
          self::PDO_PASSWORD,
          self::PDO_DRIVER_OPTIONS
        );
  
      } catch(\PDOException $e) {
        /**
         * PDOインスタンス生成失敗
         * SystemErrorExceptionを発生。
         * 処理を中断し、ログに記録ののち、管理者に連絡を送る
         */
         throw new \Exception("System Error Exception");
         exit($e->getMessage());
      }

    } else {
      return self::$PDOinstance;
    }
  }

  // protected $transactionCounter = 0;
  /**
   * トランザクション
   */
  // private function beginTransaction()
  // {
  //   if(!$this->transactionCounter++){
  //     return self::getInstance()::beginTransaction();
  //   }
  //   return $this->transactionCounter >= 0;
  // }

  // /**
  //  * コミット
  //  */
  // private function commit()
  // {
  //   if(!--$this->transactionCounter){
  //     return self::getInstance()::commit();
  //   }
    
  //   return $this->transactionCounter >= 0;
  // }

  // /**
  //  * ロールバック
  //  */
  // public function rollback()
  // {
  //   if($this->transactionCounter >= 0)
  //   {
  //     $this->transactionCounter = 0;
  //     return self::getInstance()::rollback();
  //   }
  
  //   $this->transactionCounter = 0;
  //   return false;
  // }

  /**
   * SELECT実行
   * @param string $sql
   * @param array $arr
   * @return array
   */
  public static function select($sql, $arr)
  {
    $stmt = self::getInstance()->prepare($sql);
    $stmt->execute($arr);
    return $stmt->fetchAll(\PDO::FETCH_ASSOC);
  }

  /**
   * INSERT実行
   * @param string $sql
   * @param array $arr
   * @return int
   */
  public static function insert($sql, $arr)
  {
    $stmt = self::getInstance()->prepare($sql);
    $stmt->execute($arr);
    return self::getInstance()->lastInsertId();
  }

  /**
   * UPDATE実行
   * @param string $sql
   * @param array $arr
   * @return bool
   */
  public static function update($sql, $arr)
  {
    $stmt = self::getInstance()->prepare($sql);
    return $stmt->execute($arr);
  }

  /**
   * DELETE実行
   * @param string $sql
   * @param array $arr
   * @return bool
   */
  public static function delete($sql, $arr)
  {
    $stmt = self::getInstance()->prepare($sql);
    return $stmt->execute($arr); 
  }
}