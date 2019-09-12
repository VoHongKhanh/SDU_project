<?php
class sduConnectionInfo {
  private $host = "";
  private $client = "";
  private $charset = "";

  private $con = NULL;

  /**
   * Creates new isntance of sduConnectionInfo
   * @param mysql_connection $con the exist mysql connection
   * @exception  mysqli_sql_exception
   */
  public function __construct($con)  {
    try {
      $this->con = $con;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.construct # '.$e->getMessage());
    }
  }

  /**
   * Gets host information
   * @return [type] [description]
   * @exception  mysqli_sql_exception
   */
  public function host() {
    try {
      if ($this->host == "") $this->host = mysqli_get_host_info ($this->con);
      return $this->host;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.host # '.$e->getMessage());
    }
  }

  /**
   * Gets server information
   * @return [type] [description]
   * @exception  mysqli_sql_exception
   */
  public function host() {
    try {
      if ($this->host == "") $this->host = mysqli_get_host_info ($this->con);
      return $this->host;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnectionInfo.host # '.$e->getMessage());
    }
  }
}
?>
