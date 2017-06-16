<?php

include_once '../conf/config.inc.php'; // app config
include_once '../lib/_functions.inc.php'; // app functions
include_once '../lib/classes/Db.class.php'; // db connector, queries

include_once '../lib/classes/Employee.class.php'; // model
include_once '../lib/classes/IndexView.class.php'; // view
include_once '../lib/classes/EmployeeCollection.class.php'; // collection

if (!isset($TEMPLATE)) {
  $TITLE = 'Earthquake Science Center Staff Directory';
  $HEAD = '<link rel="stylesheet" href="' . $CONFIG['MOUNT_PATH'] . '/css/index.css" />';

  include 'template.inc.php';
}

$sortBy = safeParam('sortby', 'name');

// Query db
$Db = new Db();
$rsEmployees = $Db->selectEmployees();

// Create Employee Collection
$EmployeeCollection = new EmployeeCollection();
$rsEmployees->setFetchMode(PDO::FETCH_CLASS|PDO::FETCH_PROPS_LATE, Employee);
$Employees = $rsEmployees->fetchAll();
foreach($Employees as $Employee) {
  $EmployeeCollection->add($Employee);
}
$EmployeeCollection->sort($sortBy);

// Create and render view
$View = new IndexView($EmployeeCollection);
$View->render();
