<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');

  include_once '../../config/Database.php';
  include_once '../../models/Order.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog post object
  $order = new Order($db);

  // Get ID
  $order->id = isset($_GET['id']) ? $_GET['id'] : die();

  // Get post
  $order->read_single();

  // Create array
  $order_arr = array(
    'id' => $order->id,
    'status' => $order->status,
    'book_title' => $order->book_title,
    'book_author' => $order->book_author,
    'book_price' => $order->book_price,
    'book_cover' => $order->book_cover,
    'user_id'   => $order->user_id,
    'username'  => $order->username,
    'user_email' => $order->user_email,
    'book_id' => $order->book_id,
  );

  // Make JSON
  print_r(json_encode($order_arr));