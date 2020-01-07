<?php
class sduTableInfo {
  private $tbName    = "";
  private $dbName    = "";
  private $con       = NULL;
  private $sdu       = NULL;
  private $fdList    = NULL;
  private $pkList    = NULL;
  private $fkList    = NULL;
  private $ukList    = NULL;
  private $comment   = NULL;
  private $collation = NULL;
  private $engine    = NULL;

  /**
   * Creates new isntance of sduTableInfo
   * @param sdu $sdu instance
   * @exception  mysqli_sql_exception
   */
  public function __construct($sdu, $dbName, $tbName)  {
    try {
      $this->con = $sdu->getConnection();
      $this->sdu = $sdu;
      $this->tbName = $tbName;
      $this->dbName = $dbName;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.construct # '.$e->getMessage());
    }
  }

  /**
   * Gets list of field
   * @return ArrayList<string> list of field
   * @exception  mysqli_sql_exception
   */
  public function getFieldList() {
    try {
      $this->sdu->selectDB($this->dbName);
      $this->fdList = $this->sdu->getFDList($this->tbName);
      return $this->fdList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.getFieldList # '.$e->getMessage());
    }
  }

  /**
   * Gets number of field
   * @return int number of field
   * @exception  mysqli_sql_exception
   */
  public function numberOfField() {
    try {
      if ($this->fdList == NULL) $this->getFieldList();
      return count($this->fdList);
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.numberOfField # '.$e->getMessage());
    }
  }

  private function getFDInfo() {
    try {
      $this->pkList = [];
      $this->ukList = [];
      $this->fkList = [];

      $result = mysqli_query($this->con, "SELECT * FROM ".$this->tbName);
      while($fieldinfo = mysqli_fetch_field($result)) {
        $fdName = $fieldinfo->name;
        $fd = new sduFieldInfo($this->sdu, $this->dbName, $this->tbName, $fieldinfo);
        if ($fd->isPrimaryKey()) {
          $this->pkList[] = new sduFieldInfo($this->sdu, $this->dbName, $this->tbName, $fieldinfo);
        }
        if ($fd->isUniqueKey()) {
          $this->ukList[] = new sduFieldInfo($this->sdu, $this->dbName, $this->tbName, $fieldinfo);
        }
        if ($fd->isForeignKey()) {
          $this->fkList[] = new sduFieldInfo($this->sdu, $this->dbName, $this->tbName, $fieldinfo);
        }
      }
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.getFDInfo # '.$e->getMessage());
    }
  }

  public function getPKs() {
    try {
      if ($this->ukList == NULL && $this->pkList == NULL) $this->getFDInfo();
      return $this->pkList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.getPKs # '.$e->getMessage());
    }
  }

  public function getUKs() {
    try {
      if ($this->ukList == NULL && $this->pkList == NULL) $this->getFDInfo();
      return $this->ukList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.getUKs # '.$e->getMessage());
    }
  }

  public function getFKs() {
    try {
      if ($this->fkList == NULL) $this->getFDInfo();
      return $this->fkList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduTableInfo.getFKs # '.$e->getMessage());
    }
  }

  public function getName() {
    return $this->tbName;
  }

  private function getTableValue($fieldName) {
    $result = mysqli_query($this->con, "
    SELECT *
    FROM information_schema.tables
    WHERE table_schema = '".$this->dbName."' AND table_name = '".$this->tbName."'");
    if($row = mysqli_fetch_array($result)) {
      return $row[$fieldName];
    }
    return "";
  }

  public function getComment() {
    if ($this->comment == NULL) {
      $this->comment = $this->getTableValue("TABLE_COMMENT");
    }
    return $this->comment;
  }

  public function getCollation() {
    if ($this->collation == NULL) {
      $this->collation = $this->getTableValue("TABLE_COLLATION");
    }
    return $this->collation;
  }

  public function getEngine() {
    if ($this->engine == NULL) {
      $this->engine = $this->getTableValue("ENGINE");
    }
    return $this->engine;
  }
}
?>
