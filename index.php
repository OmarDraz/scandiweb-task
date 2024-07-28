<?php

require 'vendor/autoload.php';

use Omar\Scandiweb\Database;
use Omar\Scandiweb\ProductRepository;
use Omar\Scandiweb\ProductFactory;

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *'); // Allows all origins. You can restrict this to specific domains if needed.
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');


// Handle OPTIONS request for preflight CORS requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$database = new Database();
$db = $database->connect();

$productRepository = new ProductRepository($db);

$request_method = $_SERVER["REQUEST_METHOD"] ?? 'GET';
$path = isset($_SERVER['PATH_INFO']) ? explode('/', trim($_SERVER['PATH_INFO'], '/')) : [];


try {
    switch ($request_method) {
        case 'GET':
            if (isset($path[0]) && is_numeric($path[0])) {
                echo json_encode($productRepository->get($path[0]));
            } else {
                echo json_encode($productRepository->getAll());
            }
            break;
        case 'POST':
            $data = json_decode(file_get_contents("php://input"), true);
            $product = ProductFactory::createProduct($data);
            $productRepository->save($product);
            echo json_encode(['message' => 'Product added successfully']);
            break;
        case 'PUT':
            if (isset($path[0]) && is_numeric($path[0])) {
                $data = json_decode(file_get_contents("php://input"), true);
                $product = ProductFactory::createProduct($data);
                $productRepository->update($path[0], $product);
                echo json_encode(['message' => 'Product updated successfully']);
            }
            break;
        case 'DELETE':
            if (isset($path[0]) && is_numeric($path[0])) {
                $productRepository->delete($path[0]);
                echo json_encode(['message' => 'Product deleted successfully']);
            }
            break;
        default:
            header("HTTP/1.0 405 Method Not Allowed");
            break;
    }
} catch (\Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>
