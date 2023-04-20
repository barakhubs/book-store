<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: GET');
// Allow specific HTTP headers (e.g. Content-Type, Authorization)
header("Access-Control-Allow-Headers: Content-Type, Authorization");


include_once '../../config/Database.php';
include_once '../../models/Cart.php';
require("../../vendor/autoload.php");

// use Firebase\JWT\JWT;
// use Firebase\JWT\Key;


// $headers = getallheaders();
// $authcode = trim($headers['Authorization']);
// $token = substr($authcode, 7);
// $key = "SECRET_KEY";

// try {
//   $decoded = JWT::decode($token, new Key($key, 'HS256'));
  // Instantiate DB & connect
  // Instantiate DB & connect
  $database = new Database();
  $db = $database->connect();

  // Instantiate blog cart object
  $cart = new Cart($db);

  // get user id
  $user_id = isset($_GET['user']) ? $_GET['user'] : die();
  // Blog cart query
  $result = $cart->read($user_id);
  // Get row count
  $num = $result->rowCount();
  

  // Check if any carts
  if($num > 0) {
    // Cart array
    $carts_arr = array();
    // $carts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)) {
      extract($row);

      $cart_item = array(
        'id' => $id,
        'book_title' => $book_title,
        'book_author' => $book_author,
        'book_price' => $book_price,
        'book_cover' => $book_cover,
        'quantity' => $quantity,
        'user_id'   => $user_id,
        'username'  => $username,
        'user_email' => $user_email,
        'book_id' => $book_id,
      );

      // Push to "data"
      array_push($carts_arr, $cart_item);
      // array_push($carts_arr['data'], $cart_item);
    }

    // Turn to JSON & output
    echo json_encode($carts_arr);

  } else {
    // No Carts
    echo json_encode(
      array('message' => 'No Carts Found')
    );
  }


// } catch (Exception $e) {
//   $message = [
//     "Status" => 400,
//     'data' => $e->getMessage(),
//     'message' => 'Access Denied'
//   ];

//   echo json_encode([
//     "message" => $message
//   ]);
// }