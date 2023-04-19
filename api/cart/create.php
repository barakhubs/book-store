<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers, Content-Type, Access-Control-Allow-Methods, Authorization,X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Cart.php';
require("../../vendor/autoload.php");

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

  // Instantiate blog post object
  $cart = new Cart($db);

  // Get raw posted data
  $data = json_decode(file_get_contents("php://input"));

  $cart->book_id = $data->book_id;
  $cart->user_id = $data->user_id;
  $cart->quantity = $data->quantity;

  // Create cart
  if ($cart->create()) {
    echo json_encode(
      array('message' => 'Cart Created')
    );
  } else {
    echo json_encode(
      array('message' => 'Cart Not Created')
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