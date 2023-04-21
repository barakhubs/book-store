<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Book.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate book object
$book = new Book($db);

// Get raw posted data
$data = json_decode(file_get_contents("php://input"));

// Set ID to UPDATE
$book->id = $data->id;

$book->title = $data->title;
$book->author = $data->author;
$book->cover_image = $data->cover_image;
$book->price = $data->price;
$book->details = $data->details;

// Update book
if($book->update()) {
  echo json_encode(
    array('message' => 'Book Updated')
  );
} else {
  echo json_encode(
    array('message' => 'Book not updated')
  );
}

?>
