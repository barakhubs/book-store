<?php
class Cart
{
    // DB Stuff
    private $conn;
    private $table = 'carts';

    // Properties
    public $id;
    public $book_id;
    public $user_id;
    public $quantity;
    public $book_title;
    public $book_author;
    public $book_cover;
    public $book_price;
    public $username;
    public $user_email;
    public $created_at;

    // Constructor with DB
    public function __construct($db)
    {
        $this->conn = $db;
    }

    // Get categories
    public function read()
    {
        // Create query
        $query = 'SELECT b.title as book_title, b.price as book_price, b.cover_image as book_cover, b.author as book_author, 
                         u.username as username, u.email as user_email, c.id, c.book_id, c.user_id, c.quantity, c.created_at
                                FROM ' . $this->table . ' c
                                LEFT JOIN
                                  books b ON c.book_id = b.id
                                LEFT JOIN
                                  users u ON c.user_id = u.id
                                ORDER BY
                                  c.created_at DESC';

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
        $query = 'SELECT b.title as book_title, b.price as book_price, b.cover_image as book_cover, b.author as book_author, 
                            u.username as username, u.email as user_email, c.id, c.book_id, c.user_id, c.quantity, c.created_at
                                FROM ' . $this->table . ' c
                                LEFT JOIN
                                    books b ON c.book_id = b.id
                                LEFT JOIN
                                    users u ON c.user_id = u.id
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
        $this->book_title = $row['book_title'];
        $this->book_cover = $row['book_cover'];
        $this->book_price = $row['book_price'];
        $this->quantity = $row['quantity'];
        $this->book_author = $row['book_author'];
        $this->user_id = $row['user_id'];
        $this->username = $row['username'];
        $this->user_email = $row['user_email'];
    }

    // Create Order
    public function create()
    {
        // Create Query
        $query = 'INSERT INTO ' .
            $this->table . '
        SET
            book_id = :book_id,
            user_id = :user_id,
            quantity = :quantity';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->book_id = htmlspecialchars(strip_tags($this->book_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));

        // Bind data
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':quantity', $this->quantity);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Update Order
    public function update()
    {
        // Create Query
        $query = 'UPDATE ' .
            $this->table . '
        SET
            book_id = :book_id,
            user_id = :user_id,
            quantity = :quantity
        WHERE
            id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->book_id = htmlspecialchars(strip_tags($this->book_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->quantity = htmlspecialchars(strip_tags($this->quantity));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':quantity', $this->quantity);
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }

    // Delete Order
    public function delete()
    {
        // Create query
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind Data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if ($stmt->execute()) {
            return true;
        }

        // Print error if something goes wrong
        printf("Error: %s.\n", $stmt->error);

        return false;
    }
}