<?php
class sduConnectionInfo {
  private $host = "";
  private $client = "";
  private $charset = "";

  private $con = NULL;
  private $sdu = NULL;
  private $dbList = NULL;
  private $info = NULL;

  /**
   * Creates new isntance of sduConnectionInfo
   * @param sdu $sdu instance
   * @exception  mysqli_sql_exception
   */
  public function __construct($sdu)  {
    try {
      $this->con = $sdu->getConnection();
      $this->sdu = $sdu;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.construct # '.$e->getMessage());
    }
  }

  /**
   * Gets host information
   * @return string host information
   * @exception  mysqli_sql_exception
   */
  public function getHost() {
    try {
      if ($this->host == "") $this->host = mysqli_get_host_info ($this->con);
      return $this->host;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.host # '.$e->getMessage());
    }
  }

  /**
   * Gets client information
   * @return string client information
   * @exception  mysqli_sql_exception
   */
  public function getClient() {
    try {
      if ($this->client == "") $this->client = mysqli_get_client_info ($this->con);
      return $this->client;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.client # '.$e->getMessage());
    }
  }

  /**
   * Gets charset of connection
   * @return string charset of connection
   * @exception  mysqli_sql_exception
   */
  public function getCharset() {
    try {
      if ($this->info == "") $this->info = mysqli_get_charset ($this->con);
      return $this->info->charset;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.charset # '.$e->getMessage());
    }
  }

  public function getCollation() {
    try {
      if ($this->info == "") $this->info = mysqli_get_charset ($this->con);
      return $this->info->collation;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.charset # '.$e->getMessage());
    }
  }

  /**
   * Gets list of database
   * @return ArrayList<string> list of database
   * @exception  mysqli_sql_exception
   */
  public function getDatabaseList() {
    try {
      $this->dbList = $this->sdu->getDBList();
      return $this->dbList;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.getDatabaseList # '.$e->getMessage());
    }
  }

  /**
   * Gets number of database
   * @return int number of database
   * @exception  mysqli_sql_exception
   */
  public function numberOfDatabase() {
    try {
      if ($this->dbList == NULL) $this->getDatabaseList();
      return count($this->dbList);
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.numberOfDatabase # '.$e->getMessage());
    }
  }
}
?>
