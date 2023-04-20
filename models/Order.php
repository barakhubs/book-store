<?php
class Order
{
    // DB Stuff
    private $conn;
    private $table = 'orders';

    // Properties
    public $id;
    public $status;
    public $book_id;
    public $user_id;
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

    // Get orders
     public function read($user)
{
    // Create query
    $query = 'SELECT b.title as book_title, b.price as book_price, b.cover_image as book_cover, b.author as book_author, 
                     u.username as username, u.email as user_email, c.id, c.book_id, c.user_id, c.status, c.created_at
                            FROM ' . $this->table . ' c
                            LEFT JOIN
                              books b ON c.book_id = b.id
                            LEFT JOIN
                              users u ON c.user_id = u.id
                            WHERE user_id = ?
                            ORDER BY
                              c.created_at DESC';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    $stmt->bindParam(1, $user);

    // Execute query
    $stmt->execute();

    return $stmt;
}
    // Get Single Order
    public function read_single()
    {
        // Create query
        $query = 'SELECT b.title as book_title, b.price as book_price, b.cover_image as book_cover, b.author as book_author, 
                u.username as username, u.email as user_email, o.id, o.book_id, o.user_id, o.status, o.created_at
                    FROM ' . $this->table . ' o
                    LEFT JOIN
                        books b ON o.book_id = b.id
                    LEFT JOIN
                        users u ON o.user_id = u.id
                    WHERE o.id = ?
                    LIMIT 0,1';

        // Prepare statement
        $stmt = $this->conn->prepare($query);

        // Bind ID
        $stmt->bindParam(1, $this->id);

        // Execute query
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // var_dump($row);
        // set properties
        $this->id = $row['id'];
        $this->book_title = $row['book_title'];
        $this->book_cover = $row['book_cover'];
        $this->book_price = $row['book_price'];
        $this->status = $row['status'];
        $this->book_author = $row['book_author'];
        $this->user_id = $row['user_id'];
        $this->username = $row['username'];
        $this->user_email = $row['user_email'];
        $this->book_id = $row['book_id'];

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
            status = :status';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->book_id = htmlspecialchars(strip_tags($this->book_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->status = htmlspecialchars(strip_tags($this->status));

        // Bind data
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':status', $this->status);

        // Execute query
        if ($stmt->execute()) {
            // delete all from cart
            $query = 'DELETE FROM carts WHERE book_id = :book_id AND user_id = :user_id';

            // Prepare Statement
            $stmt = $this->conn->prepare($query);

            // Bind Data
            $stmt->bindParam(':user_id', $this->user_id);
             $stmt->bindParam(':book_id', $this->book_id);

            // Execute query
            if ($stmt->execute()) {
                return true;
            }
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
        status = :status
      WHERE
        id = :id';

        // Prepare Statement
        $stmt = $this->conn->prepare($query);

        // Clean data
        $this->book_id = htmlspecialchars(strip_tags($this->book_id));
        $this->user_id = htmlspecialchars(strip_tags($this->user_id));
        $this->status = htmlspecialchars(strip_tags($this->status));
        $this->id = htmlspecialchars(strip_tags($this->id));

        // Bind data
        $stmt->bindParam(':book_id', $this->book_id);
        $stmt->bindParam(':user_id', $this->user_id);
        $stmt->bindParam(':status', $this->status);
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
        printf("Error: $s.\n", $stmt->error);

        return false;
    }
}