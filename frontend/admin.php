<?php
session_start();

require_once __DIR__ . '/../database/config.php';

// Admin login lock settings
$MAX_ATTEMPTS = 4;
$LOCK_MINUTES = 60;

// Per-device key using a cookie (more stable than IP)
$deviceCookieName = 'arfood_admin_device';
if (!isset($_COOKIE[$deviceCookieName]) || !is_string($_COOKIE[$deviceCookieName]) || strlen($_COOKIE[$deviceCookieName]) < 16) {
    $newToken = bin2hex(random_bytes(16));
    setcookie($deviceCookieName, $newToken, time() + 60 * 60 * 24 * 365, '/');
    $_COOKIE[$deviceCookieName] = $newToken;
}

$deviceToken = (string)$_COOKIE[$deviceCookieName];
$deviceKey = hash('sha256', $deviceToken);

// Ensure attempt row exists
$attemptFailCount = 0;
$lockedUntil = null;
$now = new DateTime('now');

$stmt = $conn->prepare('SELECT fail_count, locked_until FROM admin_login_attempts WHERE device_key = ? LIMIT 1');
if ($stmt) {
    $stmt->bind_param('s', $deviceKey);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $attemptFailCount = (int)$row['fail_count'];
        $lockedUntil = $row['locked_until'] ? new DateTime($row['locked_until']) : null;
    } else {
        $ins = $conn->prepare('INSERT INTO admin_login_attempts (device_key, fail_count, locked_until, last_attempt_at) VALUES (?, 0, NULL, NOW())');
        if ($ins) {
            $ins->bind_param('s', $deviceKey);
            $ins->execute();
            $ins->close();
        }
    }
    $stmt->close();
}

$isLocked = ($lockedUntil instanceof DateTime) && ($lockedUntil > $now);

// Schema check for cancel reason support
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

$flash = '';
if (isset($_SESSION['admin_flash']) && is_string($_SESSION['admin_flash'])) {
    $flash = $_SESSION['admin_flash'];
    unset($_SESSION['admin_flash']);
}

if (isset($_GET['logout'])) {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
    header('Location: admin.php');
    exit;
}

$loginError = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'login') {
    $u = isset($_POST['username']) ? trim($_POST['username']) : '';
    $p = isset($_POST['password']) ? $_POST['password'] : '';

    // Reload lock state just in case
    $now = new DateTime('now');
    $isLocked = ($lockedUntil instanceof DateTime) && ($lockedUntil > $now);
    if ($isLocked) {
        $loginError = 'Too many attempts. This device is temporarily locked. Please try again later.';
    } else {
        $adminOk = false;
        $adminId = null;
        $adminUsername = null;

        if ($u !== '' && $p !== '') {
            $stmt = $conn->prepare('SELECT id, username, password, is_active FROM admins WHERE username = ? LIMIT 1');
            if ($stmt) {
                $stmt->bind_param('s', $u);
                $stmt->execute();
                $res = $stmt->get_result();
                if ($row = $res->fetch_assoc()) {
                    if ((int)$row['is_active'] === 1) {
                        $stored = (string)$row['password'];
                        // Support hashed or plain passwords
                        if (strpos($stored, '$2y$') === 0 || strpos($stored, '$2a$') === 0 || strpos($stored, '$2b$') === 0) {
                            $adminOk = password_verify($p, $stored);
                        } else {
                            $adminOk = hash_equals($stored, (string)$p);
                        }

                        if ($adminOk) {
                            $adminId = (int)$row['id'];
                            $adminUsername = (string)$row['username'];
                        }
                    }
                }
                $stmt->close();
            }
        }

        if ($adminOk) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_username'] = $adminUsername;
            $_SESSION['admin_id'] = $adminId;

            $reset = $conn->prepare('UPDATE admin_login_attempts SET fail_count = 0, locked_until = NULL, last_attempt_at = NOW(), last_username = ? WHERE device_key = ?');
            if ($reset) {
                $reset->bind_param('ss', $u, $deviceKey);
                $reset->execute();
                $reset->close();
            }

            header('Location: admin.php');
            exit;
        }

        // Failed login attempt
        $attemptFailCount = $attemptFailCount + 1;
        $newLockedUntil = null;
        if ($attemptFailCount >= $MAX_ATTEMPTS) {
            $newLockedUntil = (new DateTime('now'))->modify('+' . $LOCK_MINUTES . ' minutes');
            $isLocked = true;
            $lockedUntil = $newLockedUntil;
        }

        if ($newLockedUntil) {
            $lockedStr = $newLockedUntil->format('Y-m-d H:i:s');
            $upd = $conn->prepare('UPDATE admin_login_attempts SET fail_count = ?, locked_until = ?, last_attempt_at = NOW(), last_username = ? WHERE device_key = ?');
            if ($upd) {
                $upd->bind_param('isss', $attemptFailCount, $lockedStr, $u, $deviceKey);
                $upd->execute();
                $upd->close();
            }
            $loginError = 'Too many attempts. This device is locked for ' . $LOCK_MINUTES . ' minutes.';
        } else {
            $upd = $conn->prepare('UPDATE admin_login_attempts SET fail_count = ?, locked_until = NULL, last_attempt_at = NOW(), last_username = ? WHERE device_key = ?');
            if ($upd) {
                $upd->bind_param('iss', $attemptFailCount, $u, $deviceKey);
                $upd->execute();
                $upd->close();
            }
            $remaining = $MAX_ATTEMPTS - $attemptFailCount;
            $loginError = 'Invalid admin credentials. Attempts left: ' . $remaining;
        }
    }
}

$isAdmin = isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true;

