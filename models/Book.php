<?php

class Book
{
  // DB Stuff
  private $conn;
  private $table = 'books';

  // Properties
  public $id;
  public $title;
  public $cover_image;
  public $author;
  public $price;
  public $details;
  public $created_at;

  // Constructor with DB
  public function __construct($db)
  {
    $this->conn = $db;
  }

  // Get books
  public function read()
  {
    // Create query
    $query = 'SELECT
            id,
            title,
            cover_image,
            author,
            price,
            details,
            created_at
        FROM
            ' . $this->table . '
        ORDER BY
            created_at DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Execute query
    $stmt->execute();

    return $stmt;
  }

  // Get Single Order
  public function read_single()
  {
    // Create query
    $query = 'SELECT
            id,
            title,
            cover_image,
            author,
            price,
            details
        FROM
            ' . $this->table . '
        WHERE id = ?
        LIMIT 0,1';

    //Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind ID
    $stmt->bindParam(1, $this->id);

    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set properties
    $this->id = $row['id'];
    $this->title = $row['title'];
    $this->cover_image = $row['cover_image'];
    $this->price = $row['price'];
    $this->author = $row['author'];
    $this->details = $row['details'];
  }

  // Create Order
  public function create()
  {
    // Create Query
    $query = 'INSERT INTO ' .
      $this->table . '
            SET
            title = :title, 
            cover_image = :cover_image, 
            price = :price,
            author = :author,
            details = :details';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->price = htmlspecialchars(strip_tags($this->price));
    $this->cover_image = htmlspecialchars(strip_tags($this->cover_image));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->details = htmlspecialchars(strip_tags($this->details));

    // Bind data
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':cover_image', $this->cover_image);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':details', $this->details);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s\n", $stmt->errorInfo()[2]);

    return false;
  }

  // Update Order
  public function update()
  {
    // Create Query
    $query = 'UPDATE ' .
      $this->table . '
                SET
                title = :title, 
                cover_image = :cover_image, 
                price = :price,
                author = :author,
                details = :details
                WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->title = htmlspecialchars(strip_tags($this->title));
    $this->price = htmlspecialchars(strip_tags($this->price));
    $this->cover_image = htmlspecialchars(strip_tags($this->cover_image));
    $this->author = htmlspecialchars(strip_tags($this->author));
    $this->details = htmlspecialchars(strip_tags($this->details));

    // Bind data
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':title', $this->title);
    $stmt->bindParam(':price', $this->price);
    $stmt->bindParam(':cover_image', $this->cover_image);
    $stmt->bindParam(':author', $this->author);
    $stmt->bindParam(':details', $this->details);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s\n", $stmt->errorInfo()[2]);

    return false;
  }

  // Delete Order
  public function delete()
  {
    // Create query
    $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

    // Prepare Statement
    $stmt = $this->conn->prepare($query);

    // Clean data
    $this->id = htmlspecialchars(strip_tags($this->id));

    // Bind data
    $stmt->bindParam(':id', $this->id);

    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    // Print error if something goes wrong
    printf("Error: %s\n", $stmt->errorInfo()[2]);

    return false;
  }
}