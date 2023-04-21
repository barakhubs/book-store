<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

require("../../vendor/autoload.php");
include_once '../../config/Database.php';
include_once '../../models/Book.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate book object
$book = new Book($db);

// Book query
$result = $book->read();

// Get row count
$num = $result->rowCount();

// Check if any books
if ($num > 0) {
    // Book array
    $books_arr = array();

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        extract($row);

        $book_item = array(
            'id' => $id,
            'title' => $title,
            'price' => $price,
            'author' => $author,
            'cover_image' => $cover_image,
            'details' => $details
        );

        // Push to "data"
        array_push($books_arr, $book_item);
    }

    // Turn to JSON & output
    echo json_encode($books_arr);

} else {
    // No Books
    echo json_encode(
        array('message' => 'No Books Found')
    );
}

?>
