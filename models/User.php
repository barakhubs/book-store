<?php

require __DIR__ . "/../vendor/autoload.php";

use \Firebase\JWT\JWT;

class User
{
    private $conn; // PDO connection

    public $email;
    public $password;
    public $username;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function register()
    {
        // Hash the password
        $hashedPassword = password_hash($this->password, PASSWORD_DEFAULT);

        // Insert the user data into the database
        $stmt = $this->conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':password', $hashedPassword);

        try {
            $stmt->execute();
            return true; // Registration successful
        } catch (PDOException $e) {
            return false; // Registration failed
        }
    }

    public function login()
    {
        // Prepare the SQL statement
        $stmt = $this->conn->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->bindParam(':email', $this->email);
        $stmt->execute();

        // Fetch the user data from the database
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password if user is found
        if ($user && password_verify($this->password, $user['password'])) {

            $jwt_secret_key = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMj'; // Replace with your own secret key
            $jwt_algorithm = 'HS256'; // Choose the algorithm for signing the token

            $token_payload = array(
                'user_id' => $user['id'],
                'user_name' => $user['username'],
                'exp' => time() + (60 * 60) // Set the token expiration time (1 hour from current time)
            );

            // Step 5: Generate the JWT token
            $jwt_token = JWT::encode($token_payload, $jwt_secret_key, $jwt_algorithm);

            // Step 6: Return the JWT token to the client
            // You can send the token as a response to the client for further API requests
            echo json_encode(array('token' => $jwt_token));
            // Password is correct, return true
            return true;
        }

        // Password is incorrect or user not found, return false
        return false;
    }
}