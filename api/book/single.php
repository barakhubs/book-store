<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Book.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate book object
$book = new Book($db);

// Get ID
$book->id = isset($_GET['id']) ? $_GET['id'] : die();

// Get book
$book->read_single();

// Create array
$book_arr = array(
    'id' => $book->id,
    'title' => $book->title,
    'price' => $book->price,
    'author' => $book->author,
    'cover_image' => $book->cover_image,
    'details' => $book->details
);

// Convert to JSON
echo json_encode($book_arr);

?>
