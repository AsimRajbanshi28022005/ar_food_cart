<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Dashboard - Online Food Delivery</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f3f4f6;
            color: #333;
        }

        header {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: #ffffff;
            padding: 20px 0;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .header-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: translateY(-2px);
        }

        .container {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            padding: 20px;
        }

        .dashboard-header {
            text-align: center;
            margin-bottom: 40px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 40px 20px;
            border-radius: 20px;
            position: relative;
            overflow: hidden;
        }

        .dashboard-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 4s infinite;
        }

        .dashboard-header * {
            position: relative;
            z-index: 1;
        }

        .dashboard-header h1 {
            font-size: 2.8rem;
            margin-bottom: 15px;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .welcome-text {
            font-size: 1.3rem;
            opacity: 0.95;
        }

        .user-greeting {
            font-size: 1.1rem;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Custom Popup Modal Styles */
        .custom-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-out;
        }

        .custom-popup-overlay.show {
            display: flex;
        }

        .custom-popup {
            background: white;
            border-radius: 20px;
            padding: 30px;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transform: scale(0.7);
            opacity: 0;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            position: relative;
            text-align: center;
        }

        .custom-popup-overlay.show .custom-popup {
            transform: scale(1);
            opacity: 1;
        }

        .popup-header {
            margin-bottom: 20px;
        }

        .popup-icon {
            font-size: 3rem;
            margin-bottom: 15px;
            display: block;
        }

        .popup-title {
            color: #11998e;
            font-size: 1.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .popup-message {
            color: #666;
            font-size: 1rem;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .popup-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .popup-btn {
            padding: 12px 24px;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 100px;
        }

        .popup-btn.primary {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: white;
        }

        .popup-btn.primary:hover {
            background: linear-gradient(to right, #0c8976, #30c270);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .popup-btn.secondary {
            background: #f8f9fa;
            color: #333;
            border: 2px solid #ddd;
        }

        .popup-btn.secondary:hover {
            background: #e9ecef;
            border-color: #11998e;
            transform: translateY(-2px);
        }

        .popup-btn.danger {
            background: linear-gradient(to right, #ff4d4f, #ff6382);
            color: white;
        }

        .popup-btn.danger:hover {
            background: linear-gradient(to right, #e63c3f, #f34d6f);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 30px;
            margin-bottom: 40px;
        }

        .profile-card, .stats-card {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .profile-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .profile-card h2, .stats-card h2 {
            color: #11998e;
            margin: 0;
            font-size: 1.5rem;
        }

        .edit-profile-btn {
            border: none;
            background: #f3f4f6;
            color: #4b5563;
            border-radius: 999px;
            padding: 6px 12px;
            font-size: 0.85rem;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .edit-profile-btn:hover {
            background: #e5e7eb;
        }

        .avatar-wrapper {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 15px;
        }

        .avatar-circle {
            width: 72px;
            height: 72px;
            border-radius: 50%;
            background-color: #f3f4f6;
            background-size: cover;
            background-position: center;
            border: 3px solid #11998e;
            flex-shrink: 0;
        }

        .avatar-change-btn {
            padding: 10px 16px;
            border-radius: 10px;
            border: 2px solid #11998e;
            background: #ffffff;
            color: #11998e;
            font-weight: bold;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .avatar-change-btn:hover {
            background: #11998e;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(17,153,142,0.3);
        }

        .profile-info {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .info-item {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-label {
            font-weight: bold;
            color: #666;
        }

        .info-value {
            color: #333;
        }

        .profile-edit-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10002;
            backdrop-filter: blur(6px);
        }

        .profile-edit-modal {
            background: #ffffff;
            border-radius: 18px;
            padding: 24px 24px 20px 24px;
            width: 100%;
            max-width: 420px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.3);
        }

        .profile-edit-title {
            margin: 0 0 16px 0;
            font-size: 1.3rem;
            color: #11998e;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .profile-edit-body {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 18px;
        }

        .profile-edit-field label {
            display: block;
            font-size: 0.85rem;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .profile-edit-field input {
            width: 100%;
            padding: 8px 10px;
            border-radius: 8px;
            border: 1px solid #d1d5db;
            font-size: 0.9rem;
        }

        .profile-edit-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
        }

        .profile-edit-btn {
            padding: 8px 16px;
            border-radius: 999px;
            border: none;
            font-size: 0.9rem;
            font-weight: bold;
            cursor: pointer;
        }

        .profile-edit-btn.secondary {
            background: #f3f4f6;
            color: #374151;
        }

        .profile-edit-btn.primary {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: #ffffff;
        }

        .avatar-modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.7);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10001;
        }

        .avatar-modal {
            background: #ffffff;
            border-radius: 18px;
            padding: 20px 20px 16px 20px;
            max-width: 420px;
            width: 90%;
            box-shadow: 0 15px 40px rgba(0,0,0,0.3);
        }

        .avatar-modal-header {
            font-size: 1.2rem;
            font-weight: bold;
            color: #11998e;
            margin-bottom: 10px;
        }

        .avatar-modal-body {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .avatar-file-input {
            width: 100%;
        }

        .avatar-preview-container {
            width: 240px;
            height: 240px;
            margin: 0 auto;
            border-radius: 50%;
            overflow: hidden;
            background: #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        #avatar-canvas {
            width: 240px;
            height: 240px;
        }

        .avatar-range {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .avatar-range input[type="range"] {
            flex: 1;
        }

        .avatar-modal-actions {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 15px;
        }

        .avatar-btn {
            padding: 8px 16px;
            border-radius: 10px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
        }

        .avatar-btn.secondary {
            background: #f3f4f6;
            color: #333333;
        }

        .avatar-btn.primary {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: #ffffff;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }

        .stat-item {
            text-align: center;
            padding: 20px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 15px;
        }

        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .stat-label {
            font-size: 0.9rem;
            opacity: 0.9;
        }

        .orders-section {
            background: linear-gradient(180deg, rgba(255,255,255,1), rgba(249,250,251,1));
            padding: 30px;
            border-radius: 22px;
            box-shadow: 0 18px 55px rgba(2, 6, 23, 0.10);
            border: 1px solid rgba(15, 23, 42, 0.06);
        }

        .orders-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 12px;
        }

        .orders-header h2 {
            color: #11998e;
            margin: 0;
        }

        .filter-buttons {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 10px 14px;
            border: 2px solid rgba(17, 153, 142, 0.35);
            background: rgba(255,255,255,0.9);
            color: #0f766e;
            border-radius: 999px;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 900;
            font-size: 0.86rem;
            letter-spacing: 0.2px;
        }

        .filter-btn.active, .filter-btn:hover {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: white;
            border-color: rgba(17, 153, 142, 0.0);
        }

        .order-item {
            border: 1px solid rgba(15, 23, 42, 0.08);
            border-radius: 18px;
            padding: 18px;
            margin-bottom: 16px;
            background: rgba(255,255,255,0.98);
            transition: all 0.3s ease;
        }

        .order-item:hover {
            box-shadow: 0 18px 40px rgba(15, 23, 42, 0.12);
            transform: translateY(-2px);
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .order-id {
            font-weight: bold;
            color: #11998e;
        }

        .order-date {
            color: #666;
            font-size: 0.9rem;
        }

        .order-status {
            padding: 7px 12px;
            border-radius: 999px;
            font-size: 0.78rem;
            font-weight: 900;
            letter-spacing: 0.2px;
            text-transform: uppercase;
            border: 1px solid rgba(15, 23, 42, 0.08);
        }

        .status-delivered {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-shifted {
            background: rgba(219, 234, 254, 0.95);
            color: #1d4ed8;
        }

        .status-approved {
            background: rgba(209, 250, 229, 0.95);
            color: #065f46;
        }

        .status-cancelled {
            background: rgba(254, 226, 226, 0.95);
            color: #991b1b;
        }

        .order-items {
            margin-bottom: 15px;
        }

        .order-item-row {
            display: flex;
            justify-content: space-between;
            padding: 5px 0;
            color: #666;
        }

        .order-total {
            text-align: right;
            font-weight: bold;
            color: #11998e;
            font-size: 1.1rem;
            border-top: 1px solid #e0e0e0;
            padding-top: 10px;
        }

        .hist-check {
            width: 18px;
            height: 18px;
            accent-color: #11998e;
        }

        @media (max-width: 760px) {
            .orders-section {
                padding: 18px;
                border-radius: 18px;
            }
            .orders-header {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 18px;
            }
            .filter-buttons {
                width: 100%;
                overflow-x: auto;
                flex-wrap: nowrap;
                padding-bottom: 6px;
            }
            .filter-btn { white-space: nowrap; }
        }

        .quick-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-top: 40px;
        }

        .action-card {
            background: white;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .action-icon {
            font-size: 3rem;
            margin-bottom: 15px;
        }

        .action-title {
            font-weight: bold;
            color: #11998e;
            margin-bottom: 10px;
        }

        .action-desc {
            color: #666;
            font-size: 0.9rem;
        }

        .insights-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .insights-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 20px;
        }

        .insight-card {
            background: linear-gradient(135deg, #ff9f43 0%, #ff6f61 100%);
            color: white;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
        }

        .insight-icon {
            font-size: 2.5rem;
            margin-bottom: 10px;
        }

        .insight-title {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .insight-value {
            font-size: 1.5rem;
            font-weight: bold;
        }

        .favorites-section {
            background: white;
            padding: 30px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .favorite-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
            border: 1px solid #e0e0e0;
            border-radius: 10px;
            margin-bottom: 10px;
            transition: all 0.3s ease;
        }

        .favorite-item:hover {
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transform: translateY(-2px);
        }

        .favorite-info {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .favorite-icon {
            font-size: 2rem;
        }

        .favorite-details h4 {
            margin: 0 0 5px 0;
            color: #11998e;
        }

        .favorite-details p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }

        .reorder-btn {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: all 0.3s ease;
        }

        .reorder-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0,0,0,0.2);
        }

        .loyalty-card {
            background: linear-gradient(135deg, #ffd700 0%, #ffed4e 100%);
            color: #333;
            padding: 25px;
            border-radius: 15px;
            text-align: center;
            margin-bottom: 20px;
        }

        .loyalty-points {
            font-size: 2.5rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .progress-bar {
            background: rgba(0,0,0,0.2);
            height: 8px;
            border-radius: 4px;
            overflow: hidden;
            margin: 15px 0;
        }

        .progress-fill {
            background: #11998e;
            height: 100%;
            transition: width 0.5s ease;
        }

        .empty-orders {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: 1fr;
            }
            
            .orders-header {
                flex-direction: column;
                gap: 15px;
                align-items: stretch;
            }
            
            .filter-buttons {
                justify-content: center;
            }
            
            .order-header {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }
            
            .dashboard-header h1 {
                font-size: 2rem;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <h1>🍽️ My Dashboard</h1>
            <a href="index.php" class="back-btn">← Back to Menu</a>
        </div>
    </header>

    <div class="profile-edit-overlay" id="profile-edit-overlay">
        <div class="profile-edit-modal">
            <h3 class="profile-edit-title">✏️ Edit Profile</h3>
            <div class="profile-edit-body">
                <div class="profile-edit-field">
                    <label for="edit-name">Full Name</label>
                    <input type="text" id="edit-name" />
                </div>
                <div class="profile-edit-field">
                    <label for="edit-phone">Phone</label>
                    <input type="text" id="edit-phone" />
                </div>
                <div class="profile-edit-field">
                    <label for="edit-address">Full Address</label>
                    <input type="text" id="edit-address" />
                </div>
                <div class="profile-edit-field">
                    <label for="edit-pin">PIN Code</label>
                    <input type="text" id="edit-pin" />
                </div>
            </div>
            <div class="profile-edit-actions">
                <button type="button" class="profile-edit-btn secondary" onclick="closeProfileEditModal()">Cancel</button>
                <button type="button" class="profile-edit-btn primary" onclick="saveProfileEdits()">Save Changes</button>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="dashboard-header">
            <div class="user-greeting" id="user-greeting">Good day!</div>
            <h1 id="personalized-welcome">Welcome Back!</h1>
            <p class="welcome-text" id="welcome-message">Here's your personalized food delivery dashboard</p>
        </div>

        <div class="dashboard-grid">
            <!-- Profile Card -->
            <div class="profile-card">
                <div class="profile-card-header">
                    <h2>👤 Profile Information</h2>
                    <button type="button" class="edit-profile-btn" onclick="openProfileEditModal()">✏️ Edit</button>
                </div>
                <div class="avatar-wrapper">
                    <div class="avatar-circle" id="dashboard-avatar"></div>
                    <button class="avatar-change-btn" type="button" onclick="openAvatarModal()">Change Photo</button>
                </div>
                <div class="profile-info" id="profile-info">
                    <!-- Profile info will be populated by JavaScript -->
                </div>
            </div>

            <!-- Stats Card -->
            <div class="stats-card">
                <h2>📊 Your Statistics</h2>
                
                <!-- Loyalty Points -->
                <div class="loyalty-card">
                    <div class="loyalty-points" id="loyalty-points">0</div>
                    <div>Loyalty Points</div>
                    <div class="progress-bar">
                        <div class="progress-fill" id="loyalty-progress"></div>
                    </div>
                    <small id="loyalty-status">Earn 50 more points for next reward!</small>
                </div>
                
                <div class="stats-grid" id="stats-grid">
                    <!-- Stats will be populated by JavaScript -->
                </div>
            </div>
        </div>

        <!-- Advanced Insights Section -->
        <div class="insights-section">
            <h2 style="color: #11998e; margin-bottom: 20px;">🔍 Smart Insights</h2>
            <div class="insights-grid" id="insights-grid">
                <!-- Insights will be populated by JavaScript -->
            </div>
        </div>

        <!-- Favorite Items Section -->
        <div class="favorites-section">
            <h2 style="color: #11998e; margin-bottom: 20px;">❤️ Your Favorite Items</h2>
            <div id="favorites-container">
                <!-- Favorites will be populated by JavaScript -->
            </div>
        </div>

        <!-- Orders Section -->
        <div class="orders-section" id="orders">
            <div class="orders-header">
                <h2>📦 Order History</h2>
                <div class="filter-buttons">
                    <button class="filter-btn active" onclick="filterOrders(event, 'all')">All Orders</button>
                    <button class="filter-btn" onclick="filterOrders(event, 'delivered')">Delivered</button>
                    <button class="filter-btn" onclick="filterOrders(event, 'pending')">Pending</button>
                    <button class="filter-btn" onclick="filterOrders(event, 'cancelled')">Cancelled</button>
                    <button class="filter-btn" onclick="filterOrders(event, 'history')">History</button>
                </div>
            </div>
            <div id="orders-container">
                <!-- Orders will be populated by JavaScript -->
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <div class="action-card" onclick="goToMenu()">
                <div class="action-icon">🍽️</div>
                <div class="action-title">Order Food</div>
                <div class="action-desc">Browse menu and place new order</div>
            </div>
            <div class="action-card" onclick="reorderFavorite()">
                <div class="action-icon">🔄</div>
                <div class="action-title">Reorder Favorite</div>
                <div class="action-desc">Quickly reorder your most loved items</div>
            </div>
            <div class="action-card" onclick="openProfileEditModal()">
                <div class="action-icon">⚙️</div>
                <div class="action-title">Account Settings</div>
                <div class="action-desc">Update your profile and preferences</div>
            </div>
            <div class="action-card" onclick="contactSupport()">
                <div class="action-icon">💬</div>
                <div class="action-title">Support</div>
                <div class="action-desc">Get help with your orders</div>
            </div>
        </div>
    </div>

    <!-- Custom Popup Modal -->
    <div class="custom-popup-overlay" id="custom-popup-overlay">
        <div class="custom-popup">
            <div class="popup-header">
                <div class="popup-icon" id="popup-icon">ℹ️</div>
                <div class="popup-title" id="popup-title">Information</div>
            </div>
            <div class="popup-message" id="popup-message">This is a custom popup message.</div>
            <div class="popup-buttons" id="popup-buttons">
                <button class="popup-btn primary" onclick="closeCustomPopup()">OK</button>
            </div>
        </div>
    </div>

    <div class="avatar-modal-overlay" id="avatar-modal-overlay">
        <div class="avatar-modal">
            <div class="avatar-modal-header">Update Profile Picture</div>
            <div class="avatar-modal-body">
                <input class="avatar-file-input" id="avatar-file-input" type="file" accept="image/*" onchange="handleAvatarFileChange(event)">
                <div class="avatar-preview-container">
                    <canvas id="avatar-canvas" width="240" height="240"></canvas>
                </div>
                <div class="avatar-range">
                    <span>Zoom</span>
                    <input id="avatar-zoom" type="range" min="1" max="3" step="0.01" value="1" oninput="onAvatarZoomChange(event)">
                </div>
            </div>
            <div class="avatar-modal-actions">
                <button class="avatar-btn secondary" type="button" onclick="closeAvatarModal()">Cancel</button>
                <button class="avatar-btn primary" type="button" onclick="saveAvatar()">Save</button>
            </div>
        </div>
    </div>

    <script>
        let currentUser = null;
        let userOrders = [];
        let currentFilter = 'all';
        let visibleOrdersCount = 5;
        let selectedHistoryOrders = new Set();

        let avatarImage = null;
        let avatarScale = 1;
        let avatarCanvas = null;
        let avatarCtx = null;

        // Custom Popup System
        function showCustomPopup(options) {
            const overlay = document.getElementById('custom-popup-overlay');
            const iconEl = document.getElementById('popup-icon');
            const titleEl = document.getElementById('popup-title');
            const messageEl = document.getElementById('popup-message');
            const buttonsEl = document.getElementById('popup-buttons');
            
            // Set content
            iconEl.textContent = options.icon || 'ℹ️';
            titleEl.textContent = options.title || 'Information';
            if (options && options.allowHtml) {
                messageEl.innerHTML = options.message || '';
            } else {
                messageEl.textContent = options.message || '';
            }
            
            // Clear existing buttons
            buttonsEl.innerHTML = '';
            
            // Add buttons
            if (options.buttons && options.buttons.length > 0) {
                options.buttons.forEach(button => {
                    const btn = document.createElement('button');
                    btn.className = `popup-btn ${button.type || 'primary'}`;
                    btn.textContent = button.text;
                    btn.onclick = () => {
                        if (button.action) button.action();
                        closeCustomPopup();
                    };
                    buttonsEl.appendChild(btn);
                });
            } else {
                // Default OK button
                const okBtn = document.createElement('button');
                okBtn.className = 'popup-btn primary';
                okBtn.textContent = 'OK';
                okBtn.onclick = closeCustomPopup;
                buttonsEl.appendChild(okBtn);
            }
            
            // Show popup
            overlay.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeCustomPopup() {
            const overlay = document.getElementById('custom-popup-overlay');
            overlay.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function showConfirmPopup(options) {
            showCustomPopup({
                icon: options.icon || '❓',
                title: options.title || 'Confirm Action',
                message: options.message,
                buttons: [
                    {
                        text: options.cancelText || 'Cancel',
                        type: 'secondary',
                        action: options.onCancel
                    },
                    {
                        text: options.confirmText || 'Confirm',
                        type: options.confirmType || 'primary',
                        action: options.onConfirm
                    }
                ]
            });
        }

        function showSuccessPopup(message, title = 'Success') {
            showCustomPopup({
                icon: '🎉',
                title: title,
                message: message,
                buttons: [{ text: 'Great!', type: 'primary' }]
            });
        }

        function showErrorPopup(message, title = 'Error') {
            showCustomPopup({
                icon: '❌',
                title: title,
                message: message,
                buttons: [{ text: 'OK', type: 'danger' }]
            });
        }

        function showInfoPopup(message, title = 'Information') {
            showCustomPopup({
                icon: 'ℹ️',
                title: title,
                message: message,
                buttons: [{ text: 'OK', type: 'primary' }]
            });
        }

        function loadUserData() {
            currentUser = JSON.parse(localStorage.getItem('currentUser'));
            
            if (!currentUser) {
                showErrorPopup('Please login first to access your dashboard!', 'Login Required');
                setTimeout(() => {
                    window.location.href = 'login.php';
                }, 2000);
                return;
            }

            updateWelcomeMessage();
            updateProfileInfo();

            loadOrdersFromServer(currentUser.id)
                .then(() => {
                    updateStats();
                    updateLoyaltyPoints();
                    updateInsights();
                    updateFavorites();
                    displayOrders();
                });

            // If coming from checkout, scroll to orders
            if (window.location && window.location.hash === '#orders') {
                setTimeout(() => {
                    const el = document.getElementById('orders');
                    if (el) {
                        el.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }, 300);
            }
        }

        function loadOrdersFromServer(userId) {
            return fetch(`../backend/get_user_orders.php?user_id=${encodeURIComponent(userId)}`)
                .then(r => r.json())
                .then(data => {
                    if (data && data.success && Array.isArray(data.orders)) {
                        userOrders = data.orders;
                        visibleOrdersCount = 5;
                        return;
                    }

                    userOrders = [];
                })
                .catch(() => {
                    userOrders = [];
                });
        }

        function updateWelcomeMessage() {
            const now = new Date();
            const hour = now.getHours();
            let greeting = 'Good day';
            
            if (hour < 12) greeting = 'Good morning';
            else if (hour < 17) greeting = 'Good afternoon';
            else greeting = 'Good evening';
            
            document.getElementById('user-greeting').textContent = `${greeting}, ${currentUser.name}! 🌟`;
            document.getElementById('personalized-welcome').textContent = `Welcome to Your Dashboard`;
            document.getElementById('welcome-message').textContent = 
                `Here's your personalized food delivery experience`;
        }

        function updateProfileInfo() {
            const profileInfo = document.getElementById('profile-info');
            const joinDate = new Date(currentUser.registeredAt || Date.now()).toLocaleDateString();
            updateDashboardAvatar();
            
            profileInfo.innerHTML = `
                <div class="info-item">
                    <span class="info-label">Full Name:</span>
                    <span class="info-value">${currentUser.name}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value">${currentUser.email}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span class="info-value">${currentUser.phone || 'Not provided'}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Address:</span>
                    <span class="info-value">${currentUser.address || 'Not provided'}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">PIN Code:</span>
                    <span class="info-value">${currentUser.pin || 'Not provided'}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Member Since:</span>
                    <span class="info-value">${joinDate}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Status:</span>
                    <span class="info-value">Active Member 🌟</span>
                </div>
            `;
        }

        function updateDashboardAvatar() {
            const avatarCircle = document.getElementById('dashboard-avatar');
            if (!avatarCircle || !currentUser) return;
            if (currentUser.avatar) {
                avatarCircle.style.backgroundImage = `url(${currentUser.avatar})`;
            } else {
                avatarCircle.style.backgroundImage = '';
            }
        }

        function updateStats() {
            const totalOrders = userOrders.length;
            const totalSpent = userOrders.reduce((sum, order) => sum + order.total, 0);
            const deliveredOrders = userOrders.filter(order => order.status === 'delivered').length;
            const avgOrderValue = totalOrders > 0 ? (totalSpent / totalOrders).toFixed(0) : 0;

            document.getElementById('stats-grid').innerHTML = `
                <div class="stat-item">
                    <div class="stat-number">${totalOrders}</div>
                    <div class="stat-label">Total Orders</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">₹${totalSpent}</div>
                    <div class="stat-label">Total Spent</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">${deliveredOrders}</div>
                    <div class="stat-label">Delivered</div>
                </div>
                <div class="stat-item">
                    <div class="stat-number">₹${avgOrderValue}</div>
                    <div class="stat-label">Avg Order</div>
                </div>
            `;
        }

        function updateLoyaltyPoints() {
            const totalSpent = userOrders.reduce((sum, order) => sum + order.total, 0);
            const loyaltyPoints = Math.floor(totalSpent / 10); // 1 point per ₹10 spent
            const progressPercent = (loyaltyPoints % 100) / 100 * 100; // Progress to next 100 points
            
            document.getElementById('loyalty-points').textContent = loyaltyPoints;
            document.getElementById('loyalty-progress').style.width = `${progressPercent}%`;
            
            const pointsToNext = 100 - (loyaltyPoints % 100);
            document.getElementById('loyalty-status').textContent = 
                `Earn ${pointsToNext} more points for next reward! (₹${pointsToNext * 10} in orders)`;
        }

        function updateInsights() {
            const totalOrders = userOrders.length;
            const totalSpent = userOrders.reduce((sum, order) => sum + order.total, 0);
            
            // Calculate favorite cuisine
            const cuisineCount = {};
            userOrders.forEach(order => {
                order.items.forEach(item => {
                    // Simple cuisine detection based on item names
                    let cuisine = 'Other';
                    if (item.name.includes('Biryani') || item.name.includes('Curry')) cuisine = 'Indian';
                    else if (item.name.includes('Pizza') || item.name.includes('Pasta')) cuisine = 'Italian';
                    else if (item.name.includes('Burger') || item.name.includes('Sandwich')) cuisine = 'Fast Food';
                    else if (item.name.includes('Noodles') || item.name.includes('Fried Rice')) cuisine = 'Chinese';
                    
                    cuisineCount[cuisine] = (cuisineCount[cuisine] || 0) + item.quantity;
                });
            });
            
            const favoriteCuisine = Object.keys(cuisineCount).reduce((a, b) => 
                cuisineCount[a] > cuisineCount[b] ? a : b, 'None');
            
            // Calculate average order frequency
            const daysSinceJoin = Math.floor((Date.now() - new Date(currentUser.registeredAt || Date.now())) / (1000 * 60 * 60 * 24)) || 1;
            const orderFrequency = (totalOrders / daysSinceJoin * 7).toFixed(1);
            
            // Calculate savings (mock data)
            const estimatedSavings = Math.floor(totalSpent * 0.15);
            
            document.getElementById('insights-grid').innerHTML = `
                <div class="insight-card">
                    <div class="insight-icon">🍽️</div>
                    <div class="insight-title">Favorite Cuisine</div>
                    <div class="insight-value">${favoriteCuisine}</div>
                </div>
                <div class="insight-card">
                    <div class="insight-icon">📈</div>
                    <div class="insight-title">Order Frequency</div>
                    <div class="insight-value">${orderFrequency}/week</div>
                </div>
                <div class="insight-card">
                    <div class="insight-icon">💰</div>
                    <div class="insight-title">Total Savings</div>
                    <div class="insight-value">₹${estimatedSavings}</div>
                </div>
                <div class="insight-card">
                    <div class="insight-icon">⭐</div>
                    <div class="insight-title">Member Level</div>
                    <div class="insight-value">${totalOrders >= 10 ? 'Gold' : totalOrders >= 5 ? 'Silver' : 'Bronze'}</div>
                </div>
            `;
        }

        function updateFavorites() {
            // Get user's selected favorites from localStorage
            const favoriteKey = `favorites_${currentUser.id}`;
            const favorites = JSON.parse(localStorage.getItem(favoriteKey) || '[]');
            
            const favoritesContainer = document.getElementById('favorites-container');
            
            if (favorites.length === 0) {
                favoritesContainer.innerHTML = `
                    <div style="text-align: center; padding: 40px; color: #666;">
                        <div style="font-size: 3rem; margin-bottom: 15px;">💖</div>
                        <h3>No favorites yet!</h3>
                        <p>Go to the menu and click the ❤️ button on items you love to add them here!</p>
                        <button onclick="goToMenu()" style="background: linear-gradient(to right, #11998e, #38ef7d); color: white; border: none; padding: 12px 24px; border-radius: 8px; cursor: pointer; margin-top: 15px; font-weight: bold;">Browse Menu 🍽️</button>
                    </div>
                `;
                return;
            }
            
            favoritesContainer.innerHTML = favorites.map(item => {
                const addedDate = new Date(item.addedAt).toLocaleDateString();
                
                return `
                    <div class="favorite-item">
                        <div class="favorite-info">
                            <div class="favorite-icon">${item.icon}</div>
                            <div class="favorite-details">
                                <h4>${item.name}</h4>
                                <p>₹${item.price} • Added on ${addedDate}</p>
                            </div>
                        </div>
                        <div style="display: flex; gap: 10px;">
                            <button class="reorder-btn" onclick="reorderItem('${item.name}')">
                                🔄 Reorder
                            </button>
                            <button class="remove-favorite-btn" onclick="removeFavorite('${item.name}')" style="background: linear-gradient(to right, #ff4d4f, #ff6382); color: white; border: none; padding: 8px 16px; border-radius: 6px; cursor: pointer; font-size: 0.9rem; transition: all 0.3s ease;">
                                💔 Remove
                            </button>
                        </div>
                    </div>
                `;
            }).join('');
        }

        function removeFavorite(itemName) {
            showConfirmPopup({
                icon: '💔',
                title: 'Remove Favorite',
                message: `Are you sure you want to remove "${itemName}" from your favorites?`,
                confirmText: 'Yes, Remove',
                confirmType: 'danger',
                cancelText: 'Cancel',
                onConfirm: () => {
                    const favoriteKey = `favorites_${currentUser.id}`;
                    let favorites = JSON.parse(localStorage.getItem(favoriteKey) || '[]');
                    
                    favorites = favorites.filter(fav => fav.name !== itemName);
                    localStorage.setItem(favoriteKey, JSON.stringify(favorites));
                    
                    showSuccessPopup(`${itemName} removed from favorites! 💔`, 'Removed Successfully');
                    updateFavorites();
                }
            });
        }

        function reorderItem(itemName) {
            showSuccessPopup(`Adding ${itemName} to cart! 🛒\n\nRedirecting to menu...`, 'Item Added');
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 2000);
        }

        function displayOrders() {
            const container = document.getElementById('orders-container');
            let filteredOrders = userOrders;
            const totalAllCount = userOrders.length;

            if (currentFilter !== 'all') {
                if (currentFilter === 'history') {
                    filteredOrders = userOrders;
                } else {
                    filteredOrders = userOrders.filter(order => order.status === currentFilter);
                }
            }

            const totalFilteredCount = filteredOrders.length;

            // All Orders: show latest 5 initially, load 5 more each click
            if (currentFilter === 'all') {
                filteredOrders = filteredOrders.slice(0, Math.max(5, visibleOrdersCount));
            }

            // Reset selection if not in history
            if (currentFilter !== 'history') {
                selectedHistoryOrders = new Set();
            }

            if (filteredOrders.length === 0) {
                container.innerHTML = `
                    <div class="empty-orders">
                        <div class="empty-icon">📦</div>
                        <h3>No orders found</h3>
                        <p>You haven't placed any orders yet. Start ordering delicious food!</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = filteredOrders.map(order => `
                <div class="order-item">
                    ${(currentFilter === 'history') ? `
                        <div style="display:flex; align-items:center; justify-content: space-between; gap: 10px; margin-bottom: 10px;">
                            <label style="display:flex; align-items:center; gap:10px; font-weight:900; color:#111827;">
                                ${(order.status === 'delivered' || order.status === 'cancelled') ? `
                                    <input class="hist-check" type="checkbox" data-code="${order.id}" ${selectedHistoryOrders.has(order.id) ? 'checked' : ''} />
                                    <span style="font-size:0.92rem;">Select</span>
                                ` : `
                                    <input type="checkbox" disabled style="opacity:0.5;" />
                                    <span style="font-size:0.92rem; opacity:0.7;">Not deletable</span>
                                `}
                            </label>
                            <span style="font-size:0.85rem; font-weight:900; color:#6b7280;">${order.status.toUpperCase()}</span>
                        </div>
                    ` : ''}
                    <div class="order-header">
                        <div>
                            <div class="order-id">Order #${order.id}</div>
                            <div class="order-date">${new Date(order.date).toLocaleDateString()}</div>
                        </div>
                        <div class="order-status status-${order.status}">
                            ${order.status.charAt(0).toUpperCase() + order.status.slice(1)}
                        </div>
                    </div>
                    ${order.status === 'shifted' ? `
                        <div style="margin-top:10px; padding:10px 12px; border-radius:14px; background: rgba(72, 219, 251, 0.10); border: 1px solid rgba(72, 219, 251, 0.18); color: #155e75; font-weight: 800;">
                            Estimated delivery: <span class="eta-countdown" data-minutes="${(order.delivery_eta_minutes && Number(order.delivery_eta_minutes) > 0) ? Number(order.delivery_eta_minutes) : 45}" data-setat="${order.delivery_eta_set_at || ''}" style="font-weight: 900;"></span>
                        </div>
                    ` : ''}
                    ${order.status === 'cancelled' && order.cancel_reason ? `
                        <div style="margin-top:10px; padding:10px 12px; border-radius:14px; background: rgba(255, 77, 79, 0.10); border: 1px solid rgba(255, 77, 79, 0.18); color: #b91c1c; font-weight: 700;">
                            Cancelled${order.cancelled_by ? ` (by ${order.cancelled_by})` : ''}: <span style="font-weight: 800;">${order.cancel_reason}</span>
                        </div>
                    ` : ''}
                    <div class="order-items">
                        ${order.items.map(item => `
                            <div class="order-item-row">
                                <span>${item.name} x${item.quantity}</span>
                                <span>₹${item.price * item.quantity}</span>
                            </div>
                        `).join('')}
                    </div>
                    <div class="order-total">Total: ₹${order.total}</div>
                    <div style="display:flex; justify-content: space-between; align-items:center; margin-top:10px;">
                        <small style="color:#6b7280;">Confirmed order stored in your history.</small>
                        ${(order.status !== 'delivered' && order.status !== 'cancelled') ? `
                            <button type="button" onclick="cancelOrder('${order.id}')" style="background: linear-gradient(to right, #ff4d4f, #ff6382); color: white; border: none; padding: 8px 14px; border-radius: 999px; cursor: pointer; font-size: 0.85rem; font-weight: bold;">
                                Cancel Order
                            </button>
                        ` : ''}
                        ${(currentFilter === 'history' && (order.status === 'delivered' || order.status === 'cancelled')) ? `
                            <button type="button" onclick="deleteDeliveredOrder('${order.id}')" style="background: linear-gradient(to right, #111827, #374151); color: white; border: none; padding: 8px 14px; border-radius: 999px; cursor: pointer; font-size: 0.85rem; font-weight: bold;">
                                Delete
                            </button>
                        ` : ''}
                    </div>
                </div>
            `).join('');

            if (currentFilter === 'history') {
                const deletableTotal = userOrders.filter(o => o.status === 'delivered' || o.status === 'cancelled').length;
                container.innerHTML = `
                    <div style="display:flex; flex-wrap: wrap; gap: 10px; align-items:center; justify-content: space-between; margin-bottom: 14px; padding: 12px 12px; border-radius: 16px; background: rgba(17, 153, 142, 0.08); border: 1px solid rgba(17, 153, 142, 0.14);">
                        <div style="font-weight:900; color:#0f172a;">History Tools</div>
                        <div style="display:flex; flex-wrap: wrap; gap: 10px; align-items:center;">
                            <button type="button" onclick="toggleSelectAllHistory()" style="background: white; color: #0f172a; border: 2px solid #11998e; padding: 8px 14px; border-radius: 999px; cursor: pointer; font-weight: 900;">Select All</button>
                            <button type="button" onclick="deleteSelectedHistory()" style="background: linear-gradient(to right, #111827, #374151); color: white; border: none; padding: 8px 14px; border-radius: 999px; cursor: pointer; font-weight: 900;">Delete Selected (${selectedHistoryOrders.size})</button>
                            <span style="color:#64748b; font-weight:800; font-size:0.9rem;">Deletable: ${deletableTotal}</span>
                        </div>
                    </div>
                ` + container.innerHTML;

                // Bind checkbox changes
                document.querySelectorAll('.hist-check').forEach(cb => {
                    cb.addEventListener('change', function () {
                        const code = cb.getAttribute('data-code');
                        if (!code) return;
                        if (cb.checked) selectedHistoryOrders.add(code);
                        else selectedHistoryOrders.delete(code);
                        const btn = document.querySelector('button[onclick="deleteSelectedHistory()"]');
                        if (btn) btn.textContent = `Delete Selected (${selectedHistoryOrders.size})`;
                    });
                });
            }

            if (currentFilter === 'all' && totalAllCount > filteredOrders.length) {
                container.innerHTML += `
                    <div style="display:flex; justify-content:center; margin-top:16px;">
                        <button type="button" onclick="seeMoreOrders()" style="background: linear-gradient(to right, #11998e, #38ef7d); color: white; border: none; padding: 10px 18px; border-radius: 999px; cursor: pointer; font-size: 0.9rem; font-weight: 900; box-shadow: 0 12px 24px rgba(17, 153, 142, 0.22);">
                            See More
                        </button>
                    </div>
                `;
            }

            initEtaCountdowns();
        }

        function toggleSelectAllHistory() {
            if (!currentUser) return;
            const deletable = userOrders.filter(o => o.status === 'delivered' || o.status === 'cancelled').map(o => o.id);
            const allSelected = deletable.length > 0 && deletable.every(id => selectedHistoryOrders.has(id));

            selectedHistoryOrders = new Set();
            if (!allSelected) {
                deletable.forEach(id => selectedHistoryOrders.add(id));
            }
            displayOrders();
        }

        function deleteSelectedHistory() {
            if (!currentUser) return;
            const codes = Array.from(selectedHistoryOrders);
            if (codes.length === 0) {
                showInfoPopup('Select at least one delivered/cancelled order to delete.', 'Nothing Selected');
                return;
            }

            showConfirmPopup({
                icon: '🗑',
                title: 'Delete Selected Orders',
                message: `Delete ${codes.length} selected orders from database? This cannot be undone.`,
                confirmText: 'Delete',
                confirmType: 'danger',
                cancelText: 'Cancel',
                onConfirm: () => {
                    const formData = new FormData();
                    formData.append('user_id', currentUser.id);
                    codes.forEach(c => formData.append('order_codes[]', c));

                    fetch('../backend/user_delete_order.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (!data || !data.success) {
                            showErrorPopup((data && data.message) ? data.message : 'Delete failed.', 'Delete Failed');
                            return;
                        }

                        selectedHistoryOrders = new Set();
                        loadOrdersFromServer(currentUser.id).then(() => {
                            updateStats();
                            updateLoyaltyPoints();
                            updateInsights();
                            updateFavorites();
                            displayOrders();
                        });
                        showSuccessPopup(`Deleted ${data.deleted_count || codes.length} orders.`, 'Deleted');
                    })
                    .catch(() => {
                        showErrorPopup('Network error while deleting orders.', 'Delete Failed');
                    });
                }
            });
        }

        function seeMoreOrders() {
            visibleOrdersCount += 5;
            displayOrders();
        }

        let etaCountdownTimer = null;

        function parseMysqlDateTime(dt) {
            if (!dt) return null;
            // MySQL: YYYY-MM-DD HH:MM:SS -> make it ISO-like for better parsing
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

        function cancelOrder(orderCode) {
            if (!currentUser) return;

            const reasonHtml = `
                <div style="text-align:left;">
                    <div style="font-weight:800; margin-bottom:8px;">Why are you cancelling?</div>
                    <textarea id="cancel-reason" rows="3" style="width:100%; padding:10px 12px; border-radius:14px; border:1px solid rgba(17,24,39,0.12); outline:none; font-size:0.95rem; resize: vertical;" placeholder="Write your cancel reason (required)"></textarea>
                </div>
            `;

            showCustomPopup({
                icon: '⚠️',
                title: 'Cancel Order',
                message: reasonHtml,
                allowHtml: true,
                buttons: [
                    { text: 'Back', type: 'secondary' },
                    {
                        text: 'Confirm Cancel',
                        type: 'danger',
                        action: () => {
                            const el = document.getElementById('cancel-reason');
                            const reason = el ? (el.value || '').trim() : '';
                            if (!reason) {
                                showErrorPopup('Cancel reason is required.', 'Missing Reason');
                                return;
                            }

                            const formData = new FormData();
                            formData.append('user_id', currentUser.id);
                            formData.append('order_code', orderCode);
                            formData.append('cancel_reason', reason);

                            fetch('../backend/user_cancel_order.php', {
                                method: 'POST',
                                body: formData,
                            })
                            .then(r => r.json())
                            .then(data => {
                                if (!data || !data.success) {
                                    showErrorPopup((data && data.message) ? data.message : 'Cancel failed.', 'Cancel Failed');
                                    return;
                                }

                                // Reload DB orders
                                loadOrdersFromServer(currentUser.id).then(() => {
                                    updateStats();
                                    updateLoyaltyPoints();
                                    updateInsights();
                                    updateFavorites();
                                    displayOrders();
                                });
                                showSuccessPopup('Order cancelled successfully.', 'Cancelled');
                            })
                            .catch(() => {
                                showErrorPopup('Network error while cancelling order.', 'Cancel Failed');
                            });
                        }
                    }
                ]
            });
        }

        function deleteOrder(orderId) {
            if (!currentUser) return;

            showInfoPopup('Order delete is disabled. Your dashboard shows only database orders.', 'Not Allowed');
        }

        function deleteDeliveredOrder(orderCode) {
            if (!currentUser) return;

            showConfirmPopup({
                icon: '🗑',
                title: 'Delete Delivered Order',
                message: `Delete order #${orderCode} from history? This will remove it from database.`,
                confirmText: 'Delete',
                confirmType: 'danger',
                cancelText: 'Cancel',
                onConfirm: () => {
                    const formData = new FormData();
                    formData.append('user_id', currentUser.id);
                    formData.append('order_code', orderCode);

                    fetch('../backend/user_delete_order.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(r => r.json())
                    .then(data => {
                        if (!data || !data.success) {
                            showErrorPopup((data && data.message) ? data.message : 'Delete failed.', 'Delete Failed');
                            return;
                        }

                        loadOrdersFromServer(currentUser.id).then(() => {
                            updateStats();
                            updateLoyaltyPoints();
                            updateInsights();
                            updateFavorites();
                            displayOrders();
                        });

                        showSuccessPopup('Order deleted from history.', 'Deleted');
                    })
                    .catch(() => {
                        showErrorPopup('Network error while deleting order.', 'Delete Failed');
                    });
                }
            });
        }

        function filterOrders(event, filter) {
            currentFilter = filter;
            visibleOrdersCount = 5;
            
            // Update active button
            document.querySelectorAll('.filter-btn').forEach(btn => btn.classList.remove('active'));
            if (event && event.target) {
                event.target.classList.add('active');
            }
            
            displayOrders();
        }

        function goToMenu() {
            window.location.href = 'index.php';
        }

        function reorderFavorite() {
            if (userOrders.length === 0) {
                showErrorPopup('No previous orders found! Please place an order first.', 'No Orders');
                return;
            }
            
            // Find most recent order
            const lastOrder = userOrders[userOrders.length - 1];
            showSuccessPopup(`Reordering: ${lastOrder.items.map(item => item.name).join(', ')}\nTotal: ₹${lastOrder.total}\n\nRedirecting to menu...`, '🔄 Reordering');
            
            setTimeout(() => {
                window.location.href = 'index.php';
            }, 2000);
        }

        function openProfileEditModal() {
            if (!currentUser) return;
            const overlay = document.getElementById('profile-edit-overlay');
            const nameInput = document.getElementById('edit-name');
            const phoneInput = document.getElementById('edit-phone');
            const addressInput = document.getElementById('edit-address');
            const pinInput = document.getElementById('edit-pin');

            if (nameInput) nameInput.value = currentUser.name || '';
            if (phoneInput) phoneInput.value = currentUser.phone || '';
            if (addressInput) addressInput.value = currentUser.address || '';
            if (pinInput) pinInput.value = currentUser.pin || '';

            if (overlay) overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeProfileEditModal() {
            const overlay = document.getElementById('profile-edit-overlay');
            if (overlay) overlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function saveProfileEdits() {
            if (!currentUser) return;
            const nameInput = document.getElementById('edit-name');
            const phoneInput = document.getElementById('edit-phone');
            const addressInput = document.getElementById('edit-address');
            const pinInput = document.getElementById('edit-pin');

            const newName = nameInput ? nameInput.value.trim() : '';
            const newPhone = phoneInput ? phoneInput.value.trim() : '';
            const newAddress = addressInput ? addressInput.value.trim() : '';
            const newPin = pinInput ? pinInput.value.trim() : '';

            let changed = false;

            if (newName && newName !== currentUser.name) {
                currentUser.name = newName;
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
                let users = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
                const userIndex = users.findIndex(u => u.email === currentUser.email);
                if (userIndex !== -1) {
                    users[userIndex].name = newName;
                    localStorage.setItem('foodDeliveryUsers', JSON.stringify(users));
                }
                updateWelcomeMessage();
                changed = true;
            }

            if (newPhone && newPhone !== currentUser.phone) {
                currentUser.phone = newPhone;
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
                let users = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
                const userIndex = users.findIndex(u => u.email === currentUser.email);
                if (userIndex !== -1) {
                    users[userIndex].phone = newPhone;
                    localStorage.setItem('foodDeliveryUsers', JSON.stringify(users));
                }
                changed = true;
            }

            if (newAddress && newAddress !== currentUser.address) {
                currentUser.address = newAddress;
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
                let users = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
                const userIndex = users.findIndex(u => u.email === currentUser.email);
                if (userIndex !== -1) {
                    users[userIndex].address = newAddress;
                    localStorage.setItem('foodDeliveryUsers', JSON.stringify(users));
                }
                changed = true;
            }

            if (newPin && newPin !== currentUser.pin) {
                currentUser.pin = newPin;
                localStorage.setItem('currentUser', JSON.stringify(currentUser));
                let users = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
                const userIndex = users.findIndex(u => u.email === currentUser.email);
                if (userIndex !== -1) {
                    users[userIndex].pin = newPin;
                    localStorage.setItem('foodDeliveryUsers', JSON.stringify(users));
                }
                changed = true;
            }

            if (changed) {
                updateProfileInfo();
                showSuccessPopup('Profile updated successfully! 🎉', 'Profile Updated');

                if (currentUser && currentUser.id) {
                    const formData = new FormData();
                    formData.append('id', currentUser.id);
                    formData.append('name', currentUser.name || '');
                    formData.append('phone', currentUser.phone || '');
                    formData.append('address', currentUser.address || '');
                    formData.append('pin', currentUser.pin || '');

                    fetch('../backend/update_profile.php', {
                        method: 'POST',
                        body: formData,
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data || !data.success) {
                            const msg = data && data.message ? data.message : 'Could not save changes to server.';
                            showErrorPopup(msg, 'Server Update Failed');
                        }
                    })
                    .catch(() => {
                        showErrorPopup('Could not connect to server to save profile changes.', 'Network Error');
                    });
                }
            }

            closeProfileEditModal();
        }

        function contactSupport() {
            showInfoPopup('Phone: +91 98765 43210\nEmail: support@fooddelivery.com\n\nWe are available 24/7 to help you! 😊', '📞 Support Contact');
        }

        function openAvatarModal() {
            const overlay = document.getElementById('avatar-modal-overlay');
            const fileInput = document.getElementById('avatar-file-input');
            const zoomInput = document.getElementById('avatar-zoom');
            avatarCanvas = document.getElementById('avatar-canvas');
            avatarCtx = avatarCanvas ? avatarCanvas.getContext('2d') : null;
            avatarImage = null;
            avatarScale = 1;
            if (fileInput) fileInput.value = '';
            if (zoomInput) zoomInput.value = '1';
            if (overlay) overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
            if (currentUser && currentUser.avatar) {
                const img = new Image();
                img.onload = function() {
                    avatarImage = img;
                    drawAvatar();
                };
                img.src = currentUser.avatar;
            } else if (avatarCtx && avatarCanvas) {
                avatarCtx.clearRect(0, 0, avatarCanvas.width, avatarCanvas.height);
            }
        }

        function closeAvatarModal() {
            const overlay = document.getElementById('avatar-modal-overlay');
            if (overlay) overlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function handleAvatarFileChange(event) {
            const files = event.target.files || [];
            const file = files[0];
            if (!file) return;
            if (file.size > 50 * 1024 * 1024) {
                showErrorPopup('Profile picture is too large. Please choose an image up to 50 MB.', 'File Too Large');
                event.target.value = '';
                return;
            }
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    avatarImage = img;
                    avatarScale = 1;
                    const zoomInput = document.getElementById('avatar-zoom');
                    if (zoomInput) zoomInput.value = '1';
                    drawAvatar();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function onAvatarZoomChange(event) {
            const value = parseFloat(event.target.value);
            if (!isNaN(value)) {
                avatarScale = value;
                drawAvatar();
            }
        }

        function drawAvatar() {
            if (!avatarImage || !avatarCanvas || !avatarCtx) return;
            const size = avatarCanvas.width;
            avatarCtx.clearRect(0, 0, size, size);
            avatarCtx.save();
            avatarCtx.beginPath();
            avatarCtx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
            avatarCtx.closePath();
            avatarCtx.clip();
            const imgRatio = avatarImage.width / avatarImage.height;
            let drawWidth;
            let drawHeight;
            const scale = avatarScale;
            if (imgRatio > 1) {
                drawHeight = size * scale;
                drawWidth = drawHeight * imgRatio;
            } else {
                drawWidth = size * scale;
                drawHeight = drawWidth / imgRatio;
            }
            const dx = (size - drawWidth) / 2;
            const dy = (size - drawHeight) / 2;
            avatarCtx.drawImage(avatarImage, dx, dy, drawWidth, drawHeight);
            avatarCtx.restore();
        }

        function saveAvatar() {
            if (!currentUser || !avatarCanvas || !avatarCtx || !avatarImage) {
                closeAvatarModal();
                return;
            }
            const dataUrl = avatarCanvas.toDataURL('image/png');
            currentUser.avatar = dataUrl;
            localStorage.setItem('currentUser', JSON.stringify(currentUser));
            let users = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
            const index = users.findIndex(u => u.email === currentUser.email);
            if (index !== -1) {
                users[index].avatar = dataUrl;
                localStorage.setItem('foodDeliveryUsers', JSON.stringify(users));
            }
            updateDashboardAvatar();
            showSuccessPopup('Profile picture updated successfully.', 'Profile Updated');
            closeAvatarModal();
        }

        // Add order to history (called from main page after checkout)
        function addOrderToHistory(orderData) {
            userOrders.push(orderData);
            localStorage.setItem(`orders_${currentUser.id}`, JSON.stringify(userOrders));
            updateStats();
            displayOrders();
        }

        // Initialize dashboard
        window.onload = function() {
            loadUserData();
        };
    </script>
</body>
</html>
