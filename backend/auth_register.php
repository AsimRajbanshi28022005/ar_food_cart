<?php
// Registration endpoint for AR Food
header('Content-Type: application/json');

require_once __DIR__ . '/../database/config.php';

$response = [
    'success' => false,
    'message' => 'Unknown error',
];

$name = isset($_POST['name']) ? trim($_POST['name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$address = isset($_POST['address']) ? trim($_POST['address']) : '';
$pin = isset($_POST['pin']) ? trim($_POST['pin']) : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$confirmPassword = isset($_POST['confirmPassword']) ? $_POST['confirmPassword'] : '';

if ($password !== $confirmPassword) {
    $response['message'] = 'Passwords do not match.';
    echo json_encode($response);
    exit;
}

if ($name === '' || $email === '' || $phone === '' || $address === '' || $pin === '' || $password === '') {
    $response['message'] = 'All fields (name, email, phone, address, PIN, password) are required.';
    echo json_encode($response);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['message'] = 'Invalid email address.';
    echo json_encode($response);
    exit;
}

// Check if email already exists
$stmt = $conn->prepare('SELECT id FROM users WHERE email = ? LIMIT 1');
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    $response['message'] = 'Email already registered. Please use a different email or login.';
    echo json_encode($response);
    exit;
}

$stmt->close();

// Insert new user (storing password in plain text as requested)
$stmt = $conn->prepare('INSERT INTO users (name, email, phone, address, pin, password_hash) VALUES (?, ?, ?, ?, ?, ?)');
if (!$stmt) {
    $response['message'] = 'Database error.';
    echo json_encode($response);
    exit;
}

$stmt->bind_param('ssssss', $name, $email, $phone, $address, $pin, $password);

if ($stmt->execute()) {
    $userId = $stmt->insert_id;
    $stmt->close();

    $response['success'] = true;
    $response['message'] = 'Account created successfully! You can now login.';
    $response['user'] = [
        'id' => $userId,
        'name' => $name,
        'email' => $email,
        'phone' => $phone,
        'address' => $address,
        'pin' => $pin,
        'registered_at' => date('Y-m-d H:i:s'),
        'avatar' => null,
    ];
    echo json_encode($response);
    exit;
}

$stmt->close();
$response['message'] = 'Failed to create account. Please try again.';
echo json_encode($response);
exit;
