<?php

/**
 * Employee view
 * - creates the HTML for employee.php
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class EmployeeView {
  private $_model;

  public function __construct (Employee $model) {
    $this->_model = $model;
  }

  private function _getEmployee () {
    $html = '';

    $html .= $this->_model->email;

    return $html;
  }

  public function render () {
    print $this->_getEmployee();
  }
}
