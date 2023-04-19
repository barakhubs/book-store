<?php 
  // Headers
  header('Access-Control-Allow-Origin: *');
  header('Content-Type: application/json');
  header('Access-Control-Allow-Methods: PUT');
  header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

  include_once '../../config/Database.php';
  include_once '../../models/Cart.php';

  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog cart object
  $cart = new Cart($db);

  // Get raw carted data
  $data = json_decode(file_get_contents("php://input"));

  // Set ID to update
  $cart->id = $data->id;

  $cart->book_id = $data->book_id;
  $cart->user_id = $data->user_id;
  $cart->quantity = $data->quantity;

  // Update cart
  if($cart->update()) {
    echo json_encode(
      array('message' => 'Cart Updated')
    );
  } else {
    echo json_encode(
      array('message' => 'Cart Not Updated')
    );
  }

