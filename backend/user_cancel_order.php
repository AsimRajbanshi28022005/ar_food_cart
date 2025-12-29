<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../database/config.php';

$response = [
    'success' => false,
    'message' => 'Unknown error',
];

$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$orderCode = isset($_POST['order_code']) ? trim((string)$_POST['order_code']) : '';
$reason = isset($_POST['cancel_reason']) ? trim((string)$_POST['cancel_reason']) : '';

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

if ($reason === '') {
    $response['message'] = 'Cancel reason is required.';
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

if (!$hasCancelReason || !$hasCancelledBy) {
    $response['message'] = 'Database schema missing cancel columns. Run ALTER TABLE to add cancel_reason and cancelled_by.';
    echo json_encode($response);
    exit;
}

// Only allow cancelling own order if not already delivered/cancelled
$stmt = $conn->prepare("UPDATE orders SET status = 'cancelled', cancel_reason = ?, cancelled_by = 'user' WHERE order_code = ? AND user_id = ? AND status <> 'delivered' AND status <> 'cancelled'");
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$stmt->bind_param('ssi', $reason, $orderCode, $userId);
$stmt->execute();
$affected = $stmt->affected_rows;
$stmt->close();

if ($affected <= 0) {
    $response['message'] = 'Unable to cancel. Order may already be delivered/cancelled or not belong to this user.';
    echo json_encode($response);
    exit;
}

$response['success'] = true;
$response['message'] = 'Order cancelled.';
echo json_encode($response);
exit;
