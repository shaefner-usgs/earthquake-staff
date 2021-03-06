<?php

include_once '../conf/config.inc.php'; // app config
include_once '../lib/_functions.inc.php'; // app functions
include_once '../lib/classes/Db.class.php'; // db connector, queries

include_once '../lib/classes/Employee.class.php'; // model
include_once '../lib/classes/EmployeeView.class.php'; // view

if (!isset($TEMPLATE)) {
  $shortname = safeParam('shortname');

  // Query db
  $Db = new Db();
  $rsEmployee = $Db->selectEmployees($shortname);

  // Create Employee
  if ($rsEmployee->rowCount() === 1) {
    $rsEmployee->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Employee);
    $Employee = $rsEmployee->fetch();
    $TITLE = $Employee->getFullName();
  } else {
    $error = '<p class="alert error">ERROR: Employee Not Found</p>';
    $TITLE = $id;
  }

  $TITLETAG = "$TITLE | Earthquake Science Center";
  $HEAD = '<link rel="stylesheet" href="../css/employee.css" />';

  include 'template.inc.php';
}

if (isset($error)) {
  print $error;
  return;
}

$View = new EmployeeView($Employee);
$View->render();
