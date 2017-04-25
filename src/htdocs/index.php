<?php

include_once '../conf/config.inc.php'; // app config
include_once '../lib/_functions.inc.php'; // app functions
include_once '../lib/classes/Db.class.php'; // db connector, queries

include_once '../lib/classes/Employee.class.php'; // model
include_once '../lib/classes/EmployeeListView.class.php'; // view
include_once '../lib/classes/EmployeeCollection.class.php'; // collection

if (!isset($TEMPLATE)) {
  $TITLE = '';
  $HEAD = '';
  $FOOT = '';

  include 'template.inc.php';
}

$db = new Db();
$employeeCollection = new employeeCollection();

// Db query result
$rsEmployees = $db->queryMembers();

// Create employee collection
$rsEmployees->setFetchMode(PDO::FETCH_CLASS, Employee);
$employees = $rsEmployees->fetchAll();
foreach($employees as $employee) {
  $employeeCollection->add($employee);
}

$view = new EmployeeListView($employeeCollection);

$view->render();

?>
