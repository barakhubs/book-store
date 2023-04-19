<?php

require __DIR__ . "/../vendor/autoload.php";

use \Firebase\JWT\JWT;
// use SimpleJWT\JWT;

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
            $issuedatClaim = time();
                $notbeforeClaim = $issuedatClaim + 10;
                $expireClaim = $issuedatClaim + 24 * 60 * 60 * 7;
                $tokenPayload = [
                    "iss" => 'http://localhost',
                    "iat" => $issuedatClaim,
                    "nbf" => $notbeforeClaim,
                    "exp" => $expireClaim,
                    "data" => [
                        "id" => $user['id'],
                        "email" => $user['email']
                    ]
                ];
    
                $token = JWT::encode($tokenPayload, 'SECRET_KEY', 'HS256');
    
                http_response_code(200);

                echo json_encode([
                    "message" => "Success",
                    "token" => $token,
                    "email" => $user['email'],
                    "username" => $user['username'],
                    "expireAt" => $expireClaim
                ]);
            // Password is correct, return true
            return true;
        }

        // Password is incorrect or user not found, return false
        return false;
    }
}