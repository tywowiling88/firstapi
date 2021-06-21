<?php
class Category
{
  // DB Stuff
  private $conn;
  private $table = 'categories';

  // Properties
  public $id;
  public $name;
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
    $query = 'SELECT
        id,
        name,
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

  public function read_single()
  {
    // Select Single
    $query = 'SELECT
        id,
        name,
        created_at
      FROM
        ' . $this->table . '
      WHERE 
        id = ?
      ORDER BY
        created_at DESC
      LIMIT 1';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Bind The Param id
    $stmt->bindParam(1, $this->id);
    // Execute query
    $stmt->execute();

    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // Set Properties 
    $this->name = $row['name'];
    $this->created_at = $row['created_at'];
  }

  public function insert()
  {
    // Insert Query 
    $query = 'INSERT INTO  ' . $this->table . '
        SET
          id = :id, 
          name = :name,
          created_at = :created_at
        ';

    // Prepare statement
    $stmt = $this->conn->prepare($query);

    // Validation Input 
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    // Bind data 
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':created_at', $this->created_at);
    // Execute query
    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s\n", $stmt->error);

    return false;
  }

  public function delete()
  {
    $query = 'DELETE FROM ' . $this->table . ' 
    WHERE id = :id';

    $stmt = $this->conn->prepare($query);

    // Input validation
    $this->id = htmlspecialchars(strip_tags($this->id));

    //Bind parameter or bind input
    $stmt->bindParam(':id', $this->id);

    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s\n", $stmt->error);

    return false;
  }

  public function update()
  {
    $query = 'UPDATE ' . $this->table . ' 
    SET 
      name = :name,
      created_at = :created_at
    WHERE 
      id = :id
    ';

    $stmt = $this->conn->prepare($query);

    $this->name = htmlspecialchars(strip_tags($this->name));
    $this->id = htmlspecialchars(strip_tags($this->id));
    $this->created_at = htmlspecialchars(strip_tags($this->created_at));

    //Bind parameter or bind input
    $stmt->bindParam(':id', $this->id);
    $stmt->bindParam(':name', $this->name);
    $stmt->bindParam(':created_at', $this->created_at);

    // Execute the query 
    if ($stmt->execute()) {
      return true;
    }

    printf("Error: %s\n", $stmt->error);
    return false;
  }
}
