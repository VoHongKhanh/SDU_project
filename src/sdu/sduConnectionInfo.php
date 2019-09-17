<?php
class sduConnectionInfo {
  private $host_ = "";
  private $client_ = "";
  private $charset_ = "";

  private $con = NULL;
  private $sdu = NULL;
  private $dbList = NULL;

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
  public function host() {
    try {
      if ($this->host_ == "") $this->host_ = mysqli_get_host_info ($this->con);
      return $this->host_;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.host # '.$e->getMessage());
    }
  }

  /**
   * Gets client information
   * @return string client information
   * @exception  mysqli_sql_exception
   */
  public function client() {
    try {
      if ($this->client_ == "") $this->client_ = mysqli_get_client_info ($this->con);
      return $this->client_;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.client # '.$e->getMessage());
    }
  }

  /**
   * Gets charset of connection
   * @return string charset of connection
   * @exception  mysqli_sql_exception
   */
  public function charset() {
    try {
      if ($this->charset_ == "") $this->charset_ = mysqli_get_charset ($this->con);
      return $this->charset_;
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
