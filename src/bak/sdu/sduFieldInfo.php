<?php
class sduFieldInfo {
  private $con    = NULL;
  private $sdu    = NULL;
  private $dbName = NULL;
  private $tbName = NULL;

  private $name;
  private $table;
  private $length = NULL;
  private $flags;
  private $type = NULL;
  private $decimals;
  private $isFK    = NULL;
  private $refTb   = NULL;
  private $refPk   = NULL;
  private $refName = NULL;
  private $isNullAble = NULL;
  private $fullType   = NULL;
  private $charset    = NULL;
  private $collation  = NULL;
  private $default    = NULL;
  private $comment    = NULL;

  public function __construct($sdu, $dbName, $tbName, $fInfo)  {
    try {
      $this->con       = $sdu->getConnection();
      $this->sdu       = $sdu;
      $this->dbName    = $dbName;
      $this->tbName    = $tbName;
      $this->name      = $fInfo->name;
      $this->table     = $fInfo->table;
      $this->flags     = $fInfo->flags;
      $this->decimals  = $fInfo->decimals;
    } catch (mysqli_sql_exception $e) {
      throw new Exception('sduFieldInfo.construct # '.$e->getMessage());
    }
  }

  public function getName() {
    return $this->name;
  }

  public function getTable() {
    return $this->table;
  }

  public function getLength() {
    if ($this->length == NULL) {
      $this->getFullType();
      $this->length = "";

      $part1 = explode("(", $this->fullType);
      if (count($part1) >= 2) {
        $part2 = explode(")", $part1[1]);
        $this->length = $part2[0];
      }
    }
    return $this->length;
  }

  public function getType() {
    if ($this->type == NULL) {
      $this->type = $this->getFieldValue("DATA_TYPE");
    }
    return $this->type;
  }

  public function getDecimals() {
    return $this->decimals;
  }

  public function isPrimaryKey() {
    return $this->flags & MYSQLI_PRI_KEY_FLAG;
  }

  public function isUniqueKey() {
    return $this->flags & MYSQLI_UNIQUE_KEY_FLAG;
  }

  public function isUniqueField() {
    return ($this->flags & MYSQLI_UNIQUE_KEY_FLAG) ||
           ($this->flags & MYSQLI_PRI_KEY_FLAG);
  }

  public function isZeroFill() {
    return $this->flags & MYSQLI_ZEROFILL_FLAG;
  }

  public function isNOTNULL() {
    return $this->flags & MYSQLI_NOT_NULL_FLAG;
  }

  public function isDefaultNULL() {
    return $this->flags & MYSQLI_TYPE_NULL;
  }

  public function isTimestamp() {
    $this->getType();
    return ($this->type == "timestamp");
  }

  public function isInteger() {
    $this->getType();
    return ($this->type == "tinyint") ||
           ($this->type == "smallint") ||
           ($this->type == "mediumint") ||
           ($this->type == "int") ||
           ($this->type == "bigint") ||
           ($this->type == "bit");
  }

  public function isFloat() {
    $this->getType();
    return ($this->type == "float") ||
           ($this->type == "double") ||
           ($this->type == "decimal") ||
           ($this->type == "numeric");
  }

  public function isString() {
    $this->getType();
    return ($this->type == "char") ||
           ($this->type == "varchar") ||
           ($this->type == "text") ||
           ($this->type == "binary") ||
           ($this->type == "varbinary") ||
           ($this->type == "blob");
  }

  public function isDateTime() {
    $this->getType();
    return ($this->type == "datetime") ||
           ($this->type == "date") ||
           ($this->type == "timestamp") ||
           ($this->type == "time") ||
           ($this->type == "year");
  }

  private function getForeignKeyInfo() {
    if ($this->isFK == NULL) {
        $result = mysqli_query($this->con, "SHOW KEYS FROM `".$this->tbName."` WHERE Non_unique");

        while($row = mysqli_fetch_array($result)) {
          $fdName    = $row["Column_name"];
          $refTbName = $row["Table"];
          $refName   = $row["Key_name"];

          if ($this->name == $fdName) {
            $this->isFK    = true;
            $this->refTb   = $refTbName;
            $this->refPk   = $fdName;
            $this->refName = $refName;
            return;
          }
        }
        $this->isFK    = false;
        $this->refTb   = "";
        $this->refPk   = "";
        $this->refName = "";
    }
  }

  public function isForeignKey() {
    $this->getForeignKeyInfo();
    return $this->isFK;
  }

  public function getRefTable() {
    $this->getForeignKeyInfo();
    return $this->refTb;
  }

  public function getRefPK() {
    $this->getForeignKeyInfo();
    return $this->refPk;
  }

  public function getRefName() {
    $this->getForeignKeyInfo();
    return $this->refName;
  }

  private function getFieldValue($fieldName) {
    $result = mysqli_query($this->con, "
    SELECT *
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = '".$this->dbName."' AND
          TABLE_NAME   = '".$this->tbName."' AND
          COLUMN_NAME  = '".$this->name."'");
    if($row = mysqli_fetch_array($result)) {
      return $row[$fieldName];
    }
    return "";
  }

  public function isNullable() {
    if ($this->isNullAble == NULL) {
      $this->isNullAble = strtolower($this->getFieldValue("IS_NULLABLE")) == "yes";
    }
    return $this->isNullAble;
  }

  // private $comment    = NULL;

  public function getFullType() {
    if ($this->fullType == NULL) {
      $this->fullType = $this->getFieldValue("COLUMN_TYPE");
    }
    return $this->fullType;
  }

  public function getCharset() {
    if ($this->charset == NULL) {
      $this->charset = $this->getFieldValue("CHARACTER_SET_NAME");
    }
    return $this->charset;
  }

  public function getCollation() {
    if ($this->collation == NULL) {
      $this->collation = $this->getFieldValue("COLLATION_NAME");
    }
    return $this->collation;
  }

  public function isAutoIncrement() {
    return $this->flags & MYSQLI_AUTO_INCREMENT_FLAG;
  }

  public function getDefaultValue() {
    if ($this->default == NULL) {
      $this->default = $this->getFieldValue("COLUMN_DEFAULT");
    }
    return $this->default;
  }

  public function getComment() {
    if ($this->comment == NULL) {
      $this->comment = $this->getFieldValue("COLUMN_COMMENT");
    }
    return $this->comment;
  }
}
?>
