<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../database/config.php';

$response = [
    'success' => false,
    'message' => 'Unknown error',
];

$userId  = isset($_POST['id']) ? (int)$_POST['id'] : 0;
$name    = isset($_POST['name']) ? trim($_POST['name']) : '';
$phone   = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$pin     = isset($_POST['pin']) ? trim($_POST['pin']) : '';

if ($userId <= 0) {
    $response['message'] = 'Invalid user ID.';
    echo json_encode($response);
    exit;
}

if ($name === '' && $phone === '' && $address === '' && $pin === '') {
    $response['message'] = 'No profile fields provided.';
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare('UPDATE users SET name = ?, phone = ?, address = ?, pin = ? WHERE id = ?');
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$stmt->bind_param('ssssi', $name, $phone, $address, $pin, $userId);

if ($stmt->execute()) {
    if ($stmt->affected_rows >= 0) {
        $response['success'] = true;
        $response['message'] = 'Profile updated successfully.';
        $response['user'] = [
            'id'      => $userId,
            'name'    => $name,
            'phone'   => $phone,
            'address' => $address,
            'pin'     => $pin,
        ];
    } else {
        $response['message'] = 'No changes were made to the profile.';
    }
    $stmt->close();
    echo json_encode($response);
    exit;
}

$stmt->close();
$response['message'] = 'Failed to update profile. Please try again.';
echo json_encode($response);
exit;
