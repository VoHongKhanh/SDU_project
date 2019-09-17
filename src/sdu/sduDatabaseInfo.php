<?php
class sduDatabaseInfo {
  private $dbName = "";

  private $con = NULL;
  private $sdu = NULL;
  private $tbList = NULL;

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
}
?>
