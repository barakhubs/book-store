<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Order.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog order object
  $order = new Order($db);

  // Get raw ordered data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $order->id = $data->id;

  $order->book_id = $data->book_id;
  $order->user_id = $data->user_id;
  $order->status = $data->status;

  // Update order
  if($order->update()) {
    echo json_encode(
      array('message' => 'Order Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Order Not Updated')
    );
  }

