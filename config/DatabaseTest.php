<?php
require __DIR__ . "/../vendor/autoload.php";
use PHPUnit\Framework\TestCase;
require "Database.php";
class DatabaseTest extends TestCase {
  private $db;

  protected function setUp(): void {
    // Create a new instance of the Database class before each test
    $this->db = new Database();
  }

  protected function tearDown(): void {
    // Set the Database instance to null after each test
    $this->db = null;
  }

  public function testConnectReturnsNonNullConnection() {
    // Call the connect method and assert that it returns a non-null value
    $conn = $this->db->connect();
    $this->assertNotNull($conn);
  }

  public function testConnectReturnsInstanceOfPDO() {
    // Call the connect method and assert that it returns an instance of PDO
    $conn = $this->db->connect();
    $this->assertInstanceOf(PDO::class, $conn);
  }

}
