<?php

/**
 * ESC Employee Collection
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class EmployeeCollection {
  public $employees;

  public function __construct () {
    $this->employees = [];
  }

  /**
   * Add an employee to the Collection
   *
   * @param $employee {Object}
   */
  public function add ($employee) {
    $this->employees[] = $employee;
  }
}
