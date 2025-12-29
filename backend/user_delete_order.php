<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../database/config.php';

$response = [
    'success' => false,
    'message' => 'Unknown error',
];

$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$orderCode = isset($_POST['order_code']) ? trim((string)$_POST['order_code']) : '';
$orderCodes = isset($_POST['order_codes']) ? $_POST['order_codes'] : null;

if ($userId <= 0) {
    $response['message'] = 'Invalid user ID.';
    echo json_encode($response);
    exit;
}

$codes = [];
if (is_array($orderCodes)) {
    foreach ($orderCodes as $c) {
        $c = trim((string)$c);
        if ($c !== '') {
            $codes[] = $c;
        }
    }
} elseif ($orderCode !== '') {
    $codes[] = $orderCode;
}

if (count($codes) === 0) {
    $response['message'] = 'Invalid order code.';
    echo json_encode($response);
    exit;
}

// Safety limit
if (count($codes) > 200) {
    $response['message'] = 'Too many orders selected.';
    echo json_encode($response);
    exit;
}

$placeholders = implode(',', array_fill(0, count($codes), '?'));
$types = 'i' . str_repeat('s', count($codes));

$sql = "DELETE FROM orders WHERE user_id = ? AND (status = 'delivered' OR status = 'cancelled') AND order_code IN ($placeholders)";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$params = [];
$params[] = & $types;
$params[] = & $userId;
foreach ($codes as $k => $v) {
    $params[] = & $codes[$k];
}
call_user_func_array([$stmt, 'bind_param'], $params);

$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

if ($affected <= 0) {
    $response['message'] = 'Unable to delete. Only delivered/cancelled orders can be deleted and must belong to this user.';
    echo json_encode($response);
    exit;
}

$response['success'] = true;
$response['message'] = 'Order deleted.';
$response['deleted_count'] = $affected;
echo json_encode($response);
exit;
