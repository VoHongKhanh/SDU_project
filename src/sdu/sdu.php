<?php
class sdu {
  private $host = "localhost";
  private $uid = "root";
  private $pwd = "";
  private $con = NULL;

  private $db = "";
  private $dbList = NULL;
  private $tbList = NULL;
  private $fdList = NULL;

  /**
   * Creates new connection to Database server
   * @param  string $host host name or ip [localhost]
   * @param  string $uid  username [root]
   * @param  string $pwd  password []
   * @exception  mysqli_sql_exception
   */
  public function __construct($host="localhost", $uid="root", $pwd="")  {
    try {
      $this->host = $host;
      $this->uid  = $uid;
      $this->pwd  = $pwd;
      $this->con = mysqli_connect($this->host, $this->uid, $this->pwd);
      mysqli_set_charset($this->con, "utf8");
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sdu.construct # '.$e->getMessage());
    }
  }

  /**
   * Closes current connection
   * @exception  mysqli_sql_exception
   */
  public function close() {
    try {
      mysqli_close($this->con);
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sdu.close # '.$e->getMessage());
    }
  }

  public function getDBList() {
    try {
      $this->dbList = [];
      $result = mysqli_query($this->con, "SHOW DATABASES");
      while($row = mysqli_fetch_array($result)) {
        $this->dbList[] = $row[0];
      }
      return $this->dbList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sdu.getDBList # '.$e->getMessage());
    }
  }

  public function setDB($db) {
    try {
      $this->db = $db;
      mysqli_select_db($this->con, $this->db);
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sdu.setDB # '.$e->getMessage());
    }
  }

  public function getTBList() {
    try {
      $this->tbList = [];
      $result = mysqli_query($this->con, "SHOW TABLES");
      while($row = mysqli_fetch_array($result)) {
        $this->tbList[] = $row[0];
      }
      return $this->tbList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sdu.getTBList # '.$e->getMessage());
    }
  }

  public function getFDList($tbName) {
    try {
      if ($this->fdList == NULL) $this->fdList = [];
      if (!isset($this->fdList[$tbName])) $this->fdList[$tbName] = [];

      $result = mysqli_query($this->con, "SELECT * FROM $tbName");
      while($fieldinfo = mysqli_fetch_field($result)) {
        $fdName = $fieldinfo->name;
        $this->fdList[$tbName][$fdName] = $fieldinfo;
      }
      return $this->fdList[$tbName];
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sdu.getFDList # '.$e->getMessage());
    }
  }
}
?>
