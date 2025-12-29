<?php
// Login endpoint for AR Food
header('Content-Type: application/json');

require_once __DIR__ . '/../database/config.php';

$response = [
    'success' => false,
    'message' => 'Unknown error',
];

$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

if ($email === '' || $password === '') {
    $response['message'] = 'Email and password are required.';
    echo json_encode($response);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Invalid email address.';
    echo json_encode($response);
    exit;
}

$stmt = $conn->prepare('SELECT id, name, email, phone, address, pin, password_hash, registered_at FROM users WHERE email = ? LIMIT 1');
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Compare plain text password directly as requested
    if ($password === $row['password_hash']) {
        $response['success'] = true;
        $response['message'] = 'Login successful.';
        $response['user'] = [
            'id' => (int)$row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'address' => isset($row['address']) ? $row['address'] : null,
            'pin' => isset($row['pin']) ? $row['pin'] : null,
            'registered_at' => $row['registered_at'],
            'avatar' => null,
        ];
        echo json_encode($response);
        $stmt->close();
        exit;
    }
}

$stmt->close();
$response['message'] = 'Invalid email or password.';
echo json_encode($response);
exit;
