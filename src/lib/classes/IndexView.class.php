<?php

include_once '../conf/config.inc.php'; // app config

/**
 * Employee list view - creates HTML for index.php
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class IndexView {
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
    $sortBy = $this->_collection->sortBy;

    foreach ($this->_collection->employees as $employee) {
      if ($sortBy === 'name') {
        $set = $employee->getFirstLetter();
      } else if ($sortBy === 'location') {
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
          <td><a href="%s/%s/">%s</a></td><td>%s</td><td>%s</td>
        </tr>',
        $GLOBALS['CONFIG']['MOUNT_PATH'],
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
   * Create HTML for sort module
   *
   * @return $html {String}
   */
  private function _getSortModule () {
    $selected[$this->_collection->sortBy] = 'selected';

    $html = sprintf('<nav class="sort">
        <p>Sort by:</p>
        <ul class="no-style">
          <li><a class="%s" href="%s/name/">Last Name</a></li>
          <li><a class="%s" href="%s/location/">Location</a></li>
        </ul>
      </nav>',
      $selected['name'],
      $GLOBALS['CONFIG']['MOUNT_PATH'],
      $selected['location'],
      $GLOBALS['CONFIG']['MOUNT_PATH']
    );

    return $html;
  }

  /**
   * Render HTML
   */
  public function render () {
    $employeeList = $this->_getEmployeeList(); // populates $this->_sets[] used by _getJumpList

    print $this->_getSortModule();
    print $this->_getJumpList();
    print $employeeList;
  }
}
