<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../database/config.php';

$response = [
    'success' => false,
    'message' => 'Unknown error',
    'orders' => [],
];

$userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
if ($userId <= 0) {
    $response['message'] = 'Invalid user ID.';
    echo json_encode($response);
    exit;
}

$hasCancelReason = false;
$colRes = $conn->query("SHOW COLUMNS FROM orders LIKE 'cancel_reason'");
if ($colRes && $colRes->num_rows > 0) {
    $hasCancelReason = true;
}

$hasCancelledBy = false;
$colRes2 = $conn->query("SHOW COLUMNS FROM orders LIKE 'cancelled_by'");
if ($colRes2 && $colRes2->num_rows > 0) {
    $hasCancelledBy = true;
}

$hasEtaMinutes = false;
$colRes3 = $conn->query("SHOW COLUMNS FROM orders LIKE 'delivery_eta_minutes'");
if ($colRes3 && $colRes3->num_rows > 0) {
    $hasEtaMinutes = true;
}

$hasEtaSetAt = false;
$colRes4 = $conn->query("SHOW COLUMNS FROM orders LIKE 'delivery_eta_set_at'");
if ($colRes4 && $colRes4->num_rows > 0) {
    $hasEtaSetAt = true;
}

// Fetch orders
$sqlOrders = 'SELECT id, order_code, user_id, total_amount, status, created_at'
    . ($hasCancelReason ? ', cancel_reason' : '')
    . ($hasCancelledBy ? ', cancelled_by' : '')
    . ($hasEtaMinutes ? ', delivery_eta_minutes' : '')
    . ($hasEtaSetAt ? ', delivery_eta_set_at' : '')
    . ' FROM orders WHERE user_id = ? ORDER BY id DESC LIMIT 200';
$stmt = $conn->prepare($sqlOrders);
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$stmt->bind_param('i', $userId);
$stmt->execute();
$res = $stmt->get_result();
$orders = [];
$orderIds = [];
while ($row = $res->fetch_assoc()) {
    $orders[] = $row;
    $orderIds[] = (int)$row['id'];
}
$stmt->close();

$itemsByOrderId = [];
if (count($orderIds) > 0) {
    $placeholders = implode(',', array_fill(0, count($orderIds), '?'));
    $types = str_repeat('i', count($orderIds));

    $sql = 'SELECT order_id, item_name, quantity, price FROM order_items WHERE order_id IN (' . $placeholders . ') ORDER BY id ASC';
    $itemStmt = $conn->prepare($sql);
    if ($itemStmt) {
        $params = [];
        $params[] = & $types;
        foreach ($orderIds as $k => $v) {
            $params[] = & $orderIds[$k];
        }
        call_user_func_array([$itemStmt, 'bind_param'], $params);

        $itemStmt->execute();
        $itemRes = $itemStmt->get_result();
        while ($it = $itemRes->fetch_assoc()) {
            $oid = (int)$it['order_id'];
            if (!isset($itemsByOrderId[$oid])) {
                $itemsByOrderId[$oid] = [];
            }
            $itemsByOrderId[$oid][] = [
                'name' => (string)$it['item_name'],
                'quantity' => (int)$it['quantity'],
                'price' => (float)$it['price'],
            ];
        }
        $itemStmt->close();
    }
}

// Map to frontend user-dashboard structure
$out = [];
foreach ($orders as $o) {
    $oid = (int)$o['id'];
    $out[] = [
        'id' => (string)$o['order_code'],
        'date' => (string)substr((string)$o['created_at'], 0, 10),
        'items' => isset($itemsByOrderId[$oid]) ? $itemsByOrderId[$oid] : [],
        'total' => (float)$o['total_amount'],
        'status' => (string)$o['status'],
        'cancel_reason' => $hasCancelReason ? (string)($o['cancel_reason'] ?? '') : '',
        'cancelled_by' => $hasCancelledBy ? (string)($o['cancelled_by'] ?? '') : '',
        'delivery_eta_minutes' => $hasEtaMinutes ? (int)($o['delivery_eta_minutes'] ?? 0) : 0,
        'delivery_eta_set_at' => $hasEtaSetAt ? (string)($o['delivery_eta_set_at'] ?? '') : '',
    ];
}

$response['success'] = true;
$response['message'] = 'OK';
$response['orders'] = $out;

echo json_encode($response);
exit;
