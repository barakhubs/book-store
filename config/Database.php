<?php 
class Database {
  // DB Params
  private $host = 'db';
  private $db_name = 'book-store';
  private $username = 'book-user';
  private $password = 'password';
  private $conn;

  // DB Connect
  public function connect() {
    $this->conn = null;

    try { 
      // Attempt to create a new PDO instance for database connection
      $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch(PDOException $e) {
      // If connection fails, catch the exception and display an error message
      echo 'Connection Error: ' . $e->getMessage();
    }

    return $this->conn;
  }

}
