<?php

header("Access-Control-Allow-Origin:*");
header("Access-Control-Allow-Headers:*");
header("Content-Type: application/json");

require("../../vendor/autoload.php");
include_once '../../config/Database.php';
include_once '../../models/Book.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


$headers = getallheaders();
$authcode = trim($headers['Authorization']);
$token = substr($authcode, 7);
$key = "SECRET_KEY";

try {
    $decoded = JWT::decode($token, new Key($key, 'HS256'));
    // Instantiate DB & connect
    $database = new Database();
    $db = $database->connect();

    // Instantiate blog book object
    $book = new Book($db);

    // Blog book query
    $result = $book->read();
    // Get row count
    $num = $result->rowCount();

    // Check if any books
    if ($num > 0) {
        // Book array
        $books_arr = array();
        // $books_arr['data'] = array();

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
            // array_push($books_arr['data'], $book_item);
        }

        // Turn to JSON & output
        echo json_encode($books_arr);

    } else {
        // No Books
        echo json_encode(
            array('message' => 'No Books Found')
        );
    }

} catch (Exception $e) {
    $message = [
        "Status" => 400,
        'data' => $e->getMessage(),
        'message' => 'Access Denied'
    ];

    echo json_encode([
        "message" => $message
    ]);
}
