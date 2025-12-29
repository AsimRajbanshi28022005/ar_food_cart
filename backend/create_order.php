<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../database/config.php';

$response = [
    'success' => false,
    'message' => 'Unknown error',
];

// Basic input
$userId         = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$orderCode      = isset($_POST['order_code']) ? trim($_POST['order_code']) : '';
$address        = isset($_POST['address']) ? trim($_POST['address']) : '';
$pin            = isset($_POST['pin']) ? trim($_POST['pin']) : '';
$paymentMethod  = isset($_POST['payment_method']) ? trim($_POST['payment_method']) : '';
$upiId          = isset($_POST['upi_id']) ? trim($_POST['upi_id']) : null;
$totalAmount    = isset($_POST['total']) ? (float)$_POST['total'] : 0;
$itemsJson      = isset($_POST['items']) ? $_POST['items'] : '[]';

if ($userId <= 0) {
    $response['message'] = 'Invalid user ID.';
    echo json_encode($response);
    exit;
}

if ($orderCode === '') {
    $response['message'] = 'Invalid order code.';
    echo json_encode($response);
    exit;
}

if ($address === '' || $pin === '') {
    $response['message'] = 'Delivery address and PIN are required.';
    echo json_encode($response);
    exit;
}

$items = json_decode($itemsJson, true);
if (!is_array($items) || count($items) === 0) {
    $response['message'] = 'Order items are required.';
    echo json_encode($response);
    exit;
}

if ($totalAmount <= 0) {
    $response['message'] = 'Total amount must be greater than zero.';
    echo json_encode($response);
    exit;
}

// Insert into orders table
$stmt = $conn->prepare('INSERT INTO orders (order_code, user_id, address, pin, total_amount, payment_method, upi_id, status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())');
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$status = 'pending';
$stmt->bind_param('sissdsss', $orderCode, $userId, $address, $pin, $totalAmount, $paymentMethod, $upiId, $status);

if (!$stmt->execute()) {
    $stmt->close();
    $response['message'] = 'Failed to create order.';
    echo json_encode($response);
    exit;
}

$orderId = $stmt->insert_id;
$stmt->close();

// Insert items into order_items table
$itemStmt = $conn->prepare('INSERT INTO order_items (order_id, order_code, item_name, quantity, price) VALUES (?, ?, ?, ?, ?)');
if (!$itemStmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

foreach ($items as $it) {
    $name = isset($it['name']) ? $it['name'] : '';
    $qty  = isset($it['quantity']) ? (int)$it['quantity'] : 0;
    $price = isset($it['price']) ? (float)$it['price'] : 0;
    if ($name === '' || $qty <= 0 || $price <= 0) {
        continue;
    }
    // order_id (i), order_code (s), item_name (s), quantity (i), price (d)
    $itemStmt->bind_param('issid', $orderId, $orderCode, $name, $qty, $price);
    $itemStmt->execute();
}

$itemStmt->close();

$response['success'] = true;
$response['message'] = 'Order stored successfully.';
$response['order_id'] = $orderId;
echo json_encode($response);
exit;
