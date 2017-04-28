<?php

/**
 * Model for ESC Employee
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class Employee {
  private $_data;

  public function __construct () {
    $this->_data = [];
  }

  public function __get ($name) {
    return $this->_data[$name];
  }

  public function __set ($name, $value) {
    $this->_data[$name] = $value;
  }

  /**
   * Get HTML for address block
   *
   * @return $html {String}
   */
  public function getAddress () {
    $html = sprintf('
      <div class="vcard">
        <div class="adr">
          <div class="fn org">%s</div>
          <div class="street-address">%s %s</div>
          <span class="locality">%s</span>,
          <span class="region">%s</span>
          <span class="postal-code">%s</span>
        </div>
      </div>',
      $this->_data['institution'],
      $this->_data['address1'],
      $this->_data['address2'],
      $this->_data['city'],
      $this->_data['state'],
      $this->_data['zipcode']
    );

    return $html;
  }

  /**
   * Get first letter of employee's last name
   *
   * @return {String}
   */
  public function getFirstLetter () {
    return strtoupper(substr($this->_data['lastname'], 0, 1));
  }

  /**
   * Get full name of employee, including middle/nick-names
   *
   * @param $lastFirst {Boolean}
   *
   * @return $r {String}
   */
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
