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

  public function getFullName ($lastFirst=false) {
    // Include nickname / middlename along with firstname if present
    $nick = '';
    if ($this->_data['nickname']) {
      $nick = ' (' . $this->_data['nickname'] . ')';
    }
    $firstName = $this->_data['firstname'] . $nick . ' ' . $this->_data['middlename'];

    if ($lastFirst) {
      $r = $this->_data['lastname'] . ', ' . $firstName;
    } else {
      $r = $firstName . ' ' . $this->_data['lastname'];
    }

    return $r;
  }
}
