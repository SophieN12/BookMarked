<?php
require('../../../src/config.php');

$message =  "";

if (isset($_GET['userId'])) {
    $usersDbHandler -> deleteUser($_GET['userId']);
    $message = "You have succesfully deleted user with ID: " . $_GET['userId'];
    $status = true;

} else {
    $message = "Something went wrong! User did not get deleted from the database.";
    $status = false;
}

$data = [
    'status' => $status,
    'message' => $message
];

echo json_encode($data);
