<?php

include_once '../conf/config.inc.php'; // app config
include_once '../lib/_functions.inc.php'; // app functions
include_once '../lib/classes/Db.class.php'; // db connector, queries

include_once '../lib/classes/Employee.class.php'; // model
include_once '../lib/classes/EmployeeListView.class.php'; // view
include_once '../lib/classes/EmployeeCollection.class.php'; // collection

if (!isset($TEMPLATE)) {
  $TITLE = 'Earthquake Science Center Staff Directory';
  $HEAD = '<link rel="stylesheet" href="index.css" />';

  include 'template.inc.php';
}

// Query db
$db = new Db();
$rsEmployees = $db->queryMembers();

// Create Employee Collection
$employeeCollection = new employeeCollection();
$rsEmployees->setFetchMode(PDO::FETCH_CLASS, Employee);
$employees = $rsEmployees->fetchAll();
foreach($employees as $employee) {
  $employeeCollection->add($employee);
}

$view = new EmployeeListView($employeeCollection);
$view->render();

?>
