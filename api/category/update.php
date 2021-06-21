<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: PUT');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type, Access-Control-Allow-Methods');

include_once '\xampp\htdocs\firstapi\config\Database.php';
include_once '\xampp\htdocs\firstapi\models\Category.php';

// Instantiate DB & connect
$database = new Database();
$db = $database->connect();

// Instantiate category object
$category = new Category($db);

$data = json_decode(file_get_contents("php://input"));

$category->id = $data->id;
$category->name = $data->name;
$category->created_at = $data->created_at;

if ($category->update()) {
    echo json_encode(
        array('message' => 'Post Updated')
    );
} else {
    echo json_encode(
        array('message' => 'Something Went Wrong')
    );
}
