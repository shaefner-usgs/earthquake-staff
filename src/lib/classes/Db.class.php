<?php

include_once '../lib/_functions.inc.php'; // app functions

/**
 * Database connector and queries for app
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class Db {
  private $db, $_pdo;

  public function __construct() {
    $this->_pdo = [
      'db' => $GLOBALS['DB_DSN'],
      'user' => $GLOBALS['DB_USER'],
      'pass' => $GLOBALS['DB_PASS']
    ];

    try {
      $this->db = new PDO($this->_pdo['db'], $this->_pdo['user'], $this->_pdo['pass']);
      $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
      print '<p class="alert error">ERROR 1: ' . $e->getMessage() . '</p>';
    }
  }

  /**
   * Perform db query
   *
   * @param $sql {String}
   *     SQL query
   * @param $params {Array} default is NULL
   *     key-value substitution params for SQL query
   *
   * @return $stmt {Object} - PDOStatement object
   */
  private function _execQuery ($sql, $params=NULL) {
    try {
      $stmt = $this->db->prepare($sql);

      // bind sql params
      if (is_array($params)) {
        foreach ($params as $key => $value) {
          $type = $this->_getType($value);
          $stmt->bindValue($key, $value, $type);
        }
      }
      $stmt->execute();

      return $stmt;
    } catch(Exception $e) {
      print '<p class="alert error">ERROR 2: ' . $e->getMessage() . '</p>';
    }
  }

  /**
   * Get data type for a sql parameter (PDO::PARAM_* constant)
   *
   * @param $var {?}
   *     variable to identify type of
   *
   * @return $type {Integer}
   */
  private function _getType ($var) {
    $varType = gettype($var);
    $pdoTypes = array(
      'boolean' => PDO::PARAM_BOOL,
      'integer' => PDO::PARAM_INT,
      'NULL' => PDO::PARAM_NULL,
      'string' => PDO::PARAM_STR
    );

    $type = $pdoTypes['string']; // default
    if (isset($pdoTypes[$varType])) {
      $type = $pdoTypes[$varType];
    }

    return $type;
  }

  /**
   * Get staff member(s)
   *
   * @param $shortname {String}
   *     Optional email shortname (text before '@') of employee to query
   */
  public function selectEmployees ($shortname=NULL) {
    $params = [];
    $joinClause = '';
    $whereClause = '';

    if ($shortname) {
      $params['shortname'] = "$shortname@%";
      $joinClause = 'LEFT JOIN esc_locations USING (location)';
      $whereClause .= 'WHERE `email` LIKE :shortname';
    }

    $sql = "SELECT * FROM esc_employees
      $joinClause
      $whereClause
      ORDER BY `lastname` ASC, `firstname` ASC";

    return $this->_execQuery($sql, $params);
  }
}
