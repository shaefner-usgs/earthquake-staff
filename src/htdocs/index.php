<?php

include_once '../conf/config.inc.php'; // app config
include_once '../lib/_functions.inc.php'; // app functions
include_once '../lib/classes/Db.class.php'; // db connector, queries

include_once '../lib/classes/Employee.class.php'; // model
include_once '../lib/classes/EmployeeListView.class.php'; // view
include_once '../lib/classes/EmployeeCollection.class.php'; // collection

if (!isset($TEMPLATE)) {
  $TITLE = 'Earthquake Science Center Staff Directory';
  $HEAD = '<link rel="stylesheet" href="css/index.css" />';

  include 'template.inc.php';
}

// Query db
$Db = new Db();
$rsEmployees = $Db->queryMembers();

// Create Employee Collection
$EmployeeCollection = new EmployeeCollection();
$rsEmployees->setFetchMode(PDO::FETCH_CLASS, Employee);
$Employees = $rsEmployees->fetchAll();
foreach($Employees as $Employee) {
  $EmployeeCollection->add($Employee);
}

$View = new EmployeeListView($EmployeeCollection);
$View->render();

?>
