<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
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

if ($category->delete()) {
    echo json_encode(
        array('message' => 'Post Deleted')
    );
} else {
    echo json_encode(
        array('message' => 'Something Went Wrong')
    );
}
