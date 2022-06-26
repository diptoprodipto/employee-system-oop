<?php
include 'config.php';
$db = new Database();

if ($_POST['emailId']) {
    $email = $_POST['emailId'];
    $deleted = $db->delete("DELETE FROM `employees` WHERE `email`='$email';");
    if ($deleted) {
        header('Content-Type: application/json');
        $response_data['response'] = true;
        $response_data['data'] = "Success";
        echo json_encode($response_data);
    }
} else {
    header('Content-Type: application/json');
    $response_data['response'] = false;
    $response_data['data'] = "Failed";
    echo json_encode($response_data);
}

