<?php
class sduDatabaseInfo {
  private $dbName    = "";
  private $con       = NULL;
  private $sdu       = NULL;
  private $tbList    = NULL;
  private $charset   = NULL;
  private $collation = NULL;

  /**
   * Creates new isntance of sduDatabaseInfo
   * @param sdu $sdu instance
   * @exception  mysqli_sql_exception
   */
  public function __construct($sdu, $dbName)  {
    try {
      $this->con = $sdu->getConnection();
      $this->sdu = $sdu;
      $this->dbName = $dbName;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.construct # '.$e->getMessage());
    }
  }

  /**
   * Gets list of table
   * @return ArrayList<string> list of table
   * @exception  mysqli_sql_exception
   */
  public function getTableList() {
    try {
      $this->sdu->selectDB($this->dbName);
      $this->tbList = $this->sdu->getTBList();
      return $this->tbList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduDatabaseInfo.getTableList # '.$e->getMessage());
    }
  }

  /**
   * Gets number of table
   * @return int number of table
   * @exception  mysqli_sql_exception
   */
  public function numberOfTable() {
    try {
      if ($this->tbList == NULL) $this->getTableList();
      return count($this->tbList);
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduDatabaseInfo.numberOfTable # '.$e->getMessage());
    }
  }

  public function getName() {
    return $this->dbName;
  }

  private function getDatabaseValue($fieldName) {
    $result = mysqli_query($this->con, "SELECT * FROM `information_schema`.`SCHEMATA` WHERE `SCHEMA_NAME`='".$this->dbName."'");
    if($row = mysqli_fetch_array($result)) {
      return $row[$fieldName];
    }
    return "";
  }


  public function getCharset() {
    if ($this->charset == NULL) {
      $this->charset = $this->getDatabaseValue("DEFAULT_CHARACTER_SET_NAME");
    }
    return $this->charset;
  }

  public function getCollation() {
    if ($this->collation == NULL) {
      $this->collation = $this->getDatabaseValue("DEFAULT_COLLATION_NAME");
    }
    return $this->collation;
  }
}
?>
