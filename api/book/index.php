<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Book.php';

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
  if($num > 0) {
    // Book array
    $books_arr = array();
    // $books_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
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
