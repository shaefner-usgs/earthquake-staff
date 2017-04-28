<?php

include_once '../conf/config.inc.php'; // app config
include_once '../lib/_functions.inc.php'; // app functions
include_once '../lib/classes/Db.class.php'; // db connector, queries

include_once '../lib/classes/Employee.class.php'; // model
include_once '../lib/classes/EmployeeView.class.php'; // view

if (!isset($TEMPLATE)) {
  $id = safeParam('id');

  // Query db
  $Db = new Db();
  $rsEmployee = $Db->queryMembers($id);

  // Create Employee
  if ($rsEmployee->rowCount() === 1) {
    $rsEmployee->setFetchMode(PDO::FETCH_CLASS, Employee);
    $Employee = $rsEmployee->fetch();
    $TITLE = $Employee->getFullName();
  } else {
    $error = '<p class="alert error">ERROR: Employee Not Found</p>';
    $TITLE = $id;
  }

  $TITLETAG = "$TITLE | Earthquake Science Center";
  $HEAD = '<link rel="stylesheet" href="employee.css" />';

  include 'template.inc.php';
}

if (isset($error)) {
  print $error;
  return;
}

$View = new EmployeeView($Employee);
$View->render();

?>
