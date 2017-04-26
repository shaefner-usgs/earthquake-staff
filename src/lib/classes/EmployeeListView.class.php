<?php

/**
 * Employees list view - creates HTML for index.php
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class EmployeeListView {
  private $_collection;
  private $_letters;

  public function __construct (EmployeeCollection $collection) {
    $this->_collection = $collection;
    $this->_letters = [];
  }

  /**
   * Create HTML for employee list
   */
  private function _getEmployeeList () {
    $firstLetterPrev = '';
    $html = '<table>';

    foreach ($this->_collection->employees as $employee) {
      $firstLetter = $employee->getFirstLetter();
      if ($firstLetterPrev !== $firstLetter) {
        $html .= sprintf('<tr id="%s"><th colspan="3">%s</th></tr>',
          $firstLetter,
          $firstLetter
        );
        $this->_letters[] = $firstLetter;
      }
      $firstLetterPrev = $firstLetter;

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
   */
  private function _getJumpList () {
    $html = '<ul>';

    foreach($this->_letters as $letter) {
      $html .= sprintf('<li><a href="#%s">%s</a></li>',
        $letter,
        $letter
      );
    }

    $html .= '</ul>';

    return $html;
  }

  public function render () {
    $employeeList = $this->_getEmployeeList(); // creates letters[] used by _getJumpList

    print $this->_getJumpList();
    print $employeeList;
  }
}
