<?php

/**
 * Employees list view - creates HTML for index.php
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class EmployeeListView {
  private $_collection;
  private $_sets;

  public function __construct (EmployeeCollection $collection) {
    $this->_collection = $collection;
    $this->_sets = [];
  }

  /**
   * Create HTML for employee list
   *
   * @return $html {String}
   */
  private function _getEmployeeList () {
    $html = '<table>';
    $setPrev = '';
    $sortField = $this->_collection->sortField;

    foreach ($this->_collection->employees as $employee) {
      if ($sortField === 'lastname') {
        $set = $employee->getFirstLetter();
      } else if ($sortField === 'location') {
        $set = $employee->location;
      }

      if ($setPrev !== $set) {
        $html .= sprintf('<tr id="%s" class="header"><th colspan="3">%s</th></tr>',
          $set,
          $set
        );
        $this->_sets[] = $set;
      }
      $setPrev = $set;

      $html .= sprintf ('<tr>
          <td><a href="%s/">%s</a></td><td>%s</td><td>%s</td>
        </tr>',
        strstr($employee->email, '@', true),
        $employee->getFullName($lastFirst = true),
        $employee->email,
        $employee->phone
      );
    }

    $html .= '</table>';

    return $html;
  }

  /**
   * Create HTML for jump list
   *
   * @return $html {String}
   */
  private function _getJumpList () {
    $html = '<nav class="jumplist">';

    foreach($this->_sets as $set) {
      $html .= sprintf('<a href="#%s">%s</a>',
        $set,
        $set
      );
    }

    $html .= '</nav>';

    return $html;
  }

  /**
   * Render HTML
   */
  public function render () {
    $employeeList = $this->_getEmployeeList(); // creates $this->_sets[] used by _getJumpList

    print $this->_getJumpList();
    print $employeeList;
  }
}
