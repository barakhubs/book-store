<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Order.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog order object
  $order = new Order($db);

  // Blog order query
  $result = $order->read();
  // Get row count
  $num = $result->rowCount();

  // Check if any orders
  if($num > 0) {
    // Order array
    $orders_arr = array();
    // $orders_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $order_item = array(
        'id' => $id,
        'status' => $status,
        'book_title' => $book_title,
        'book_author' => $book_author,
        'book_price' => $book_price,
        'book_cover' => $book_cover,
        'user_id'   => $user_id,
        'username'  => $username,
        'user_email' => $user_email,
        'book_id' => $book_id,
      );

      // Push to "data"
      array_push($orders_arr, $order_item);
      // array_push($orders_arr['data'], $order_item);
    }

    // Turn to JSON & output
    echo json_encode($orders_arr);

  } else {
    // No Orders
    echo json_encode(
      array('message' => 'No Orders Found')
    );
  }