if ($isAdmin && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update_order_status') {
    $orderId = isset($_POST['order_id']) ? (int)$_POST['order_id'] : 0;
    $newStatus = isset($_POST['new_status']) ? trim((string)$_POST['new_status']) : '';
    $cancelReason = isset($_POST['cancel_reason']) ? trim((string)$_POST['cancel_reason']) : '';
    $etaMinutesRaw = isset($_POST['eta_minutes']) ? trim((string)$_POST['eta_minutes']) : '';
    $allowed = ['pending', 'approved', 'shifted', 'delivered', 'cancelled'];

    if ($orderId > 0 && in_array(strtolower($newStatus), $allowed, true)) {
        // Read current status to enforce immutability after delivered
        $currentStatus = '';
        $chk = $conn->prepare('SELECT status FROM orders WHERE id = ? LIMIT 1');
        if ($chk) {
            $chk->bind_param('i', $orderId);
            $chk->execute();
            $r = $chk->get_result();
            if ($row = $r->fetch_assoc()) {
                $currentStatus = strtolower((string)$row['status']);
            }
            $chk->close();
        }

        $ns = strtolower($newStatus);

        if ($currentStatus === 'delivered' && $ns !== 'cancelled') {
            $_SESSION['admin_flash'] = 'Delivered orders cannot be changed. You can only cancel with a reason.';
            header('Location: admin.php');
            exit;
        }

        if ($ns === 'cancelled') {
            if (!$hasCancelReason || !$hasCancelledBy) {
                $_SESSION['admin_flash'] = 'Database schema missing cancel columns. Run: ALTER TABLE orders ADD COLUMN cancel_reason VARCHAR(255) NULL, ADD COLUMN cancelled_by VARCHAR(10) NULL;';
                header('Location: admin.php');
                exit;
            }
            if ($cancelReason === '') {
                $_SESSION['admin_flash'] = 'Cancel reason is required to cancel an order.';
                header('Location: admin.php');
                exit;
            }

            $stmt = $conn->prepare("UPDATE orders SET status = ?, cancel_reason = ?, cancelled_by = 'admin' WHERE id = ?");
            if ($stmt) {
                $stmt->bind_param('ssi', $ns, $cancelReason, $orderId);
                $stmt->execute();
                $stmt->close();
            }
            if ($hasEtaMinutes || $hasEtaSetAt) {
                if ($hasEtaMinutes && $hasEtaSetAt) {
                    $stmt = $conn->prepare("UPDATE orders SET delivery_eta_minutes = NULL, delivery_eta_set_at = NULL WHERE id = ?");
                } elseif ($hasEtaMinutes) {
                    $stmt = $conn->prepare("UPDATE orders SET delivery_eta_minutes = NULL WHERE id = ?");
                } else {
                    $stmt = $conn->prepare("UPDATE orders SET delivery_eta_set_at = NULL WHERE id = ?");
                }
                if ($stmt) {
                    $stmt->bind_param('i', $orderId);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        } elseif ($ns === 'shifted') {
            if (!$hasEtaMinutes || !$hasEtaSetAt) {
                $_SESSION['admin_flash'] = 'Database schema missing delivery ETA columns. Run: ALTER TABLE orders ADD COLUMN delivery_eta_minutes INT NULL, ADD COLUMN delivery_eta_set_at DATETIME NULL;';
                header('Location: admin.php');
                exit;
            }

            $etaMinutes = (int)$etaMinutesRaw;
            if ($etaMinutes <= 0) {
                $etaMinutes = 45;
            }
            if ($etaMinutes < 5) $etaMinutes = 5;
            if ($etaMinutes > 240) $etaMinutes = 240;

            $stmt = $conn->prepare('UPDATE orders SET status = ?, delivery_eta_minutes = ?, delivery_eta_set_at = NOW() WHERE id = ?');
            if ($stmt) {
                $stmt->bind_param('sii', $ns, $etaMinutes, $orderId);
                $stmt->execute();
                $stmt->close();
            }
        } else {
            if ($hasCancelReason || $hasCancelledBy) {
                if ($hasCancelReason && $hasCancelledBy) {
                    $stmt = $conn->prepare('UPDATE orders SET status = ?, cancel_reason = NULL, cancelled_by = NULL WHERE id = ?');
                } elseif ($hasCancelReason) {
                    $stmt = $conn->prepare('UPDATE orders SET status = ?, cancel_reason = NULL WHERE id = ?');
                } else {
                    $stmt = $conn->prepare('UPDATE orders SET status = ?, cancelled_by = NULL WHERE id = ?');
                }
                if ($stmt) {
                    $stmt->bind_param('si', $ns, $orderId);
                    $stmt->execute();
                    $stmt->close();
                }
            } else {
                $stmt = $conn->prepare('UPDATE orders SET status = ? WHERE id = ?');
                if ($stmt) {
                    $stmt->bind_param('si', $ns, $orderId);
                    $stmt->execute();
                    $stmt->close();
                }
            }

            if ($hasEtaMinutes || $hasEtaSetAt) {
                if ($hasEtaMinutes && $hasEtaSetAt) {
                    $stmt = $conn->prepare("UPDATE orders SET delivery_eta_minutes = NULL, delivery_eta_set_at = NULL WHERE id = ?");
                } elseif ($hasEtaMinutes) {
                    $stmt = $conn->prepare("UPDATE orders SET delivery_eta_minutes = NULL WHERE id = ?");
                } else {
                    $stmt = $conn->prepare("UPDATE orders SET delivery_eta_set_at = NULL WHERE id = ?");
                }
                if ($stmt) {
                    $stmt->bind_param('i', $orderId);
                    $stmt->execute();
                    $stmt->close();
                }
            }
        }
    }

    header('Location: admin.php');
    exit;
}

$users = [];
$orders = [];

if ($isAdmin) {
    $sqlOrders = "SELECT o.id, o.order_code, o.user_id, o.address, o.pin, o.total_amount, o.payment_method, o.upi_id, o.status, o.created_at,
        (SELECT COUNT(*) FROM order_items oi WHERE oi.order_id = o.id) AS items_count,
        u.name AS user_name, u.email AS user_email, u.phone AS user_phone"
        . ($hasCancelReason ? ", o.cancel_reason" : "")
        . ($hasCancelledBy ? ", o.cancelled_by" : "")
        . ($hasEtaMinutes ? ", o.delivery_eta_minutes" : "")
        . ($hasEtaSetAt ? ", o.delivery_eta_set_at" : "")
        . "
        FROM orders o
        LEFT JOIN users u ON u.id = o.user_id
        ORDER BY o.id DESC
        LIMIT 200";

    $resOrders = $conn->query($sqlOrders);
    if ($resOrders) {
        while ($row = $resOrders->fetch_assoc()) {
            $orders[] = $row;
        }
    }
}

function h($v) {
    return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8');
}

function badgeClass($status) {
    $s = strtolower((string)$status);
    if ($s === 'pending') return 'pending';
    if ($s === 'approved') return 'approved';
    if ($s === 'shifted') return 'shifted';
    if ($s === 'delivered') return 'delivered';
    if ($s === 'cancelled') return 'cancelled';
    return 'other';
}

$statsUsers = count($users);
$statsOrders = count($orders);
$statsRevenue = 0.0;
$statsDeliveredRevenue = 0.0;
$statsLoss = 0.0;
$statsPending = 0;
$statsApproved = 0;
$statsShifted = 0;
$statsDelivered = 0;
$statsCancelled = 0;
$statsCustomers = 0;
$seenCustomerIds = [];
foreach ($orders as $o) {
    $amt = (float)$o['total_amount'];
    $statsRevenue += $amt;
    $st = strtolower((string)$o['status']);
    if ($st === 'pending') $statsPending++;
    if ($st === 'approved') $statsApproved++;
    if ($st === 'shifted') $statsShifted++;
    if ($st === 'delivered') {
        $statsDelivered++;
        $statsDeliveredRevenue += $amt;
    }
    if ($st === 'cancelled') {
        $statsCancelled++;
        $statsLoss += $amt;
    }
    $cid = (string)$o['user_id'];
    if ($cid !== '' && !isset($seenCustomerIds[$cid])) {
        $seenCustomerIds[$cid] = true;
        $statsCustomers++;
    }
}

$statsApprovalTotal = $statsApproved + $statsShifted + $statsDelivered;
$statsAvgOrder = $statsOrders > 0 ? ($statsRevenue / $statsOrders) : 0.0;
$serverNow = (new DateTime('now'))->format('Y-m-d H:i:s');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
            background: #f3f4f6;
            color: #111827;
        }
        .app {
            min-height: 100vh;
        }
        .auth-page {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 22px;
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .auth-bg {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }
        .blob {
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            filter: blur(18px);
            opacity: 0.55;
            transform: translate3d(0,0,0);
            animation: floaty 10s ease-in-out infinite;
        }
        .blob.b1 {
            left: -160px;
            top: -160px;
            background: radial-gradient(circle at 30% 30%, rgba(255,107,107,0.95), rgba(254,202,87,0.15));
        }
        .blob.b2 {
            right: -180px;
            top: 12vh;
            background: radial-gradient(circle at 30% 30%, rgba(72,219,251,0.95), rgba(10,189,227,0.15));
            animation-duration: 12s;
        }
        .blob.b3 {
            left: 20vw;
            bottom: -220px;
            background: radial-gradient(circle at 30% 30%, rgba(255,159,243,0.9), rgba(243,104,224,0.15));
            animation-duration: 14s;
        }
        .spark {
            position: absolute;
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: rgba(255,255,255,0.25);
            box-shadow: 0 0 0 6px rgba(255,255,255,0.06);
            animation: rise 14s linear infinite;
        }
        .spark.s1 { left: 10%; top: 110%; animation-delay: 0s; }
        .spark.s2 { left: 28%; top: 120%; animation-delay: 2s; width: 8px; height: 8px; }
        .spark.s3 { left: 52%; top: 115%; animation-delay: 5s; width: 7px; height: 7px; }
        .spark.s4 { left: 72%; top: 130%; animation-delay: 7s; width: 9px; height: 9px; }
        .spark.s5 { left: 88%; top: 125%; animation-delay: 9s; width: 6px; height: 6px; }
        @keyframes rise {
            0% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            100% { transform: translateY(-140vh) translateX(40px); opacity: 0; }
        }
        @keyframes floaty {
            0%, 100% { transform: translateY(0px) translateX(0px) scale(1); }
            50% { transform: translateY(24px) translateX(16px) scale(1.04); }
        }
        header {
            background: linear-gradient(to right, #111827, #374151);
            color: #fff;
            padding: 16px 0;
            margin-bottom: 18px;
        }
        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .title { font-size: 1.2rem; font-weight: bold; }
        .muted { color: #6b7280; }
        .container { max-width: 1200px; margin: 0 auto; padding: 0 18px 30px 18px; }
        .card {
            background: #fff;
            border-radius: 16px;
            padding: 16px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }
        .auth-shell {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            z-index: 1;
        }
        .auth-card {
            width: 100%;
            max-width: 460px;
            padding: 28px;
            border-radius: 22px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.35);
            box-shadow: 0 25px 60px rgba(0,0,0,0.25);
            animation: popIn 700ms cubic-bezier(0.22, 1, 0.36, 1);
            position: relative;
            overflow: hidden;
        }
        .auth-card > * { position: relative; }
        .auth-card::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(900px 220px at 20% 0%, rgba(255,107,107,0.16), transparent 55%),
                        radial-gradient(700px 220px at 90% 10%, rgba(72,219,251,0.16), transparent 55%);
            pointer-events: none;
        }
        @keyframes popIn {
            from { transform: translateY(18px) scale(0.97); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 16px;
            position: relative;
        }
        .brand-badge {
            width: 46px;
            height: 46px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #ff6b6b, #feca57);
            box-shadow: 0 10px 25px rgba(255,107,107,0.35);
            animation: pulse 2.4s ease-in-out infinite;
            flex-shrink: 0;
        }
        .brand-badge svg { width: 26px; height: 26px; }
        @keyframes pulse {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-2px) scale(1.02); }
        }
        .brand-title {
            margin: 0;
            font-size: 1.6rem;
            letter-spacing: 0.2px;
        }
        .brand-sub {
            margin: 4px 0 0 0;
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.35;
        }
        .form {
            margin-top: 14px;
        }
        .form-grid {
            display: grid;
            gap: 14px;
        }
        .field {
            position: relative;
        }
        .field label {
            display: block;
            font-weight: 700;
            font-size: 0.88rem;
            color: #374151;
            margin: 0 0 8px 0;
            letter-spacing: 0.2px;
        }
        .field input {
            width: 100%;
            height: 50px;
            border-radius: 14px;
            border: 2px solid rgba(17,24,39,0.10);
            padding: 0 14px 0 44px;
            font-size: 1rem;
            color: #111827;
            background: rgba(255,255,255,0.92);
            outline: none;
            box-shadow: 0 10px 30px rgba(17,24,39,0.06);
            transition: border-color 180ms ease, box-shadow 180ms ease, transform 180ms ease;
        }
        .field input::placeholder { color: #9ca3af; }
        .field input:hover {
            border-color: rgba(17,24,39,0.18);
            transform: translateY(-1px);
        }
        .field input:focus {
            border-color: rgba(17,153,142,0.55);
            box-shadow: 0 0 0 5px rgba(17,153,142,0.18), 0 12px 35px rgba(17,24,39,0.08);
            transform: translateY(-1px);
        }
        .field-icon {
            position: absolute;
            left: 14px;
            top: 41px;
            transform: translateY(-50%);
            width: 18px;
            height: 18px;
            color: #6b7280;
            opacity: 0.9;
        }
        .pw-toggle {
            position: absolute;
            right: 12px;
            top: 41px;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 10px;
            border: 2px solid rgba(17,24,39,0.10);
            background: rgba(255,255,255,0.95);
            display: inline-flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: transform 160ms ease, background 160ms ease;
        }
        .pw-toggle:hover {
            transform: translateY(-50%) scale(1.03);
            background: rgba(255,255,255,1);
        }
        .pw-toggle svg { width: 18px; height: 18px; color: #374151; }
        .auth-actions {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
            margin-top: 18px;
            position: relative;
        }
        .btn.primary {
            background: linear-gradient(135deg, #111827, #374151);
            box-shadow: 0 10px 25px rgba(17,24,39,0.22);
            transition: transform 160ms ease, box-shadow 160ms ease;
        }
        .auth-page .btn.primary {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            box-shadow: 0 10px 25px rgba(17,153,142,0.30);
        }
        .auth-page .btn.primary {
            height: 52px;
            border-radius: 14px;
            font-size: 1.05rem;
            letter-spacing: 0.2px;
            position: relative;
            overflow: hidden;
        }
        .auth-page .btn.primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.25), transparent);
            transform: translateX(-120%);
        }
        .auth-page .btn.primary:hover::before {
            transform: translateX(120%);
            transition: transform 650ms ease;
        }
        .btn.primary.loading {
            opacity: 0.92;
            cursor: not-allowed;
        }
        .btn-content {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .spinner {
            width: 16px;
            height: 16px;
            border-radius: 50%;
            border: 2px solid rgba(255,255,255,0.35);
            border-top-color: rgba(255,255,255,1);
            animation: spin 0.9s linear infinite;
            display: none;
        }
        .btn.primary.loading .spinner { display: inline-block; }
        @keyframes spin { to { transform: rotate(360deg); } }
        .btn.primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 14px 30px rgba(17,24,39,0.28);
        }
        .btn.secondary {
            transition: transform 160ms ease, background 160ms ease;
        }
        .btn.secondary:hover {
            transform: translateY(-1px);
            background: #dbe1ea;
        }
        .auth-footer {
            margin-top: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 10px;
            position: relative;
        }
        .auth-footer a {
            color: #111827;
            text-decoration: none;
            font-weight: bold;
        }
        .auth-footer a:hover { text-decoration: underline; }
        .hint {
            margin-top: 12px;
            background: rgba(102,126,234,0.10);
            border: 1px solid rgba(102,126,234,0.18);
            color: #3730a3;
            border-radius: 12px;
            padding: 10px 12px;
            font-size: 0.92rem;
            position: relative;
        }
        .grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 900px) { .grid { grid-template-columns: 1fr; } }

        .btn {
            border: none;
            padding: 10px 14px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: bold;
        }
        .btn.primary { background: #111827; color: #fff; }
        .btn.secondary { background: #e5e7eb; color: #111827; }
        a.link { color: #111827; text-decoration: none; font-weight: bold; }
        a.link:hover { text-decoration: underline; }

        label { display: block; margin: 12px 0 6px 0; font-weight: bold; font-size: 0.9rem; }
        input {
            width: 100%;
            padding: 12px 12px;
            border-radius: 10px;
            border: 1px solid #d1d5db;
            outline: none;
            font-size: 1rem;
        }
        input:focus { border-color: #111827; box-shadow: 0 0 0 3px rgba(17,24,39,0.12); }

        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th, td { border-bottom: 1px solid #e5e7eb; padding: 8px; text-align: left; vertical-align: top; }
        th { background: #f9fafb; }

        .badge {
            display: inline-block;
            padding: 4px 10px;
            border-radius: 999px;
            font-size: 0.8rem;
            font-weight: bold;
        }
        .badge.pending { background: #fef3c7; color: #92400e; }
        .badge.delivered { background: #dcfce7; color: #166534; }
        .badge.other { background: #e5e7eb; color: #374151; }

        .msg {
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 0.95rem;
        }
        .msg.error { background: #fee2e2; color: #991b1b; }
        .msg.error {
            border: 1px solid rgba(220,38,38,0.20);
        }
        .shake {
            animation: shake 320ms ease-in-out;
        }
        @keyframes shake {
            0% { transform: translateX(0); }
            25% { transform: translateX(-6px); }
            50% { transform: translateX(6px); }
            75% { transform: translateX(-4px); }
            100% { transform: translateX(0); }
        }

        .dash {
            min-height: 100vh;
            background:
                radial-gradient(900px 420px at 20% 10%, rgba(17,153,142,0.16), transparent 55%),
                radial-gradient(900px 420px at 80% 20%, rgba(102,126,234,0.14), transparent 55%),
                linear-gradient(180deg, #0b1220 0%, #0f172a 55%, #0b1220 100%);
            color: #e5e7eb;
        }
        .topbar {
            position: sticky;
            top: 0;
            z-index: 10;
            border-bottom: 1px solid rgba(255,255,255,0.10);
            background: rgba(15, 23, 42, 0.72);
            backdrop-filter: blur(16px);
        }
        .topbar-inner {
            max-width: 1200px;
            margin: 0 auto;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .brandline {
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .brandmark {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(56,239,125,1), rgba(17,153,142,1));
            box-shadow: 0 18px 40px rgba(17,153,142,0.28);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .brandmark svg { width: 22px; height: 22px; color: #0b1220; }
        .dash-title {
            margin: 0;
            font-size: 1.05rem;
            letter-spacing: 0.2px;
            font-weight: 800;
        }
        .dash-sub {
            margin: 2px 0 0 0;
            color: rgba(229,231,235,0.70);
            font-size: 0.9rem;
        }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 8px 12px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.14);
            background: rgba(255,255,255,0.06);
            color: rgba(229,231,235,0.85);
            font-weight: 700;
            font-size: 0.86rem;
            white-space: nowrap;
        }
        .chip svg { width: 16px; height: 16px; opacity: 0.9; }
        .dash-actions { display: flex; gap: 10px; align-items: center; }
        .dash-actions a {
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 42px;
            padding: 0 14px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.06);
            color: #e5e7eb;
            font-weight: 800;
            transition: transform 160ms ease, background 160ms ease, border-color 160ms ease;
        }
        .dash-actions a:hover { transform: translateY(-1px); background: rgba(255,255,255,0.09); border-color: rgba(255,255,255,0.16); }
        .dash-actions a.primary {
            background: linear-gradient(135deg, #38ef7d, #11998e);
            border-color: transparent;
            color: #06131e;
        }
        .dash-actions a.primary:hover { background: linear-gradient(135deg, #46ff88, #11b7a7); }
        .dash-container { max-width: 1200px; margin: 0 auto; padding: 18px 18px 42px 18px; }
        .stats {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 14px;
            margin: 8px 0 18px 0;
        }
        @media (max-width: 1100px) { .stats { grid-template-columns: repeat(3, 1fr); } }
        @media (max-width: 620px) { .stats { grid-template-columns: 1fr; } }
        .stat {
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.06);
            box-shadow: 0 18px 50px rgba(0,0,0,0.28);
            padding: 14px 14px;
            overflow: hidden;
            position: relative;
        }
        .stat::before {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(500px 160px at 20% 0%, rgba(56,239,125,0.18), transparent 58%),
                        radial-gradient(500px 160px at 90% 10%, rgba(102,126,234,0.14), transparent 58%);
            pointer-events: none;
        }
        .stat > * { position: relative; }
        .stat-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .stat-label { color: rgba(229,231,235,0.74); font-weight: 800; font-size: 0.9rem; }
        .stat-value { margin-top: 10px; font-size: 1.55rem; font-weight: 900; letter-spacing: 0.2px; }
        .stat-foot { margin-top: 8px; color: rgba(229,231,235,0.60); font-size: 0.86rem; }
        .stat-ico {
            width: 42px;
            height: 42px;
            border-radius: 14px;
            background: rgba(255,255,255,0.08);
            border: 1px solid rgba(255,255,255,0.12);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .stat-ico svg { width: 20px; height: 20px; color: rgba(229,231,235,0.92); }
        .panel-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        @media (max-width: 900px) { .panel-grid { grid-template-columns: 1fr; } }
        .panel {
            border-radius: 18px;
            border: 1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.05);
            box-shadow: 0 18px 55px rgba(0,0,0,0.32);
            overflow: hidden;
        }
        .panel-head {
            padding: 14px 14px;
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid rgba(255,255,255,0.10);
            background: rgba(255,255,255,0.04);
        }
        .panel-title { margin: 0; font-size: 1.05rem; font-weight: 900; }
        .panel-sub { margin-top: 4px; color: rgba(229,231,235,0.70); font-size: 0.9rem; }
        .panel-tools { display: flex; gap: 10px; align-items: center; }
        .search {
            height: 40px;
            min-width: 220px;
            border-radius: 14px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(15, 23, 42, 0.55);
            color: #e5e7eb;
            padding: 0 12px;
            outline: none;
        }
        .search::placeholder { color: rgba(229,231,235,0.52); }
        .search:focus { border-color: rgba(56,239,125,0.55); box-shadow: 0 0 0 4px rgba(56,239,125,0.14); }
        .panel-body { padding: 0; }
        .table-wrap { overflow: auto; max-height: 520px; }
        .dash table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        .dash th, .dash td {
            border-bottom: 1px solid rgba(255,255,255,0.08);
            padding: 10px 12px;
            text-align: left;
            vertical-align: top;
        }
        .dash thead th {
            position: sticky;
            top: 0;
            background: rgba(15, 23, 42, 0.92);
            backdrop-filter: blur(10px);
            z-index: 2;
            font-size: 0.85rem;
            letter-spacing: 0.25px;
            text-transform: uppercase;
            color: rgba(229,231,235,0.78);
        }
        .dash tbody tr { transition: background 160ms ease; }
        .dash tbody tr:hover { background: rgba(255,255,255,0.06); }
        .dash .badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 900;
            font-size: 0.78rem;
            letter-spacing: 0.25px;
            text-transform: uppercase;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(255,255,255,0.06);
        }
        .dash .badge.pending { background: rgba(245, 158, 11, 0.16); border-color: rgba(245, 158, 11, 0.25); color: #fde68a; }
        .dash .badge.approved { background: rgba(56, 189, 248, 0.14); border-color: rgba(56, 189, 248, 0.25); color: #bae6fd; }
        .dash .badge.shifted { background: rgba(99, 102, 241, 0.14); border-color: rgba(99, 102, 241, 0.25); color: #c7d2fe; }
        .dash .badge.delivered { background: rgba(34, 197, 94, 0.14); border-color: rgba(34, 197, 94, 0.25); color: #bbf7d0; }
        .dash .badge.cancelled { background: rgba(239, 68, 68, 0.14); border-color: rgba(239, 68, 68, 0.25); color: #fecaca; }
        .dash .badge.other { background: rgba(148, 163, 184, 0.10); border-color: rgba(148, 163, 184, 0.18); color: rgba(229,231,235,0.86); }

        .dash select,
        .dash input[type="text"] {
            font-family: inherit;
        }
        .dash td form button {
            transition: transform 160ms ease, background 160ms ease, border-color 160ms ease;
        }
        .dash td form button:hover {
            transform: translateY(-1px);
            background: rgba(255,255,255,0.12);
            border-color: rgba(255,255,255,0.20);
        }
        .dash td form button:active {
            transform: translateY(0px);
        }

        @media (max-width: 720px) {
            .topbar-inner {
                flex-direction: column;
                align-items: stretch;
            }
            .dash-actions {
                width: 100%;
                flex-wrap: wrap;
                justify-content: flex-start;
            }
            .dash-actions a { flex: 1; min-width: 140px; }
            .dash-container { padding: 14px 12px 34px 12px; }
            .panel-head {
                flex-direction: column;
                align-items: stretch;
            }
            .panel-tools { width: 100%; }
            .search { width: 100%; min-width: 0; }
            .table-wrap { max-height: none; }

            /* table -> card */
            .dash table { display: block; }
            .dash thead { display: none; }
            .dash tbody { display: block; }
            .dash tbody tr {
                display: block;
                margin: 12px;
                border-radius: 16px;
                border: 1px solid rgba(255,255,255,0.10);
                background: rgba(255,255,255,0.05);
                overflow: hidden;
            }
            .dash tbody tr:hover { background: rgba(255,255,255,0.07); }
            .dash td {
                display: flex;
                align-items: flex-start;
                justify-content: space-between;
                gap: 12px;
                padding: 12px 12px;
                border-bottom: 1px solid rgba(255,255,255,0.08);
            }
            .dash td:last-child { border-bottom: none; }
            .dash td::before {
                content: attr(data-label);
                color: rgba(229,231,235,0.62);
                font-weight: 900;
                font-size: 0.78rem;
                text-transform: uppercase;
                letter-spacing: 0.25px;
                flex: 0 0 34%;
            }
            .dash td > * { max-width: 66%; }
            .dash td form {
                justify-content: flex-end;
            }
            .dash td form select,
            .dash td form button {
                width: 100%;
            }
        }

        .cancel-reason {
            display: none;
            width: 260px;
            height: 40px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(15, 23, 42, 0.55);
            color: #e5e7eb;
            padding: 0 10px;
            outline: none;
        }
        .cancel-reason::placeholder { color: rgba(229,231,235,0.52); }
        .cancel-reason:focus { border-color: rgba(56,239,125,0.55); box-shadow: 0 0 0 4px rgba(56,239,125,0.14); }
        .cancel-reason.show { display: inline-block; }

        .eta-select {
            display: none;
            width: 220px;
            height: 40px;
            border-radius: 12px;
            border: 1px solid rgba(255,255,255,0.12);
            background: rgba(15, 23, 42, 0.55);
            color: #e5e7eb;
            padding: 0 10px;
            outline: none;
        }
        .eta-select.show { display: inline-block; }
    </style>
</head>
<body>
<div class="app">
<?php if (!$isAdmin): ?>
    <div class="auth-page">
        <div class="auth-bg">
            <div class="blob b1"></div>
            <div class="blob b2"></div>
            <div class="blob b3"></div>
            <div class="spark s1"></div>
            <div class="spark s2"></div>
            <div class="spark s3"></div>
            <div class="spark s4"></div>
            <div class="spark s5"></div>
        </div>

        <div class="auth-shell">
            <div class="auth-card">
            <div class="brand">
                <div class="brand-badge" aria-hidden="true">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M7 10.5c0 1.38 1.12 2.5 2.5 2.5h5c1.38 0 2.5-1.12 2.5-2.5V7.6c0-1.38-1.12-2.5-2.5-2.5h-5C8.12 5.1 7 6.22 7 7.6v2.9Z" stroke="white" stroke-width="2"/>
                        <path d="M6 18.5c1.7-2.4 4-3.6 6-3.6s4.3 1.2 6 3.6" stroke="white" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                </div>
                <div>
                    <h1 class="brand-title">Admin Panel</h1>
                    <p class="brand-sub">Secure access for managing users and orders.</p>
                </div>
            </div>

            <form method="post" style="position: relative;" id="admin-login-form">
                <input type="hidden" name="action" value="login" />

                <div class="form form-grid">
                <div class="field">
                    <label for="username">Username</label>
                    <svg class="field-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M12 12a4.2 4.2 0 1 0 0-8.4A4.2 4.2 0 0 0 12 12Z" stroke="currentColor" stroke-width="2"/>
                        <path d="M4.2 20.4c1.7-3.2 4.7-4.8 7.8-4.8s6.1 1.6 7.8 4.8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    <input id="username" name="username" type="text" placeholder="Enter admin username" autocomplete="username" required <?php echo $isLocked ? 'disabled' : ''; ?> />
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <svg class="field-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                        <path d="M7 11V8.7C7 6.1 9 4 11.5 4S16 6.1 16 8.7V11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        <path d="M6.5 11h11c.83 0 1.5.67 1.5 1.5v6c0 .83-.67 1.5-1.5 1.5h-11c-.83 0-1.5-.67-1.5-1.5v-6c0-.83.67-1.5 1.5-1.5Z" stroke="currentColor" stroke-width="2"/>
                    </svg>
                    <input id="password" name="password" type="password" placeholder="Enter password" autocomplete="current-password" required <?php echo $isLocked ? 'disabled' : ''; ?> />
                    <button class="pw-toggle" type="button" id="pw-toggle" aria-label="Show password" <?php echo $isLocked ? 'disabled' : ''; ?>>
                        <svg id="pw-eye" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2.5 12s3.5-7 9.5-7 9.5 7 9.5 7-3.5 7-9.5 7-9.5-7-9.5-7Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M12 15.2a3.2 3.2 0 1 0 0-6.4 3.2 3.2 0 0 0 0 6.4Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </button>
                </div>

                <div class="auth-actions">
                    <button class="btn primary" type="submit" style="width: 100%;" id="login-btn" <?php echo $isLocked ? 'disabled' : ''; ?>>
                        <span class="btn-content">
                            <span class="spinner" aria-hidden="true"></span>
                            <span>Login to Dashboard</span>
                        </span>
                    </button>
                </div>
                </div>
            </form>

            <?php if ($isLocked): ?>
                <div class="msg error" style="position: relative;">
                    Too many attempts. This device is locked. Please try again later.
                </div>
            <?php endif; ?>

            <?php if ($loginError !== ''): ?>
                <div class="msg error" style="position: relative;"><?php echo h($loginError); ?></div>
            <?php endif; ?>

            <div class="auth-footer">
                <a href="login.php">Back to User Login</a>
                <span class="muted">v1.0</span>
            </div>
            <script>
                (function () {
                    const form = document.getElementById('admin-login-form');
                    const btn = document.getElementById('login-btn');
                    const pw = document.getElementById('password');
                    const toggle = document.getElementById('pw-toggle');

                    if (toggle && pw) {
                        toggle.addEventListener('click', function () {
                            const isPw = pw.type === 'password';
                            pw.type = isPw ? 'text' : 'password';
                            toggle.setAttribute('aria-label', isPw ? 'Hide password' : 'Show password');
                        });
                    }

                    if (form && btn) {
                        form.addEventListener('submit', function () {
                            btn.classList.add('loading');
                            btn.disabled = true;
                        });
                    }

                    const err = document.querySelector('.msg.error');
                    if (err) {
                        err.classList.add('shake');
                    }
                })();
            </script>
            </div>
        </div>
    </div>
<?php else: ?>
    <div class="dash">
        <div class="topbar">
            <div class="topbar-inner">
                <div class="brandline">
                    <div class="brandmark" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M8 11V8.4C8 6.1 9.9 4.2 12.2 4.2c2.3 0 4.2 1.9 4.2 4.2V11" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M6.8 11H17.6c.88 0 1.6.72 1.6 1.6v6.2c0 .88-.72 1.6-1.6 1.6H6.8c-.88 0-1.6-.72-1.6-1.6v-6.2c0-.88.72-1.6 1.6-1.6Z" stroke="currentColor" stroke-width="2"/>
                        </svg>
                    </div>
                    <div>
                        <h1 class="dash-title">Admin Dashboard</h1>
                        <div class="dash-sub">Logged in as <strong><?php echo h(isset($_SESSION['admin_username']) ? $_SESSION['admin_username'] : 'admin'); ?></strong></div>
                    </div>
                </div>

                <div class="dash-actions">
                    <span class="chip">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M12 12a4.2 4.2 0 1 0 0-8.4A4.2 4.2 0 0 0 12 12Z" stroke="currentColor" stroke-width="2"/>
                            <path d="M4.2 20.4c1.7-3.2 4.7-4.8 7.8-4.8s6.1 1.6 7.8 4.8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Admin
                    </span>
                    <a href="admin.php" aria-label="Refresh">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M20 12a8 8 0 1 1-2.34-5.66" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M20 4v6h-6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                        Refresh
                    </a>
                    <a class="primary" href="admin.php?logout=1" aria-label="Logout">
                        <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M10 7V6a2 2 0 0 1 2-2h7a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2h-7a2 2 0 0 1-2-2v-1" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M15 12H3" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            <path d="M6 9l-3 3 3 3" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                        Logout
                    </a>
                </div>
            </div>
        </div>

        <div class="dash-container">
            <?php if ($flash !== ''): ?>
                <div class="msg error" style="margin: 0 0 14px 0; border: 1px solid rgba(220,38,38,0.22); background: rgba(220,38,38,0.14); color: #fecaca;">
                    <?php echo h($flash); ?>
                </div>
            <?php endif; ?>

            <div class="stats">
                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Customers</div>
                        <div class="stat-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 12a4.2 4.2 0 1 0 0-8.4A4.2 4.2 0 0 0 12 12Z" stroke="currentColor" stroke-width="2"/>
                                <path d="M4.2 20.4c1.7-3.2 4.7-4.8 7.8-4.8s6.1 1.6 7.8 4.8" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo h($statsCustomers); ?></div>
                    <div class="stat-foot">From loaded orders</div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Orders</div>
                        <div class="stat-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M7 7h14l-2 10H9L7 7Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                                <path d="M7 7l-2-3H2" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M9 21a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" stroke="currentColor" stroke-width="2"/>
                                <path d="M18 21a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo h($statsOrders); ?></div>
                    <div class="stat-foot">Latest 200 orders loaded</div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Revenue</div>
                        <div class="stat-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 1v22" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M17 5.5c0-2-2.2-3.5-5-3.5S7 3.5 7 5.5 9.2 9 12 9s5 1.5 5 3.5S14.8 16 12 16s-5 1.5-5 3.5S9.2 22 12 22s5-1.5 5-3.5" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value">₹<?php echo h(number_format($statsRevenue, 2)); ?></div>
                    <div class="stat-foot">Delivered: ₹<?php echo h(number_format($statsDeliveredRevenue, 2)); ?></div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Approvals</div>
                        <div class="stat-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M20 7l-8.5 8.5L8 12" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M4 6h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M4 10h4" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo h($statsApprovalTotal); ?></div>
                    <div class="stat-foot"><?php echo h($statsPending); ?> pending</div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Cancelled / Loss</div>
                        <div class="stat-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M18 6 6 18" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                <path d="M6 6l12 12" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value"><?php echo h($statsCancelled); ?></div>
                    <div class="stat-foot">₹<?php echo h(number_format($statsLoss, 2)); ?> total loss</div>
                </div>

                <div class="stat">
                    <div class="stat-top">
                        <div class="stat-label">Time / Avg</div>
                        <div class="stat-ico" aria-hidden="true">
                            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M12 8v5l3 2" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                <path d="M12 22a10 10 0 1 0-10-10 10 10 0 0 0 10 10Z" stroke="currentColor" stroke-width="2"/>
                            </svg>
                        </div>
                    </div>
                    <div class="stat-value" style="font-size:1.05rem;"><?php echo h($serverNow); ?></div>
                    <div class="stat-foot">Avg: ₹<?php echo h(number_format($statsAvgOrder, 2)); ?> / order</div>
                </div>
            </div>

            <div class="panel-grid" style="grid-template-columns: 1fr;">
                <div class="panel">
                    <div class="panel-head">
                        <div>
                            <h2 class="panel-title">Orders</h2>
                            <div class="panel-sub">Total shown: <?php echo h($statsOrders); ?></div>
                        </div>
                        <div class="panel-tools">
                            <input class="search" id="ordersSearch" type="text" placeholder="Search by order / user / status" autocomplete="off" />
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="table-wrap">
                            <table id="ordersTable">
                                <thead>
                                    <tr>
                                        <th>Order</th>
                                        <th>User</th>
                                        <th>Total</th>
                                        <th>Items</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                        <th>Created</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($orders as $o): ?>
                                        <tr>
                                            <td data-label="Order"><?php echo h($o['order_code'] !== '' ? $o['order_code'] : $o['id']); ?></td>
                                            <td data-label="User">
                                                <div style="font-weight:900;"><?php echo h(($o['user_name'] ?? '') !== '' ? $o['user_name'] : ('User #' . $o['user_id'])); ?></div>
                                                <div style="color:rgba(229,231,235,0.70); font-size:0.86rem; margin-top:2px;">
                                                    <?php echo h((string)($o['user_email'] ?? '')); ?><?php echo ((string)($o['user_phone'] ?? '') !== '') ? (' • ' . h((string)$o['user_phone'])) : ''; ?>
                                                </div>
                                                <?php if (strtolower((string)$o['status']) === 'cancelled' && $hasCancelReason && ((string)($o['cancel_reason'] ?? '')) !== ''): ?>
                                                    <div style="margin-top:8px; padding:10px 12px; border-radius:14px; background: rgba(255, 77, 79, 0.10); border: 1px solid rgba(255, 77, 79, 0.18); color: #fecaca; font-weight: 800;">
                                                        Cancelled<?php if ($hasCancelledBy && ((string)($o['cancelled_by'] ?? '')) !== ''): ?> (by <?php echo h((string)$o['cancelled_by']); ?>)<?php endif; ?>: <?php echo h((string)$o['cancel_reason']); ?>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                            <td data-label="Total">₹<?php echo h($o['total_amount']); ?></td>
                                            <td data-label="Items"><?php echo h($o['items_count']); ?></td>
                                            <td data-label="Status"><span class="badge <?php echo h(badgeClass($o['status'])); ?>"><?php echo h($o['status']); ?></span></td>
                                            <td data-label="Action">
                                                <form method="post" style="display:flex; gap:8px; align-items:center; margin:0;">
                                                    <input type="hidden" name="action" value="update_order_status" />
                                                    <input type="hidden" name="order_id" value="<?php echo h($o['id']); ?>" />
                                                    <select name="new_status" style="height:40px; border-radius:12px; border:1px solid rgba(255,255,255,0.12); background: rgba(15, 23, 42, 0.55); color:#e5e7eb; padding:0 10px; outline:none;">
                                                        <?php $cur = strtolower((string)$o['status']); ?>
                                                        <?php if ($cur === 'delivered'): ?>
                                                            <option value="delivered" selected>Delivered</option>
                                                            <option value="cancelled">Cancelled</option>
                                                        <?php else: ?>
                                                            <option value="pending" <?php echo $cur === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                                            <option value="approved" <?php echo $cur === 'approved' ? 'selected' : ''; ?>>Approved</option>
                                                            <option value="shifted" <?php echo $cur === 'shifted' ? 'selected' : ''; ?>>Shifted</option>
                                                            <option value="delivered" <?php echo $cur === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                                            <option value="cancelled" <?php echo $cur === 'cancelled' ? 'selected' : ''; ?>>Cancelled</option>
                                                        <?php endif; ?>
                                                    </select>
                                                    <input class="cancel-reason" name="cancel_reason" type="text" placeholder="Cancel reason (required)" value="<?php echo h($hasCancelReason ? (string)($o['cancel_reason'] ?? '') : ''); ?>" />
                                                    <select class="eta-select" name="eta_minutes">
                                                        <?php $eta = (int)($hasEtaMinutes ? ($o['delivery_eta_minutes'] ?? 45) : 45); ?>
                                                        <option value="15" <?php echo $eta === 15 ? 'selected' : ''; ?>>15 min</option>
                                                        <option value="30" <?php echo $eta === 30 ? 'selected' : ''; ?>>30 min</option>
                                                        <option value="45" <?php echo $eta === 45 ? 'selected' : ''; ?>>45 min (default)</option>
                                                        <option value="60" <?php echo $eta === 60 ? 'selected' : ''; ?>>60 min</option>
                                                        <option value="90" <?php echo $eta === 90 ? 'selected' : ''; ?>>90 min</option>
                                                        <option value="120" <?php echo $eta === 120 ? 'selected' : ''; ?>>120 min</option>
                                                    </select>
                                                    <button type="submit" style="height:40px; border-radius:12px; border:1px solid rgba(255,255,255,0.12); background: rgba(255,255,255,0.08); color:#e5e7eb; padding:0 12px; font-weight:900; cursor:pointer;">Update</button>
                                                </form>
                                            </td>
                                            <td data-label="Created">
                                                <div><?php echo h($o['created_at']); ?></div>
                                                <?php if (strtolower((string)$o['status']) === 'shifted'): ?>
                                                    <div style="margin-top:8px; padding:10px 12px; border-radius:14px; background: rgba(72, 219, 251, 0.10); border: 1px solid rgba(72, 219, 251, 0.18); color: #a5f3fc; font-weight: 900;">
                                                        ETA: <span class="eta-countdown" data-minutes="<?php echo h((string)($hasEtaMinutes ? (int)($o['delivery_eta_minutes'] ?? 45) : 45)); ?>" data-setat="<?php echo h((string)($hasEtaSetAt ? ($o['delivery_eta_set_at'] ?? '') : '')); ?>"></span>
                                                    </div>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                (function () {
                    function bindSearch(inputId, tableId) {
                        const input = document.getElementById(inputId);
                        const table = document.getElementById(tableId);
                        if (!input || !table) return;

                        const rows = Array.from(table.querySelectorAll('tbody tr'));
                        input.addEventListener('input', function () {
                            const q = (input.value || '').toLowerCase().trim();
                            rows.forEach(function (tr) {
                                const text = (tr.innerText || '').toLowerCase();
                                tr.style.display = text.indexOf(q) !== -1 ? '' : 'none';
                            });
                        });
                    }

                    bindSearch('ordersSearch', 'ordersTable');

                    // ETA countdown
                    let etaCountdownTimer = null;
                    function parseMysqlDateTime(dt) {
                        if (!dt) return null;
                        const isoLike = String(dt).trim().replace(' ', 'T');
                        const d = new Date(isoLike);
                        if (isNaN(d.getTime())) return null;
                        return d;
                    }
                    function formatRemaining(seconds) {
                        const s = Math.max(0, Math.floor(seconds));
                        const mm = Math.floor(s / 60);
                        const ss = s % 60;
                        return `${mm}:${String(ss).padStart(2, '0')} min`;
                    }
                    function initEtaCountdowns() {
                        const nodes = Array.from(document.querySelectorAll('.eta-countdown'));
                        if (nodes.length === 0) {
                            if (etaCountdownTimer) {
                                clearInterval(etaCountdownTimer);
                                etaCountdownTimer = null;
                            }
                            return;
                        }
                        function tick() {
                            const now = Date.now();
                            nodes.forEach(el => {
                                const minutes = Number(el.getAttribute('data-minutes') || '45');
                                const setAtRaw = el.getAttribute('data-setat') || '';
                                const setAt = parseMysqlDateTime(setAtRaw);
                                if (!setAt) {
                                    el.textContent = `${(minutes && minutes > 0) ? minutes : 45} minutes`;
                                    return;
                                }
                                const totalSeconds = (minutes && minutes > 0 ? minutes : 45) * 60;
                                const elapsedSeconds = (now - setAt.getTime()) / 1000;
                                const remaining = totalSeconds - elapsedSeconds;
                                if (remaining <= 0) {
                                    el.textContent = 'Arriving soon';
                                } else {
                                    el.textContent = formatRemaining(remaining);
                                }
                            });
                        }
                        tick();
                        if (etaCountdownTimer) clearInterval(etaCountdownTimer);
                        etaCountdownTimer = setInterval(tick, 1000);
                    }
                    initEtaCountdowns();

                    // Cancel reason toggle + validation
                    document.querySelectorAll('#ordersTable tbody tr').forEach(function (row) {
                        const sel = row.querySelector('select[name="new_status"]');
                        const reason = row.querySelector('input[name="cancel_reason"]');
                        const eta = row.querySelector('select[name="eta_minutes"]');
                        const form = row.querySelector('form');
                        if (!sel || !reason || !form) return;

                        function sync() {
                            const v = (sel.value || '').toLowerCase();
                            if (v === 'cancelled') {
                                reason.classList.add('show');
                            } else {
                                reason.classList.remove('show');
                                reason.value = '';
                            }

                            if (eta) {
                                if (v === 'shifted') {
                                    eta.classList.add('show');
                                    if (!eta.value) eta.value = '45';
                                } else {
                                    eta.classList.remove('show');
                                }
                            }
                        }

                        sel.addEventListener('change', sync);
                        sync();

                        form.addEventListener('submit', function (e) {
                            const v = (sel.value || '').toLowerCase();
                            if (v === 'cancelled') {
                                const r = (reason.value || '').trim();
                                if (!r) {
                                    e.preventDefault();
                                    alert('Cancel reason is required.');
                                    reason.focus();
                                }
                            }

                            if (v === 'shifted' && eta) {
                                if (!eta.value) {
                                    eta.value = '45';
                                }
                            }
                        });
                    });
                })();
            </script>
        </div>
    </div>
<?php endif; ?>
</div>
</body>
</html>
