<?php
require('../../../src/config.php');

$message =  "";
$product = [];

if (isset($_GET['bookId'])) {
    // $book = $booksDbHandler -> fetchSpecificBook( $_GET['booksId']);
    $booksDbHandler -> deleteBook($_GET['bookId']);
    $message = "You have succesfully deleted product with ID: " . $_GET['bookId'];
    $status = true;

} else {
    $message = "Something went wrong! Product did not get deleted from the database.";
    $status = false;
}

$data = [
    'status' => $status,
    'message' => $message
];

echo json_encode($data);
