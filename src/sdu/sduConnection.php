<?php
mysqli_report(MYSQLI_REPORT_STRICT | MYSQLI_REPORT_ALL);

class sduConnection {
  private $type = "mysql";
  private $host = "localhost";
  private $uid = "root";
  private $pwd = "";
  private $con = NULL;

  /**
   * Creates new connection to Database server
   * @param  string $uid  username [root]
   * @param  string $pwd  password []
   * @param  string $host host name or ip [localhost]
   * @exception  mysqli_sql_exception
   */
  function sduConnection($uid="root", $pwd="", $host="localhost")  {
    try {
      $this->host = $host;
      $this->uid  = $uid;
      $this->pwd  = $pwd;
      $con = new mysqli($this->host, $this->uid, $this->pwd);
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnection.constructor # '.$e->getMessage());
    }
  }

  /**
   * Closes current connection
   * @exception  mysqli_sql_exception
   */
  public function close() {
    try {
      $thread = $con->thread_id;
      $con->kill($thread);
      $con->close();
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduConnection.close # '.$e->getMessage());
    }
  }
}
?>
