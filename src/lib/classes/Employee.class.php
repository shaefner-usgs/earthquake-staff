<?php

/**
 * Model for ESC Employee
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class Employee {
  private $_data = [];

  public function __construct () {

  }

  public function __get ($name) {
    return $this->_data[$name];
  }

  public function __set ($name, $value) {
    $this->_data[$name] = $value;
  }

  public function getFirstLetter () {
    return strtoupper(substr($this->_data['lastname'], 0, 1));
  }
}
