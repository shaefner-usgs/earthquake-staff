<?php

/**
 * ESC Employee Collection
 *
 * @author Scott Haefner <shaefner@usgs.gov>
 */
class EmployeeCollection {
  public $employees;
  public $sortBy;

  public function __construct () {
    $this->employees = [];
    $this->sortBy = 'lastname'; // default value
  }

  /**
   * Add an employee to the Collection
   *
   * @param $employee {Object}
   */
  public function add ($Employee) {
    $this->employees[] = $Employee;
  }

  /**
   * Sort employees
   *
   * @param $sortBy {String <lastname | location>}
   */
  public function sort ($sortBy) {
    // array_multisort() requires an array of columns; put sort fields in columns
    foreach ($this->employees as $index => $Employee) {
      // Force sort fields to all lowercase to perform case-insensitive sort
      $firstname[$index] = strtolower($Employee->firstname);
      $lastname[$index] = strtolower($Employee->lastname);
      $location[$index] = strtolower($Employee->location);
    }

    if ($sortBy === 'lastname') {
      array_multisort($lastname, SORT_ASC, $firstname, SORT_ASC, $this->employees);
      $this->sortBy = $sortBy;
    } else if ($sortBy === 'location') {
      array_multisort($location, SORT_ASC, $lastname, SORT_ASC, $this->employees);
      $this->sortBy = $sortBy;
    }
  }
}
