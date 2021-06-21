<?php
// Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '\xampp\htdocs\firstapi\config\Database.php';
include_once '\xampp\htdocs\firstapi\models\Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

// Get ID from URL 
$category->id = isset($_GET['id']) ?  $_GET['id'] : die();

// Get Post
$category->read_single();

// Create Array 
$category_arr = array(
    'id' => $category->id,
    'name' => $category->name,
    'created_at' => $category->created_at
);

// Encode Json
echo json_encode($category_arr);
