<?php

include "config.php";

if ($_POST['singleData']) {
  $employee_id = $_POST['singleData'][0];
  $employee_name = $_POST['singleData'][1];
  $date = $_POST['singleData'][2];
  $working_status = $_POST['singleData'][3];

  $exist = $db->conn->query("SELECT * FROM `attendance` WHERE `employee_id`='$employee_id' AND `date`='$date';");

  if ($exist->num_rows > 0) {
    $db->conn->query("UPDATE `attendance` SET `date`='$date', `working_status`='$working_status' WHERE `employee_id`='$employee_id' AND date='$date';");
  } else {
    $db->conn->query("INSERT INTO `attendance`(`employee_id`, `date`, `working_status`) VALUES ('$employee_id','$date','$working_status');");
  }
}

if ($_POST['presentTableData'] || $_POST['absentTableData']) {
  $sql_queries = '';

  if ($_POST['presentTableData']) {
    foreach ($_POST['presentTableData'] as $data) {
      $employee_id = $data['employee_id'];
      $date = $data['date'];
      $working_status = $data['working_status'];
      $sql_queries .= "UPDATE `attendance` SET `date`='$date', `working_status`='$working_status' WHERE `employee_id`='$employee_id' AND date='$date';";
    }
  }

  if ($_POST['absentTableData']) {
    foreach ($_POST['absentTableData'] as $data) {
      if ($data['working_status'] == "1") {
        $employee_id = $data['employee_id'];
        $date = $data['date'];
        $working_status = $data['working_status'];
        $sql_queries .= "INSERT INTO `attendance`(`employee_id`, `date`, `working_status`) VALUES ('$employee_id','$date','$working_status');";
      }
    }
  }

  $db->conn->multi_query($sql_queries);
}

$db->conn->close();

header('Content-Type: application/json');
$res_return['response'] = true;
$res_return['data'] = "Success";

echo json_encode($res_return);