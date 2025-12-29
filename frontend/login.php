<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Online Food Delivery</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        /* Animated Background Elements */
        .bg-animation {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .floating-shape {
            position: absolute;
            opacity: 0.1;
            animation: floatUpDown 6s ease-in-out infinite;
        }

        .shape-1 {
            top: 10%;
            left: 10%;
            width: 80px;
            height: 80px;
            background: linear-gradient(45deg, #ff6b6b, #feca57);
            border-radius: 50%;
            animation-delay: 0s;
        }

        .shape-2 {
            top: 20%;
            right: 15%;
            width: 60px;
            height: 60px;
            background: linear-gradient(45deg, #48dbfb, #0abde3);
            border-radius: 20px;
            animation-delay: 2s;
            animation-duration: 8s;
        }

        .shape-3 {
            bottom: 20%;
            left: 15%;
            width: 100px;
            height: 100px;
            background: linear-gradient(45deg, #ff9ff3, #f368e0);
            border-radius: 30px;
            animation-delay: 4s;
            animation-duration: 10s;
        }

        .shape-4 {
            bottom: 10%;
            right: 10%;
            width: 70px;
            height: 70px;
            background: linear-gradient(45deg, #54a0ff, #2e86de);
            border-radius: 50%;
            animation-delay: 1s;
            animation-duration: 7s;
        }

        /* Enhanced Background Elements */
        .floating-particles {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .particle {
            position: absolute;
            border-radius: 50%;
            animation: particleFloat 20s linear infinite;
        }

        .particle:nth-child(1) { left: 5%; animation-delay: 0s; width: 6px; height: 6px; background: rgba(255, 107, 107, 0.3); }
        .particle:nth-child(2) { left: 15%; animation-delay: 2s; width: 8px; height: 8px; background: rgba(72, 219, 251, 0.3); }
        .particle:nth-child(3) { left: 25%; animation-delay: 4s; width: 4px; height: 4px; background: rgba(255, 159, 243, 0.3); }
        .particle:nth-child(4) { left: 35%; animation-delay: 6s; width: 7px; height: 7px; background: rgba(84, 160, 255, 0.3); }
        .particle:nth-child(5) { left: 45%; animation-delay: 8s; width: 5px; height: 5px; background: rgba(254, 202, 87, 0.3); }
        .particle:nth-child(6) { left: 55%; animation-delay: 10s; width: 9px; height: 9px; background: rgba(56, 239, 125, 0.3); }
        .particle:nth-child(7) { left: 65%; animation-delay: 12s; width: 4px; height: 4px; background: rgba(255, 111, 97, 0.3); }
        .particle:nth-child(8) { left: 75%; animation-delay: 14s; width: 6px; height: 6px; background: rgba(17, 153, 142, 0.3); }
        .particle:nth-child(9) { left: 85%; animation-delay: 16s; width: 5px; height: 5px; background: rgba(255, 107, 107, 0.3); }
        .particle:nth-child(10) { left: 95%; animation-delay: 18s; width: 7px; height: 7px; background: rgba(72, 219, 251, 0.3); }

        /* Food Icon Elements */
        .food-icons {
            position: absolute;
            width: 100%;
            height: 100%;
            font-size: 2rem;
            opacity: 0.1;
        }

        .food-icon {
            position: absolute;
            animation: foodFloat 25s ease-in-out infinite;
        }

        .food-icon:nth-child(1) { top: 15%; left: 5%; animation-delay: 0s; }
        .food-icon:nth-child(2) { top: 25%; right: 8%; animation-delay: 5s; }
        .food-icon:nth-child(3) { bottom: 30%; left: 10%; animation-delay: 10s; }
        .food-icon:nth-child(4) { bottom: 15%; right: 12%; animation-delay: 15s; }
        .food-icon:nth-child(5) { top: 40%; left: 3%; animation-delay: 20s; }

        /* Geometric Waves */
        .wave-container {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .wave {
            position: absolute;
            width: 200%;
            height: 200px;
            background: linear-gradient(45deg, rgba(17, 153, 142, 0.05), rgba(56, 239, 125, 0.05));
            border-radius: 50%;
            animation: waveMove 20s ease-in-out infinite;
        }

        .wave:nth-child(1) { top: 10%; left: -50%; animation-delay: 0s; }
        .wave:nth-child(2) { top: 60%; left: -50%; animation-delay: 10s; }
        .wave:nth-child(3) { bottom: 20%; left: -50%; animation-delay: 5s; }

        /* Rotating Elements */
        .rotating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
        }

        .rotating-shape {
            position: absolute;
            width: 40px;
            height: 40px;
            border: 2px solid rgba(255, 255, 255, 0.1);
            animation: rotateFloat 15s linear infinite;
        }

        .rotating-shape:nth-child(1) { 
            top: 20%; 
            left: 20%; 
            border-radius: 50%; 
            animation-delay: 0s; 
        }
        .rotating-shape:nth-child(2) { 
            top: 70%; 
            right: 25%; 
            border-radius: 10px; 
            animation-delay: 5s; 
        }
        .rotating-shape:nth-child(3) { 
            bottom: 25%; 
            left: 25%; 
            border-radius: 20px; 
            animation-delay: 10s; 
        }

        @keyframes floatUpDown {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-30px) rotate(180deg); }
        }

        @keyframes particleFloat {
            0% { transform: translateY(100vh) rotate(0deg); opacity: 0; }
            10% { opacity: 0.3; }
            90% { opacity: 0.3; }
            100% { transform: translateY(-100vh) rotate(360deg); opacity: 0; }
        }

        @keyframes foodFloat {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            25% { transform: translateY(-20px) rotate(90deg) scale(1.1); }
            50% { transform: translateY(-10px) rotate(180deg) scale(0.9); }
            75% { transform: translateY(-25px) rotate(270deg) scale(1.05); }
        }

        @keyframes waveMove {
            0% { transform: translateX(0) rotate(0deg); }
            50% { transform: translateX(50px) rotate(180deg); }
            100% { transform: translateX(0) rotate(360deg); }
        }

        @keyframes rotateFloat {
            0% { transform: rotate(0deg) translateY(0px); }
            25% { transform: rotate(90deg) translateY(-15px); }
            50% { transform: rotate(180deg) translateY(-5px); }
            75% { transform: rotate(270deg) translateY(-20px); }
            100% { transform: rotate(360deg) translateY(0px); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            50% { transform: translateY(-20px) rotate(1deg); }
        }

        .auth-container {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-radius: 25px;
            padding: 40px;
            width: 100%;
            max-width: 450px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            animation: slideUp 0.8s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .auth-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, #11998e, #38ef7d, #ff9f43, #ff6f61);
            border-radius: 25px 25px 0 0;
        }

        .logo-section {
            text-align: center;
            margin-bottom: 35px;
        }

        .logo-icon {
            font-size: 4rem;
            margin-bottom: 15px;
            display: block;
            animation: bounce 2s ease-in-out infinite;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .logo-text {
            font-size: 1.8rem;
            font-weight: bold;
            background: linear-gradient(45deg, #11998e, #38ef7d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 8px;
        }

        .logo-subtitle {
            color: #666;
            font-size: 0.95rem;
        }

        .form-toggle {
            display: flex;
            background: #f8f9fa;
            border-radius: 15px;
            padding: 6px;
            margin-bottom: 30px;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .toggle-btn {
            flex: 1;
            padding: 14px;
            text-align: center;
            border: none;
            background: transparent;
            cursor: pointer;
            border-radius: 12px;
            font-weight: 600;
            font-size: 0.95rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .toggle-btn.active {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.4);
            transform: translateY(-1px);
        }

        .form-section {
            display: none;
            opacity: 0;
            transform: translateX(30px);
            transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-section.active {
            display: block;
            opacity: 1;
            transform: translateX(0);
            animation: slideInFade 0.6s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .form-section.slide-out {
            opacity: 0;
            transform: translateX(-30px);
        }

        @keyframes slideInFade {
            0% { 
                opacity: 0; 
                transform: translateX(30px) scale(0.95); 
            }
            100% { 
                opacity: 1; 
                transform: translateX(0) scale(1); 
            }
        }


        .form-title {
            text-align: center;
            margin-bottom: 25px;
            font-size: 1.4rem;
            color: #333;
            font-weight: 600;
        }

        .form-group {
            margin-bottom: 20px;
            position: relative;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
            font-size: 0.9rem;
        }

        .input-container {
            position: relative;
        }

        .input-container {
            position: relative;
            margin-bottom: 5px;
        }

        .input-icon {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 1.2rem;
            color: #999;
            transition: all 0.3s ease;
            z-index: 2;
        }

        .form-group input {
            width: 100%;
            padding: 18px 24px 18px 55px;
            border: 3px solid transparent;
            border-radius: 16px;
            font-size: 1rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 
                0 8px 32px rgba(17, 153, 142, 0.1),
                0 4px 16px rgba(56, 239, 125, 0.08),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            position: relative;
            backdrop-filter: blur(10px);
        }

        .input-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #11998e, #38ef7d, #ff9f43, #ff6f61);
            border-radius: 16px;
            padding: 3px;
            z-index: -1;
            transition: all 0.4s ease;
        }

        .input-container::after {
            content: '';
            position: absolute;
            top: 3px;
            left: 3px;
            right: 3px;
            bottom: 3px;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 13px;
            z-index: -1;
        }

        .form-group input:hover {
            box-shadow: 
                0 12px 40px rgba(17, 153, 142, 0.2),
                0 8px 24px rgba(56, 239, 125, 0.15),
                0 0 0 1px rgba(17, 153, 142, 0.3),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            transform: translateY(-3px);
        }

        .form-group input:hover + .input-icon {
            color: #11998e;
            transform: translateY(-50%) scale(1.1);
        }

        .form-group input:focus {
            outline: none;
            box-shadow: 
                0 16px 48px rgba(17, 153, 142, 0.25),
                0 12px 32px rgba(56, 239, 125, 0.2),
                0 0 0 4px rgba(17, 153, 142, 0.2),
                inset 0 2px 4px rgba(17, 153, 142, 0.1);
            background: white;
            transform: translateY(-4px);
        }

        .form-group input:focus + .input-icon {
            color: #11998e;
            transform: translateY(-50%) scale(1.2);
        }

        .input-container:hover::before {
            background: linear-gradient(135deg, #11998e, #38ef7d, #ff9f43, #ff6f61, #11998e);
            background-size: 200% 200%;
            animation: gradientShift 2s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .form-group input::placeholder {
            color: #aaa;
        }

        .password-strength {
            margin-top: 6px;
        }

        .password-strength-bar {
            width: 100%;
            position: relative;
            padding: 8px 4px 4px 4px;
        }

        .password-strength-steps {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .password-strength-steps::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 0;
            right: 0;
            height: 3px;
            background: #d1d5db;
            transform: translateY(-50%);
        }

        .password-step {
            position: relative;
            z-index: 1;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            border: 2px solid #d1d5db;
            background: #f9fafb;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.25s ease, background-color 0.25s ease;
        }

        .password-step-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: transparent;
            transition: background-color 0.25s ease;
        }

        .password-step.active {
            border-color: #22c55e;
            background: #ecfdf3;
        }

        .password-step.active .password-step-dot {
            background: #22c55e;
        }

        .password-strength-text {
            margin-top: 4px;
            font-size: 0.8rem;
            color: #4b5563;
            font-weight: 600;
        }

        .password-strong-check {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 0.75rem;
            background: #22c55e;
            color: #ffffff;
            box-shadow: 0 0 0 2px #bbf7d0, 0 4px 8px rgba(0,0,0,0.2);
        }

        .password-toggle {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            font-size: 0.95rem;
            color: #9ca3af;
            z-index: 3;
            user-select: none;
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .password-toggle:hover {
            color: #111827;
            transform: translateY(-50%) scale(1.05);
        }

        .password-requirements {
            margin-top: 8px;
            font-size: 0.78rem;
            color: #6b7280;
        }

        .password-requirements-title {
            font-weight: 600;
            margin-bottom: 4px;
        }

        .password-req-list {
            list-style: none;
            padding-left: 0;
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 2px 10px;
        }

        .password-req-item {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .password-req-icon {
            font-size: 0.75rem;
            color: #9ca3af;
        }

        .password-req-text {
            color: #9ca3af;
        }

        .password-req-item.ok .password-req-icon {
            color: #16a34a;
        }

        .password-req-item.ok .password-req-text {
            color: #16a34a;
            font-weight: 500;
        }

        .avatar-preview-circle {
            width: 160px;
            height: 160px;
            border-radius: 50%;
            background: #f3f4f6;
            margin: 10px auto 10px auto;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }

        #register-avatar-canvas {
            width: 160px;
            height: 160px;
        }

        .avatar-range {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 8px;
        }

        .avatar-range input[type="range"] {
            flex: 1;
        }

        .help-text {
            display: block;
            margin-top: 4px;
            font-size: 0.8rem;
            color: #777;
        }

        .submit-btn {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            padding: 16px 30px;
            border: none;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
            position: relative;
            overflow: hidden;
        }

        .submit-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: left 0.5s;
        }

        .submit-btn:hover::before {
            left: 100%;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.4);
        }

        .submit-btn:active {
            transform: translateY(0);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #11998e;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .forgot-password a:hover {
            color: #0c8976;
            text-decoration: underline;
        }

        .divider {
            display: flex;
            align-items: center;
            margin: 25px 0;
            color: #999;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: #e1e5e9;
        }

        .divider span {
            padding: 0 15px;
            font-size: 0.9rem;
        }

        .back-link {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e1e5e9;
        }

        .back-link a {
            color: #11998e;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .back-link a:hover {
            color: #0c8976;
            transform: translateX(-3px);
        }

        .success-message, .error-message {
            padding: 15px 20px;
            border-radius: 12px;
            margin-bottom: 20px;
            display: none;
            font-weight: 500;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .success-message {
            background: linear-gradient(135deg, #d4edda, #c3e6cb);
            color: #155724;
            border-left: 4px solid #28a745;
        }

        .error-message {
            background: linear-gradient(135deg, #f8d7da, #f1b0b7);
            color: #721c24;
            border-left: 4px solid #dc3545;
        }

        /* Mobile Responsive Design */
        @media (max-width: 768px) {
            body {
                padding: 15px;
            }
            
            .auth-container {
                padding: 30px 25px;
                margin: 10px;
            }
            
            .logo-icon {
                font-size: 3rem;
            }
            
            .logo-text {
                font-size: 1.5rem;
            }
            
            .form-group input {
                padding: 14px 18px;
            }
            
            .submit-btn {
                padding: 14px 25px;
            }
        }

        @media (max-width: 480px) {
            .auth-container {
                padding: 25px 20px;
            }
            
            .logo-icon {
                font-size: 2.5rem;
            }
            
            .logo-text {
                font-size: 1.3rem;
            }
            
            .toggle-btn {
                padding: 12px;
                font-size: 0.9rem;
            }
            
            .form-group input {
                padding: 12px 16px;
                font-size: 0.95rem;
            }
            
            .submit-btn {
                padding: 12px 20px;
                font-size: 1rem;
            }
        }

        /* Landscape mobile */
        @media (max-height: 600px) and (orientation: landscape) {
            body {
                padding: 10px;
            }
            
            .auth-container {
                padding: 20px;
                margin: 5px;
            }
            
            .logo-section {
                margin-bottom: 20px;
            }
            
            .logo-icon {
                font-size: 2rem;
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>
    <!-- Enhanced Animated Background -->
    <div class="bg-animation">
        <div class="floating-shape shape-1"></div>
        <div class="floating-shape shape-2"></div>
        <div class="floating-shape shape-3"></div>
        <div class="floating-shape shape-4"></div>
        
        <div class="floating-particles">
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
            <div class="particle"></div>
        </div>
        
        <div class="food-icons">
            <div class="food-icon">🍕</div>
            <div class="food-icon">🍔</div>
            <div class="food-icon">🍜</div>
            <div class="food-icon">🥗</div>
            <div class="food-icon">🍰</div>
        </div>
        
        <div class="wave-container">
            <div class="wave"></div>
            <div class="wave"></div>
            <div class="wave"></div>
        </div>
        
        <div class="rotating-elements">
            <div class="rotating-shape"></div>
            <div class="rotating-shape"></div>
            <div class="rotating-shape"></div>
        </div>
    </div>

    <div class="auth-container">
        <div class="logo-section">
            <div class="logo-icon">🍽️</div>
            <div class="logo-text">Food Delivery</div>
            <div class="logo-subtitle">Delicious meals at your doorstep</div>
        </div>

        <div id="success-message" class="success-message"></div>
        <div id="error-message" class="error-message"></div>
        
        <div class="form-toggle">
            <button class="toggle-btn active" onclick="showLogin()">Login</button>
            <button class="toggle-btn" onclick="showRegister()">Create Account</button>
        </div>

        <!-- Login Form -->
        <div id="login-form" class="form-section active">
            <div class="form-title">Welcome Back! 🎉</div>
            <form onsubmit="handleLogin(event)">
                <div class="form-group">
                    <label for="login-email">Email Address</label>
                    <div class="input-container">
                        <input type="email" id="login-email" name="email" placeholder="Enter your email" required>
                        <div class="input-icon">📧</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="login-password">Password</label>
                    <div class="input-container">
                        <input type="password" id="login-password" name="password" placeholder="Enter your password" required>
                        <div class="input-icon">🔒</div>
                        <div class="password-toggle" onclick="togglePasswordVisibility('login-password', this)">👁️</div>
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Login 🚀</button>
            </form>
            
            <div class="forgot-password">
                <a href="#" onclick="showForgotPassword()">Forgot Password?</a>
            </div>
            <div class="forgot-password">
                <a href="admin.php">Admin Login</a>
            </div>
        </div>

        <!-- Register Form -->
        <div id="register-form" class="form-section">
            <div class="form-title">Join Our Food Family! 🍽️</div>
            <form onsubmit="handleRegister(event)">
                <div class="form-group">
                    <label for="register-name">Full Name</label>
                    <div class="input-container">
                        <input type="text" id="register-name" name="name" placeholder="Enter your full name" required>
                        <div class="input-icon">👤</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="register-email">Email Address</label>
                    <div class="input-container">
                        <input type="email" id="register-email" name="email" placeholder="Enter your email" required>
                        <div class="input-icon">📧</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="register-phone">Phone Number</label>
                    <div class="input-container">
                        <input type="tel" id="register-phone" name="phone" placeholder="Enter your phone number" required>
                        <div class="input-icon">
📱</div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="register-address">Full Address</label>
                    <div class="input-container">
                        <input type="text" id="register-address" name="address" placeholder="House / Flat, Street, Area, City" required>
                        <div class="input-icon">
                            📍
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="register-pin">PIN Code</label>
                    <div class="input-container">
                        <input type="text" id="register-pin" name="pin" placeholder="Enter your area PIN" required>
                        <div class="input-icon">
                            🏷️
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="register-password">Password</label>
                    <div class="input-container">
                        <input type="password" id="register-password" name="password" placeholder="Create a password (min 6 characters)" required minlength="6">
                        <div class="input-icon">🔒</div>
                        <div class="password-toggle" onclick="togglePasswordVisibility('register-password', this)">👁️</div>
                    </div>
                    <div class="password-strength">
                        <div class="password-strength-bar">
                            <div class="password-strength-steps">
                                <div class="password-step" data-step="1"><div class="password-step-dot"></div></div>
                                <div class="password-step" data-step="2"><div class="password-step-dot"></div></div>
                                <div class="password-step" data-step="3"><div class="password-step-dot"></div></div>
                                <div class="password-step" data-step="4"><div class="password-step-dot"></div></div>
                                <div class="password-step" data-step="5"><div class="password-step-dot"></div></div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-top:4px;">
                            <div id="register-password-strength-text" class="password-strength-text">Password strength</div>
                            <div id="register-password-strong-check" class="password-strong-check" style="display:none;">✔</div>
                        </div>
                    </div>
                    <div class="password-requirements">
                        <div class="password-requirements-title">Use a strong password including:</div>
                        <ul class="password-req-list">
                            <li id="req-length" class="password-req-item">
                                <span class="password-req-icon">✖</span>
                                <span class="password-req-text">At least 8 characters</span>
                            </li>
                            <li id="req-lower" class="password-req-item">
                                <span class="password-req-icon">✖</span>
                                <span class="password-req-text">Lowercase letter (a-z)</span>
                            </li>
                            <li id="req-upper" class="password-req-item">
                                <span class="password-req-icon">✖</span>
                                <span class="password-req-text">Uppercase letter (A-Z)</span>
                            </li>
                            <li id="req-number" class="password-req-item">
                                <span class="password-req-icon">✖</span>
                                <span class="password-req-text">Number (0-9)</span>
                            </li>
                            <li id="req-special" class="password-req-item">
                                <span class="password-req-icon">✖</span>
                                <span class="password-req-text">Special character (!@#$)</span>
                            </li>
                        </ul>
                    </div>
                    <div id="password-suggestions" class="password-suggestions" style="margin-top:10px;">
                        <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:4px;">
                            <div style="font-size:0.8rem;color:#6b7280;">Need ideas? Click a suggested strong password:</div>
                            <button type="button" onclick="renderPasswordSuggestions()" style="border:none;background:none;color:#2563eb;font-size:0.75rem;cursor:pointer;padding:0;">↻ New suggestions</button>
                        </div>
                        <div id="password-suggestion-list" style="display:flex;flex-wrap:wrap;gap:6px;"></div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <div class="input-container">
                        <input type="password" id="confirm-password" name="confirmPassword" placeholder="Confirm your password" required>
                        <div class="input-icon">🔐</div>
                    </div>
                </div>
                <div class="form-group">
                    <label for="register-avatar">Profile Picture (optional)</label>
                    <input id="register-avatar" name="avatar" type="file" accept="image/*" onchange="handleRegisterAvatarChange(event)">
                    <small class="help-text">Max 50 MB. You can adjust it before saving.</small>
                    <div class="avatar-preview-circle">
                        <canvas id="register-avatar-canvas" width="160" height="160"></canvas>
                    </div>
                    <div class="avatar-range">
                        <span>Zoom</span>
                        <input id="register-avatar-zoom" type="range" min="1" max="3" step="0.01" value="1" oninput="onRegisterAvatarZoomChange(event)">
                    </div>
                </div>
                
                <button type="submit" class="submit-btn">Create Account 🎊</button>
            </form>
        </div>
        
        <div class="back-link">
            <a href="index.php">← Back to Food Delivery</a>
        </div>
    </div>

    <script>
        // User storage (in real app, this would be a database)
        let users = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
        let currentUser = JSON.parse(localStorage.getItem('currentUser') || 'null');

        let registerAvatarImage = null;
        let registerAvatarScale = 1;
        let registerAvatarCanvas = null;
        let registerAvatarCtx = null;

        // Password strength helpers
        function calculatePasswordStrength(password) {
            let score = 0;
            if (!password) return 0;

            const length = password.length;
            const hasLower = /[a-z]/.test(password);
            const hasUpper = /[A-Z]/.test(password);
            const hasNumber = /[0-9]/.test(password);
            const hasSpecial = /[^A-Za-z0-9]/.test(password);

            // Length-based
            if (length >= 6) score += 1;
            if (length >= 8) score += 1;
            if (length >= 12) score += 1;

            // Variety-based
            const varietyCount = [hasLower, hasUpper, hasNumber, hasSpecial].filter(Boolean).length;
            if (varietyCount >= 2) score += 1;
            if (varietyCount >= 3) score += 1;
            if (varietyCount === 4) score += 1;

            // Max 6
            if (score > 6) score = 6;
            return score;
        }

        // Password suggestion helpers
        function generateStrongPassword() {
            const length = 12;
            const lowers = 'abcdefghijklmnopqrstuvwxyz';
            const uppers = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            const numbers = '0123456789';
            const specials = '!@#$%^&*()_+{}[]<>?';

            // Ensure each category present at least once
            let passwordChars = [
                lowers[Math.floor(Math.random() * lowers.length)],
                uppers[Math.floor(Math.random() * uppers.length)],
                numbers[Math.floor(Math.random() * numbers.length)],
                specials[Math.floor(Math.random() * specials.length)],
            ];

            const all = lowers + uppers + numbers + specials;
            while (passwordChars.length < length) {
                passwordChars.push(all[Math.floor(Math.random() * all.length)]);
            }

            // Shuffle characters
            for (let i = passwordChars.length - 1; i > 0; i--) {
                const j = Math.floor(Math.random() * (i + 1));
                [passwordChars[i], passwordChars[j]] = [passwordChars[j], passwordChars[i]];
            }

            return passwordChars.join('');
        }

        function renderPasswordSuggestions() {
            const container = document.getElementById('password-suggestion-list');
            if (!container) return;

            container.innerHTML = '';
            const suggestions = [];
            for (let i = 0; i < 3; i++) {
                suggestions.push(generateStrongPassword());
            }

            suggestions.forEach(pwd => {
                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = pwd;
                btn.style.border = '1px solid #d1d5db';
                btn.style.background = '#f9fafb';
                btn.style.borderRadius = '999px';
                btn.style.fontSize = '0.75rem';
                btn.style.padding = '4px 10px';
                btn.style.cursor = 'pointer';
                btn.style.fontFamily = 'monospace';
                btn.style.whiteSpace = 'nowrap';
                btn.onclick = function() {
                    const pwdInput = document.getElementById('register-password');
                    const confirmInput = document.getElementById('confirm-password');
                    if (!pwdInput || !confirmInput) return;
                    pwdInput.value = pwd;
                    confirmInput.value = pwd;
                    // Update UI strength & requirements
                    updatePasswordStrengthUI(pwd, 'register-password-strength-fill', 'register-password-strength-text');
                    updatePasswordRequirements(pwd);
                };
                container.appendChild(btn);
            });
        }

        function updatePasswordStrengthUI(password, _fillElementId, textElementId) {
            const textEl = document.getElementById(textElementId);
            const strongCheckEl = document.getElementById('register-password-strong-check');
            const stepEls = document.querySelectorAll('.password-strength-steps .password-step');
            if (!textEl || !stepEls.length) return;

            let label = 'Enter a password';

            // Evaluate requirements
            const lengthOk = password.length >= 8;
            const lowerOk = /[a-z]/.test(password);
            const upperOk = /[A-Z]/.test(password);
            const numberOk = /[0-9]/.test(password);
            const specialOk = /[^A-Za-z0-9]/.test(password);

            const allOk = lengthOk && lowerOk && upperOk && numberOk && specialOk;

            // Determine how many steps to activate (0-5)
            let activeSteps = 0;

            if (!password) {
                activeSteps = 0;
                label = 'Enter a password';
                if (strongCheckEl) strongCheckEl.style.display = 'none';
            } else if (allOk) {
                // All instructions satisfied → all 5 circles active
                activeSteps = 5;
                label = 'Strong & secure password (all requirements met)';
                if (strongCheckEl) strongCheckEl.style.display = 'flex';
            } else {
                const missing = [];
                if (!lengthOk) missing.push('min 8 characters');
                if (!lowerOk) missing.push('lowercase letter');
                if (!upperOk) missing.push('uppercase letter');
                if (!numberOk) missing.push('number');
                if (!specialOk) missing.push('special character');

                const satisfiedCount = 5 - missing.length; // 0-4
                activeSteps = satisfiedCount;
                if (activeSteps < 0) activeSteps = 0;
                if (activeSteps > 4) activeSteps = 4; // keep last circle for full strong

                label = 'Weak password: add ' + missing.join(', ');
                if (strongCheckEl) strongCheckEl.style.display = 'none';
            }

            // Update circle steps UI
            stepEls.forEach((el, index) => {
                const stepNumber = index + 1;
                if (stepNumber <= activeSteps) {
                    el.classList.add('active');
                } else {
                    el.classList.remove('active');
                }
            });

            textEl.textContent = label;
        }

        function togglePasswordVisibility(inputId, toggleEl) {
            const input = document.getElementById(inputId);
            if (!input) return;
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            if (toggleEl) {
                toggleEl.textContent = isPassword ? '🙈' : '👁️';
            }
        }

        function updatePasswordRequirements(password) {
            const lengthOk = password.length >= 8;
            const lowerOk = /[a-z]/.test(password);
            const upperOk = /[A-Z]/.test(password);
            const numberOk = /[0-9]/.test(password);
            const specialOk = /[^A-Za-z0-9]/.test(password);

            const map = [
                { id: 'req-length', ok: lengthOk },
                { id: 'req-lower', ok: lowerOk },
                { id: 'req-upper', ok: upperOk },
                { id: 'req-number', ok: numberOk },
                { id: 'req-special', ok: specialOk },
            ];

            map.forEach(item => {
                const li = document.getElementById(item.id);
                if (!li) return;
                const icon = li.querySelector('.password-req-icon');
                if (item.ok) {
                    li.classList.add('ok');
                    if (icon) icon.textContent = '✔';
                } else {
                    li.classList.remove('ok');
                    if (icon) icon.textContent = '✖';
                }
            });
        }

        function showLogin() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            
            // Add slide-out animation to current form
            registerForm.classList.add('slide-out');
            
            setTimeout(() => {
                registerForm.classList.remove('active', 'slide-out');
                loginForm.classList.add('active');
                
                // Update toggle buttons
                document.querySelectorAll('.toggle-btn')[0].classList.add('active');
                document.querySelectorAll('.toggle-btn')[1].classList.remove('active');
                clearMessages();
            }, 300);
        }

        function showRegister() {
            const loginForm = document.getElementById('login-form');
            const registerForm = document.getElementById('register-form');
            
            // Add slide-out animation to current form
            loginForm.classList.add('slide-out');
            
            setTimeout(() => {
                loginForm.classList.remove('active', 'slide-out');
                registerForm.classList.add('active');
                
                // Update toggle buttons
                document.querySelectorAll('.toggle-btn')[1].classList.add('active');
                document.querySelectorAll('.toggle-btn')[0].classList.remove('active');
                clearMessages();
            }, 300);
        }


        function toggleAuthForms() {
            // This function can be used to show/hide the entire auth container
            showMessage('Click Login or Create New Account to get started! 🚀', 'success');
        }

        function handleLogin(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const email = formData.get('email');
            const password = formData.get('password');

            fetch('../backend/auth_login.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success && data.user) {
                    currentUser = data.user;

                    // Try to restore avatar from localStorage profile if it exists
                    try {
                        const storedUsers = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
                        const stored = storedUsers.find(u => u.email === currentUser.email && u.avatar);
                        if (stored && stored.avatar) {
                            currentUser.avatar = stored.avatar;
                        }
                    } catch (e) {
                        // Ignore parsing errors and continue without avatar
                    }

                    localStorage.setItem('currentUser', JSON.stringify(currentUser));
                    localStorage.setItem('showWelcomePopup', 'true');
                    showMessage(`Welcome back, ${currentUser.name}! 🎉 Redirecting to food menu...`, 'success');

                    setTimeout(() => {
                        window.location.href = 'index.php';
                    }, 1500);
                } else {
                    const message = data && data.message ? data.message : 'Invalid email or password. Please try again. ❌';
                    showMessage(message, 'error');
                }
            })
            .catch(() => {
                showMessage('Unable to connect to server. Please try again later. ❌', 'error');
            });
        }

        function handleRegister(event) {
            event.preventDefault();
            const formData = new FormData(event.target);
            const name = formData.get('name');
            const email = formData.get('email');
            const phone = formData.get('phone');
            const password = formData.get('password');
            const confirmPassword = formData.get('confirmPassword');

            // Validation
            if (password !== confirmPassword) {
                showMessage('Passwords do not match! ❌', 'error');
                return;
            }
            fetch('../backend/auth_register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data && data.success) {
                    const successName = name || (data.user && data.user.name) || '';
                    const message = data.message || `Account created successfully! Welcome ${successName}! 🎊 You can now login.`;
                    showMessage(message, 'success');

                    // Save avatar in localStorage profile so dashboard can use it later
                    try {
                        let avatarData = null;
                        if (registerAvatarCanvas && registerAvatarImage) {
                            avatarData = registerAvatarCanvas.toDataURL('image/png');
                        }

                        let storedUsers = [];
                        try {
                            storedUsers = JSON.parse(localStorage.getItem('foodDeliveryUsers') || '[]');
                        } catch (e) {
                            storedUsers = [];
                        }

                        const idx = storedUsers.findIndex(u => u.email === email);
                        const baseUser = {
                            email,
                            name,
                            phone,
                            address: formData.get('address') || '',
                            pin: formData.get('pin') || '',
                        };

                        if (idx !== -1) {
                            storedUsers[idx] = {
                                ...storedUsers[idx],
                                ...baseUser,
                                avatar: avatarData || storedUsers[idx].avatar || null,
                            };
                        } else {
                            storedUsers.push({
                                ...baseUser,
                                avatar: avatarData,
                            });
                        }

                        localStorage.setItem('foodDeliveryUsers', JSON.stringify(storedUsers));
                    } catch (e) {
                        // If anything goes wrong with avatar storage, ignore silently
                    }

                    // Clear form and switch to login
                    event.target.reset();
                    const zoomInput = document.getElementById('register-avatar-zoom');
                    if (zoomInput) zoomInput.value = '1';
                    registerAvatarImage = null;
                    if (registerAvatarCanvas && registerAvatarCtx) {
                        registerAvatarCtx.clearRect(0, 0, registerAvatarCanvas.width, registerAvatarCanvas.height);
                    }
                    setTimeout(() => {
                        showLogin();
                    }, 2000);
                } else {
                    const message = data && data.message ? data.message : 'Registration failed. Please try again. ❌';
                    showMessage(message, 'error');
                }
            })
            .catch(() => {
                showMessage('Unable to connect to server. Please try again later. ❌', 'error');
            });
        }

        function handleRegisterAvatarChange(event) {
            const files = event.target.files || [];
            const file = files[0];
            if (!file) return;
            if (file.size > 50 * 1024 * 1024) {
                showMessage('Profile picture is too large. Please choose an image up to 50 MB. ❌', 'error');
                event.target.value = '';
                return;
            }
            registerAvatarCanvas = document.getElementById('register-avatar-canvas');
            if (!registerAvatarCanvas) return;
            registerAvatarCtx = registerAvatarCanvas.getContext('2d');
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = new Image();
                img.onload = function() {
                    registerAvatarImage = img;
                    registerAvatarScale = 1;
                    const zoomInput = document.getElementById('register-avatar-zoom');
                    if (zoomInput) zoomInput.value = '1';
                    drawRegisterAvatar();
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }

        function onRegisterAvatarZoomChange(event) {
            const value = parseFloat(event.target.value);
            if (!isNaN(value)) {
                registerAvatarScale = value;
                drawRegisterAvatar();
            }
        }

        function drawRegisterAvatar() {
            if (!registerAvatarImage || !registerAvatarCanvas || !registerAvatarCtx) return;
            const size = registerAvatarCanvas.width;
            registerAvatarCtx.clearRect(0, 0, size, size);
            registerAvatarCtx.save();
            registerAvatarCtx.beginPath();
            registerAvatarCtx.arc(size / 2, size / 2, size / 2, 0, Math.PI * 2);
            registerAvatarCtx.closePath();
            registerAvatarCtx.clip();
            const imgRatio = registerAvatarImage.width / registerAvatarImage.height;
            let drawWidth;
            let drawHeight;
            const scale = registerAvatarScale;
            if (imgRatio > 1) {
                drawHeight = size * scale;
                drawWidth = drawHeight * imgRatio;
            } else {
                drawWidth = size * scale;
                drawHeight = drawWidth / imgRatio;
            }
            const dx = (size - drawWidth) / 2;
            const dy = (size - drawHeight) / 2;
            registerAvatarCtx.drawImage(registerAvatarImage, dx, dy, drawWidth, drawHeight);
            registerAvatarCtx.restore();
        }

        function showForgotPassword() {
            const email = prompt('Enter your registered email address:');
            if (email) {
                const user = users.find(u => u.email === email);
                if (user) {
                    showMessage(`Password reset link sent to ${email}! 📧 (Demo: Your password is "${user.password}")`, 'success');
                } else {
                    showMessage('Email not found. Please check and try again. ❌', 'error');
                }
            }
        }

        function showMessage(message, type) {
            clearMessages();
            const messageEl = document.getElementById(type === 'success' ? 'success-message' : 'error-message');
            messageEl.textContent = message;
            messageEl.style.display = 'block';
            
            setTimeout(() => {
                messageEl.style.display = 'none';
            }, 5000);
        }

        function clearMessages() {
            document.getElementById('success-message').style.display = 'none';
            document.getElementById('error-message').style.display = 'none';
        }

        // Check if user is already logged in
        window.onload = function() {
            if (currentUser) {
                showMessage(`You are already logged in as ${currentUser.name}! 👋`, 'success');
            }

            // Attach password strength listeners only for register password
            const registerPasswordInput = document.getElementById('register-password');

            if (registerPasswordInput) {
                registerPasswordInput.addEventListener('input', function (e) {
                    updatePasswordStrengthUI(e.target.value, 'register-password-strength-fill', 'register-password-strength-text');
                    updatePasswordRequirements(e.target.value);
                });
                // Render initial password suggestions for signup
                renderPasswordSuggestions();
            }
        };
    </script>
</body>
</html>
