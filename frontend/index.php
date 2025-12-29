<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AR Food - Online Kitchen & Food Delivery</title>
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
            padding: 12px 0;
            text-align: center;
            margin-bottom: 20px;
            width: 100%;
            border-radius: 10px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header-content {
            max-width: 100%;
            width: 100%;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 20px;
        }

        .header-left {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .login-section {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .login-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
        }

        .login-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .profile-icon {
            font-size: 1.2rem;
        }

        .profile-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 10px 20px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 8px;
            backdrop-filter: blur(10px);
            position: relative;
        }

        .profile-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background-size: cover;
            background-position: center;
            background-color: rgba(255, 255, 255, 0.3);
            border: 2px solid rgba(255, 255, 255, 0.7);
            flex-shrink: 0;
            display: none;
        }

        .profile-btn.has-avatar .profile-avatar {
            display: block;
        }

        .profile-btn.has-avatar .profile-icon {
            display: none;
        }

        .profile-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .profile-dropdown {
            position: fixed;
            top: 80px;
            right: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
            padding: 20px;
            min-width: 220px;
            max-width: 280px;
            display: none;
            z-index: 9999;
            border: 1px solid rgba(0,0,0,0.1);
            animation: dropdownFadeIn 0.3s ease-out;
        }

        @keyframes dropdownFadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dropdown-backdrop {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.1);
            z-index: 9998;
            display: none;
        }

        .dropdown-backdrop.show {
            display: block;
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

        /* Product Detail Modal */
        .product-detail-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            backdrop-filter: blur(5px);
            animation: fadeIn 0.3s ease-out;
        }

        .product-detail-modal.show {
            display: flex;
        }

        .product-detail-content {
            background: white;
            border-radius: 25px;
            max-width: 800px;
            width: 90%;
            max-height: 90vh;
            overflow-y: auto;
            position: relative;
            animation: slideUpModal 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
        }

        @keyframes slideUpModal {
            from {
                opacity: 0;
                transform: translateY(50px) scale(0.9);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .product-detail-header {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            padding: 30px;
            border-radius: 25px 25px 0 0;
            position: relative;
        }

        .close-product-detail {
            position: absolute;
            top: 20px;
            right: 25px;
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            font-size: 1.5rem;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .close-product-detail:hover {
            background: rgba(255, 255, 255, 0.3);
            transform: scale(1.1);
        }

        .product-main-info {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .product-icon-large {
            font-size: 4rem;
            background: rgba(255, 255, 255, 0.2);
            padding: 20px;
            border-radius: 20px;
        }

        .product-title-section h2 {
            font-size: 2.2rem;
            margin-bottom: 10px;
        }

        .product-price-large {
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .product-tags {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }

        .product-tag {
            background: rgba(255, 255, 255, 0.2);
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.9rem;
        }

        .product-detail-body {
            padding: 30px;
        }

        .product-description {
            font-size: 1.1rem;
            line-height: 1.6;
            color: #666;
            margin-bottom: 30px;
        }

        .nutrition-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .nutrition-card {
            background: #f8f9fa;
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            border-left: 4px solid #11998e;
        }

        .nutrition-card h4 {
            color: #11998e;
            margin-bottom: 10px;
            font-size: 1.1rem;
        }

        .nutrition-value {
            font-size: 1.5rem;
            font-weight: bold;
            color: #333;
        }

        .detail-section {
            margin-bottom: 25px;
        }

        .detail-section h3 {
            color: #11998e;
            margin-bottom: 15px;
            font-size: 1.3rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .ingredients-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .ingredient-tag {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .allergen-tag {
            background: linear-gradient(135deg, #ff4d4f, #ff6382);
            color: white;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.9rem;
        }

        .spice-level {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #fff3cd;
            padding: 10px 15px;
            border-radius: 10px;
            border-left: 4px solid #ffc107;
        }

        .spice-indicators {
            display: flex;
            gap: 3px;
        }

        .spice-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #ddd;
        }

        .spice-dot.active {
            background: #ff4444;
        }

        .product-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .add-to-cart-detail {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
            border: none;
            padding: 15px 30px;
            border-radius: 12px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            flex: 1;
            transition: all 0.3s ease;
        }

        .add-to-cart-detail:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.4);
        }

        .favorite-detail-btn {
            background: #f8f9fa;
            border: 2px solid #11998e;
            color: #11998e;
            padding: 15px 20px;
            border-radius: 12px;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .favorite-detail-btn:hover {
            background: #11998e;
            color: white;
        }

        /* Mobile Responsive */
        @media (max-width: 768px) {
            .product-detail-content {
                width: 95%;
                margin: 10px;
            }
            
            .product-main-info {
                flex-direction: column;
                text-align: center;
            }
            
            .product-icon-large {
                font-size: 3rem;
            }
            
            .product-title-section h2 {
                font-size: 1.8rem;
            }
            
            .nutrition-grid {
                grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
                gap: 15px;
            }
            
            .product-actions {
                flex-direction: column;
            }
        }

        /* Authentication-based UI visibility */
        .auth-required {
            display: none !important;
        }

        .auth-required.user-logged-in {
            display: block !important;
        }

        .auth-required.user-logged-in.flex {
            display: flex !important;
        }

        .auth-required.user-logged-in.inline-block {
            display: inline-block !important;
        }

        .login-prompt-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            backdrop-filter: blur(5px);
        }

        .login-prompt-content {
            background: white;
            padding: 40px;
            border-radius: 20px;
            text-align: center;
            max-width: 400px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            animation: slideUpModal 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .login-prompt-icon {
            font-size: 4rem;
            margin-bottom: 20px;
        }

        .login-prompt-title {
            font-size: 1.8rem;
            color: #333;
            margin-bottom: 15px;
            font-weight: bold;
        }

        .login-prompt-message {
            color: #666;
            margin-bottom: 30px;
            line-height: 1.6;
        }

        .login-prompt-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .login-prompt-btn {
            padding: 12px 25px;
            border: none;
            border-radius: 10px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1rem;
        }

        .login-prompt-btn.primary {
            background: linear-gradient(135deg, #11998e, #38ef7d);
            color: white;
        }

        .login-prompt-btn.primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(17, 153, 142, 0.4);
        }

        .login-prompt-btn.secondary {
            background: #f8f9fa;
            color: #666;
            border: 2px solid #ddd;
        }

        .login-prompt-btn.secondary:hover {
            background: #e9ecef;
        }

        .login-required-btn {
            background: linear-gradient(135deg, #ffc107, #ff8f00);
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .login-required-btn:hover {
            background: linear-gradient(135deg, #ff6b6b, #ee5a24);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(255, 107, 107, 0.4);
        }

        /* Modern Compact Welcome Popup Styles */
        .welcome-popup-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(8px);
            z-index: 10000;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s ease;
        }

        .welcome-popup-overlay.show {
            opacity: 1;
            visibility: visible;
        }

        .welcome-popup {
            background: white;
            border-radius: 20px;
            padding: 0;
            max-width: 400px;
            width: 90%;
            position: relative;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.2);
            transform: scale(0.8) translateY(30px);
            transition: all 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .welcome-popup-overlay.show .welcome-popup {
            transform: scale(1) translateY(0);
        }

        .welcome-popup-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 25px 20px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .welcome-popup-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            animation: welcomeShine 2s ease-in-out infinite;
        }

        @keyframes welcomeShine {
            0% { left: -100%; }
            50%, 100% { left: 100%; }
        }

        .welcome-popup-icon {
            font-size: 3rem;
            margin-bottom: 10px;
            display: block;
            animation: welcomePulse 2s ease-in-out infinite;
        }

        @keyframes welcomePulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.1); }
        }

        .welcome-popup-title {
            color: white;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            letter-spacing: 0.5px;
        }

        .welcome-popup-subtitle {
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.95rem;
            margin: 8px 0 0 0;
            font-weight: 400;
        }

        .welcome-popup-body {
            padding: 25px 20px;
            text-align: center;
        }

        .welcome-message {
            font-size: 1rem;
            color: #4a5568;
            line-height: 1.5;
            margin-bottom: 20px;
            font-weight: 400;
        }

        .welcome-features {
            display: flex;
            justify-content: space-around;
            gap: 15px;
            margin: 20px 0;
            flex-wrap: wrap;
        }

        .welcome-feature {
            text-align: center;
            padding: 12px 8px;
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            border-radius: 12px;
            transition: all 0.2s ease;
            flex: 1;
            min-width: 70px;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .welcome-feature:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            background: linear-gradient(135deg, #e2e8f0, #cbd5e0);
        }

        .welcome-feature-icon {
            font-size: 1.5rem;
            margin-bottom: 5px;
            display: block;
        }

        .welcome-feature-text {
            font-size: 0.75rem;
            color: #718096;
            font-weight: 600;
        }

        .welcome-popup-footer {
            padding: 0 20px 25px;
            text-align: center;
        }

        .welcome-close-btn {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 30px;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(102, 126, 234, 0.3);
            letter-spacing: 0.3px;
            width: 100%;
        }

        .welcome-close-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a67d8 0%, #6b46c1 100%);
        }

        .welcome-close-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 10px rgba(102, 126, 234, 0.3);
        }

        /* Mobile Responsive */
        @media (max-width: 480px) {
            .welcome-popup {
                max-width: 350px;
                margin: 20px;
            }
            
            .welcome-popup-header {
                padding: 20px 15px;
            }
            
            .welcome-popup-icon {
                font-size: 2.5rem;
            }
            
            .welcome-popup-title {
                font-size: 1.3rem;
            }
            
            .welcome-popup-body {
                padding: 20px 15px;
            }
            
            .welcome-message {
                font-size: 0.9rem;
            }
            
            .welcome-features {
                gap: 10px;
            }
            
            .welcome-feature {
                padding: 10px 6px;
                min-width: 60px;
            }
            
            .welcome-feature-icon {
                font-size: 1.3rem;
            }
            
            .welcome-feature-text {
                font-size: 0.7rem;
            }
            
            .welcome-close-btn {
                padding: 10px 25px;
                font-size: 0.9rem;
            }
        }

        .welcome-close-btn:active {
            transform: translateY(0);
        }

        /* Checkout confetti animation */
        .confetti-piece {
            position: absolute;
            top: -10px;
            width: 8px;
            height: 14px;
            border-radius: 2px;
            opacity: 0.9;
            animation-name: confetti-fall;
            animation-timing-function: linear;
            animation-iteration-count: 1;
        }

        @keyframes confetti-fall {
            0% { transform: translate3d(0, 0, 0) rotateZ(0deg); opacity: 1; }
            100% { transform: translate3d(0, 120vh, 0) rotateZ(360deg); opacity: 0; }
        }

        .profile-dropdown.show {
            display: block;
        }

        .user-info {
            padding: 15px 0;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }

        .user-name {
            font-weight: bold;
            color: #11998e;
            margin-bottom: 5px;
        }

        .user-email {
            font-size: 0.9rem;
            color: #666;
        }

        .logout-btn {
            background: linear-gradient(to right, #ff4d4f, #ff6382);
            color: white;
            border: none;
            padding: 12px 16px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 0.9rem;
            font-weight: bold;
            width: 100%;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: linear-gradient(to right, #e63c3f, #f34d6f);
            transform: translateY(-1px);
        }

        /* Professional Logo Styles */
        .logo-container {
            display: flex;
            align-items: center;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 10px;
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.15), rgba(255, 255, 255, 0.05));
            padding: 8px 16px;
            border-radius: 30px;
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.2);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .logo:hover {
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.25), rgba(255, 255, 255, 0.1));
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
            border-color: rgba(255, 255, 255, 0.3);
        }

        .logo-icon {
            font-size: 1.4rem;
            transition: all 0.3s ease;
        }

        .logo:hover .logo-icon {
            transform: scale(1.1);
        }

        .logo-text {
            font-family: 'Arial Black', Arial, sans-serif;
            font-size: 1.3rem;
            font-weight: 900;
            background: linear-gradient(135deg, #ffffff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            letter-spacing: 1px;
            position: relative;
        }

        .logo-text::before {
            content: 'AR Food';
            position: absolute;
            top: 0;
            left: 0;
            background: linear-gradient(135deg, #11998e, #38ef7d);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .logo:hover .logo-text::before {
            opacity: 1;
        }

        header h1 {
            font-size: 2.5rem;
            margin: 0;
        }

        header nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 30px;
        }

        header nav ul li a {
            color: #ffffff;
            text-decoration: none;
            font-size: 1.1rem;
            transition: color 0.3s ease;
        }

        header nav ul li a:hover {
            color: #f3f4f6;
        }

        header nav ul li a.active {
            background: rgba(255,255,255,0.2);
            padding: 8px 16px;
            border-radius: 20px;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        .hero-section {
            background: linear-gradient(135deg, #22c55e 0%, #16a34a 40%, #15803d 100%);
            color: white;
            padding: 50px 40px;
            border-radius: 18px;
            margin-bottom: 40px;
            display: grid;
            grid-template-columns: minmax(0, 1.4fr) minmax(0, 1fr);
            gap: 32px;
            align-items: center;
        }

        .hero-left h2 {
            font-size: 2.6rem;
            margin: 0 0 16px 0;
        }

        .hero-left p {
            font-size: 1.1rem;
            margin: 0 0 22px 0;
            opacity: 0.95;
        }

        .hero-tagline {
            font-size: 0.9rem;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            margin-bottom: 10px;
            opacity: 0.9;
        }

        .hero-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            align-items: center;
        }

        .hero-secondary-btn {
            background: rgba(255,255,255,0.12);
            color: #ecfdf3;
            padding: 10px 20px;
            border-radius: 999px;
            border: 1px solid rgba(255,255,255,0.25);
            font-size: 0.95rem;
            cursor: pointer;
            transition: all 0.25s ease;
        }

        .hero-secondary-btn:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-1px);
        }

        .hero-right {
            background: rgba(255,255,255,0.08);
            border-radius: 16px;
            padding: 16px 16px 18px 16px;
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255,255,255,0.25);
            display: grid;
            grid-template-rows: auto auto;
            gap: 12px;
        }

        .hero-dish-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 10px;
        }

        .hero-dish-card {
            background: rgba(255,255,255,0.9);
            border-radius: 12px;
            padding: 8px 10px;
            color: #111827;
            display: flex;
            flex-direction: column;
            gap: 2px;
            font-size: 0.8rem;
        }

        .hero-dish-name {
            font-weight: 600;
        }

        .hero-dish-meta {
            display: flex;
            justify-content: space-between;
            font-size: 0.72rem;
            color: #4b5563;
        }

        .hero-mini-stats {
            display: flex;
            justify-content: space-between;
            gap: 10px;
            font-size: 0.78rem;
            color: #e5e7eb;
        }

        .hero-mini-stat {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .hero-mini-stat span:first-child {
            font-weight: 600;
            font-size: 0.9rem;
        }

        .cta-button {
            background: linear-gradient(to right, #ff9f43, #ff6f61);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .cta-button:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 30px;
            margin: 40px 0;
        }

        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-5px);
        }

        .feature-icon {
            font-size: 3rem;
            margin-bottom: 20px;
        }

        .contact-form {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        /* Contact page alignment */
        #contact-page .container {
            max-width: 900px;
            margin: 0 auto;
            display: grid;
            gap: 30px;
            justify-items: stretch;
        }

        #contact-page h2 {
            text-align: center;
        }

        #contact-page .contact-form {
            width: 100%;
        }

        #contact-page .features-grid {
            max-width: 900px;
            margin: 0 auto;
            width: 100%;
        }

        #contact-page .feature-card {
            text-align: left;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #333;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px;
            border: 2px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #11998e;
        }

        .submit-btn {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: white;
            padding: 15px 30px;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
        }

        .submit-btn:hover {
            background: linear-gradient(to right, #0c8976, #30c270);
            transform: translateY(-2px);
        }

        /* Contact Page Mobile Responsiveness */
        @media (max-width: 768px) {
            .contact-form {
                margin: 0 15px;
                padding: 25px 20px;
                border-radius: 12px;
            }
            
            .form-group {
                margin-bottom: 20px;
            }
            
            .form-group label {
                font-size: 0.95rem;
                margin-bottom: 6px;
            }
            
            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 14px 16px;
                font-size: 16px; /* Prevents zoom on iOS */
                border-radius: 10px;
                box-sizing: border-box;
            }
            
            .form-group textarea {
                min-height: 100px;
                resize: vertical;
            }
            
            .form-group select {
                -webkit-appearance: none;
                -moz-appearance: none;
                appearance: none;
                background-image: url("data:image/svg+xml;charset=UTF-8,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2'%3e%3cpolyline points='6,9 12,15 18,9'%3e%3c/polyline%3e%3c/svg%3e");
                background-repeat: no-repeat;
                background-position: right 15px center;
                background-size: 20px;
                padding-right: 45px;
            }
            
            .submit-btn {
                padding: 16px 25px;
                font-size: 1rem;
                border-radius: 10px;
                box-shadow: 0 4px 15px rgba(17, 153, 142, 0.3);
            }
            
            #contact-page h2 {
                font-size: 1.8rem !important;
                margin-bottom: 25px !important;
                padding: 0 15px;
            }
            
            #contact-page h3 {
                font-size: 1.4rem !important;
                margin-bottom: 15px !important;
                padding: 0 15px;
                text-align: center;
            }
            
            /* Contact Info Cards Mobile */
            .features-grid {
                grid-template-columns: 1fr !important;
                gap: 15px !important;
                padding: 0 15px !important;
                justify-items: stretch;
                align-items: stretch;
            }
            
            .feature-card {
                padding: 20px 15px !important;
                text-align: center !important;
                width: 100%;
            }

            /* Simplify contact page layout on tablet sizes */
            #contact-page .container {
                display: block;
                max-width: 900px;
                margin: 0 auto;
            }
            #contact-page .contact-form { width: 100%; }
        }
    
            .feature-card h4 {
                font-size: 1.1rem !important;
                margin-bottom: 8px !important;
            }
            
        @media (max-width: 480px) {
            .contact-form {
                margin: 0 12px;
                padding: 20px 15px;
            }
            
            .form-group input,
            .form-group textarea,
            .form-group select {
                padding: 12px 14px;
                font-size: 16px;
            }
            
            .form-group textarea {
                min-height: 90px;
            }
            
            .submit-btn {
                padding: 14px 20px;
                font-size: 0.95rem;
            }
            
            #contact-page h2 {
                font-size: 1.6rem !important;
                margin-bottom: 20px !important;
            }

            .feature-card {
                padding: 15px 10px !important;
                text-align: center !important;
            }
            
            .feature-card h4 {
                font-size: 1rem !important;
            }
            
            .feature-card p {
                font-size: 0.85rem !important;
            }
            
            .feature-icon {
                font-size: 1.8rem !important;
            }

            /* Ensure perfect alignment on small phones */
            #contact-page .container { display: block; }
            #contact-page .features-grid {
                grid-template-columns: 1fr !important;
                justify-items: stretch;
                width: 100%;
            }
            #contact-page .feature-card { width: 100%; }
            #contact-page .contact-form { width: 100%; }
        }

        /* Enhanced form styling for better mobile experience */
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: #11998e;
            box-shadow: 0 0 0 3px rgba(17, 153, 142, 0.1);
            transform: translateY(-1px);
        }

        /* Additional mobile optimizations */
        @media (max-width: 768px) {
            .container {
                padding: 0 15px;
            }
            
            /* Ensure contact page content doesn't overflow */
            #contact-page {
                overflow-x: hidden;
            }
            
            /* Better spacing for mobile */
            #contact-page .container {
                padding: 20px 10px;
            }
        }

        /* Touch-friendly improvements */
        @media (hover: none) and (pointer: coarse) {
            .form-group input,
            .form-group textarea,
            .form-group select {
                min-height: 48px; /* Minimum touch target size */
            }
            
            .submit-btn {
                min-height: 48px;
                padding: 16px 20px;
            }
        }

        .cart-page-container {
            max-width: 800px;
            margin: 0 auto;
        }

        .empty-cart {
            text-align: center;
            padding: 60px 20px;
            color: #666;
        }

        .empty-cart-icon {
            font-size: 5rem;
            margin-bottom: 20px;
        }

        /* Modal Styles */
        .modal-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 1000;
            backdrop-filter: blur(5px);
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-content {
            background: white;
            border-radius: 20px;
            padding: 40px;
            max-width: 500px;
            width: 90%;
            max-height: 80vh;
            overflow-y: auto;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
            transform: scale(0.7);
            opacity: 0;
            transition: all 0.3s ease;
            position: relative;
        }

        .modal-overlay.show .modal-content {
            transform: scale(1);
            opacity: 1;
        }

        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-header h2 {
            color: #11998e;
            margin: 0 0 10px 0;
            font-size: 2rem;
        }

        .modal-header .success-icon {
            font-size: 4rem;
            margin-bottom: 20px;
            animation: bounce 0.6s ease;
        }

        @keyframes bounce {
            0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
            40% { transform: translateY(-10px); }
            60% { transform: translateY(-5px); }
        }

        .order-summary {
            margin: 20px 0;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .order-item:last-child {
            border-bottom: none;
            font-weight: bold;
            font-size: 1.2rem;
            color: #11998e;
            border-top: 2px solid #11998e;
            padding-top: 15px;
            margin-top: 10px;
        }

        .item-details {
            flex: 1;
        }

        .item-name {
            font-weight: bold;
            margin-bottom: 2px;
        }

        .item-quantity {
            color: #666;
            font-size: 0.9rem;
        }

        .item-price {
            font-weight: bold;
            color: #11998e;
        }

        .modal-close {
            position: absolute;
            top: 15px;
            right: 20px;
            background: none;
            border: none;
            font-size: 1.8rem;
            cursor: pointer;
            color: #999;
            transition: color 0.3s ease;
        }

        .modal-close:hover {
            color: #333;
        }

        .modal-buttons {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .modal-btn {
            flex: 1;
            padding: 12px 20px;
            border: none;
            border-radius: 8px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .modal-btn.primary {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: white;
        }

        .modal-btn.primary:hover {
            background: linear-gradient(to right, #0c8976, #30c270);
            transform: translateY(-2px);
        }

        .modal-btn.secondary {
            background: #f8f9fa;
            color: #333;
            border: 2px solid #ddd;
        }

        .modal-btn.secondary:hover {
            background: #e9ecef;
            border-color: #11998e;
        }

        /* Welcome Modal Styles */
        .welcome-modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.8);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 2000;
            opacity: 0;
            visibility: hidden;
            transition: all 0.5s ease;
        }

        .welcome-modal.show {
            opacity: 1;
            visibility: visible;
        }

        .welcome-content {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 25px;
            padding: 50px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            transform: scale(0.5) rotate(10deg);
            transition: all 0.6s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            color: white;
            position: relative;
            overflow: hidden;
        }

        .welcome-modal.show .welcome-content {
            transform: scale(1) rotate(0deg);
        }

        .welcome-content::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .welcome-logo {
            font-size: 5rem;
            margin-bottom: 20px;
            animation: bounce 2s infinite;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.3));
        }

        .welcome-content h1 {
            font-size: 2.5rem;
            margin: 20px 0;
            font-weight: bold;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
        }

        .welcome-content p {
            font-size: 1.2rem;
            margin: 20px 0;
            opacity: 0.9;
        }

        .welcome-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            padding: 15px 30px;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            backdrop-filter: blur(10px);
            margin-top: 20px;
        }

        .welcome-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.5);
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        /* Enhanced Home Page Styles */
        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 80px 40px;
            text-align: center;
            border-radius: 20px;
            margin-bottom: 50px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
            opacity: 0.3;
        }

        .hero-section * {
            position: relative;
            z-index: 1;
        }

        .hero-section h2 {
            font-size: 3.5rem;
            margin-bottom: 25px;
            text-shadow: 3px 3px 6px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease;
        }

        .hero-section p {
            font-size: 1.4rem;
            margin-bottom: 35px;
            opacity: 0.95;
            animation: fadeInUp 1s ease 0.3s both;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .cta-button {
            background: linear-gradient(45deg, #ff9f43, #ff6f61);
            color: white;
            padding: 18px 35px;
            border: none;
            border-radius: 50px;
            font-size: 1.3rem;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(255, 111, 97, 0.4);
            animation: fadeInUp 1s ease 0.6s both;
        }

        .cta-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 15px 35px rgba(255, 111, 97, 0.6);
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 35px;
            margin: 50px 0;
        }

        .feature-card {
            background: white;
            padding: 40px 30px;
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            border: 1px solid rgba(255,255,255,0.2);
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.4), transparent);
            transition: left 0.5s ease;
        }

        .feature-card:hover::before {
            left: 100%;
        }

        .feature-card:hover {
            transform: translateY(-10px) scale(1.02);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }

        .feature-icon {
            font-size: 4rem;
            margin-bottom: 25px;
            filter: drop-shadow(0 5px 15px rgba(0,0,0,0.1));
            transition: transform 0.3s ease;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card h3 {
            color: #333;
            margin-bottom: 15px;
            font-size: 1.4rem;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Product card image */
        .product-image {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 14px;
            margin-bottom: 10px;
            background: #f3f4f6;
            display: block;
        }

        /* Home: Category Chips */
        .category-chips {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin: 20px 0 10px;
        }
        .chip {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: linear-gradient(135deg, #f7fafc, #edf2f7);
            color: #334155;
            border: 1px solid #e2e8f0;
            padding: 10px 14px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 0.95rem;
            box-shadow: 0 4px 10px rgba(0,0,0,0.06);
            transition: transform .2s ease, box-shadow .2s ease, background .2s ease;
            cursor: pointer;
        }
        .chip:hover { transform: translateY(-2px); box-shadow: 0 8px 18px rgba(0,0,0,0.08); background: linear-gradient(135deg, #eef2ff, #e9d5ff); }

        /* Home: Promo Banner */
        .promo-banner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            background: linear-gradient(90deg, #ff6f61, #ff9f43);
            color: white;
            border-radius: 18px;
            padding: 24px 28px;
            margin: 22px 0 10px;
            box-shadow: 0 18px 40px rgba(255, 111, 97, 0.35);
        }
        .promo-left {
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 1.2rem;
            font-weight: 700;
        }
        .promo-badge { background: rgba(255,255,255,0.18); padding: 8px 12px; border-radius: 10px; font-weight: 800; letter-spacing: .3px; }
        .promo-right { font-size: 0.95rem; opacity: 0.95; }

        /* Home: Quick Stats */
        .quick-stats { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 16px; margin: 28px 0; }
        .stat-card { background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 18px; display: flex; align-items: center; gap: 12px; box-shadow: 0 8px 22px rgba(0,0,0,0.06); }
        .stat-icon { font-size: 1.6rem; }
        .stat-info { line-height: 1.2; }
        .stat-num { font-size: 1.4rem; font-weight: 800; color: #111827; }
        .stat-label { color: #6b7280; font-size: 0.85rem; }

        /* Home: Trust Badges */
        .trust-badges { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 14px; margin: 10px 0 30px; }
        .badge-card { background: linear-gradient(135deg, #ecfeff, #e0e7ff); border: 1px solid #dbeafe; padding: 14px; border-radius: 14px; text-align: center; font-weight: 700; color: #1f2937; box-shadow: 0 6px 20px rgba(99,102,241,0.15); }

        /* Home: Testimonials */
        .testimonials { margin: 40px 0; }
        .testimonials h3 { text-align: center; color: #4f46e5; margin-bottom: 18px; }
        .testimonial-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 18px; }
        .testimonial { background: white; border: 1px solid #eef2f7; border-radius: 16px; padding: 18px; box-shadow: 0 10px 24px rgba(0,0,0,0.07); position: relative; }
        .testimonial:before { content: '“'; position: absolute; top: -10px; left: 12px; font-size: 4rem; color: #e5e7eb; font-weight: 800; }
        .testimonial p { color: #374151; margin: 8px 0 12px; }
        .testimonial .author { font-weight: 800; color: #111827; display: flex; align-items: center; gap: 8px; }

        /* Home: Secondary CTA */
        .secondary-cta { background: linear-gradient(135deg, #14b8a6, #22d3ee); color: white; border-radius: 18px; padding: 28px; text-align: center; margin: 35px 0 10px; box-shadow: 0 18px 40px rgba(20,184,166,0.35); }
        .secondary-cta h3 { margin: 0 0 10px; font-size: 1.6rem; }
        .secondary-cta p { margin: 0 0 16px; font-size: 1rem; opacity: 0.95; }
        .secondary-cta .cta-button { background: white; color: #0f172a; box-shadow: 0 10px 22px rgba(255,255,255,0.25); }

        /* Home: Responsive tweaks */
        @media (max-width: 640px) {
            .promo-banner { flex-direction: column; align-items: flex-start; }
            .promo-right { width: 100%; }
            .hero-section {
                grid-template-columns: 1fr;
                padding: 40px 20px;
                text-align: left;
            }
            .hero-section h2 {
                font-size: 2.2rem;
            }
            .hero-section p {
                font-size: 1.1rem;
            }
            .hero-right {
                margin-top: 24px;
            }
        }

        .container {
            width: 100%;
            max-width: 100%;
            margin: 0 auto;
            padding: 20px 30px;
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            #home-page .container {
                display: block;
                padding: 20px 15px;
            }
            #products-page .container {
                flex-direction: column;
                padding: 20px 15px;
            }
            #products {
                flex: 1 1 100%;
                min-width: 0;
            }
            #cart {
                width: 100%;
                margin-top: 25px;
            }
            #filter-bar {
                flex-direction: column;
                align-items: stretch;
            }
        }

        #filter-bar {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
            flex-wrap: wrap;
        }

        #search-box {
            padding: 10px 15px;
            flex: 1;
            min-width: 200px;
            font-size: 1rem;
            border: 2px solid #11998e;
            border-radius: 8px;
            outline: none;
        }

        #category-filter {
            padding: 10px 15px;
            font-size: 1rem;
            border: 2px solid #11998e;
            border-radius: 8px;
            outline: none;
            background: white;
        }

        #products {
            flex: 3;
            min-width: 300px;
        }

        #products h2 {
            margin-bottom: 20px;
            color: #11998e;
        }

        #products .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 20px;
        }

        .product {
            background-color: #ffffff;
            width: 100%;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: all 0.3s ease;
            border: 2px solid transparent;
            position: relative; /* for tag positioning */
        }

        .product:hover {
            transform: translateY(-8px);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
            border-color: #11998e;
        }

        .product-icon {
            font-size: 80px;
            margin-bottom: 15px;
            display: block;
        }

        .product h3 {
            font-size: 1.2rem;
            margin: 10px 0;
            color: #333;
        }

        .product .price {
            color: #11998e;
            font-size: 1.4rem;
            font-weight: bold;
            margin: 10px 0;
        }

        .product .category-tag {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            margin-bottom: 10px;
        }

        .tag-veg {
            background: #d4edda;
            color: #155724;
        }

        .tag-non-veg {
            background: #f8d7da;
            color: #721c24;
        }

        .tag-dessert {
            background: #fff3cd;
            color: #856404;
        }

        .tag-beverage {
            background: #d1ecf1;
            color: #0c5460;
        }

        /* NEW: top-left small badge for Best Seller / Best Price */
        .badge {
            position: absolute;
            top: 10px;
            left: 10px;
            background: linear-gradient(to right, #ff9f43, #ff6f61);
            color: #fff;
            padding: 6px 10px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 0.85rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.12);
        }

        /* Favorite button on product cards */
        .favorite-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 50%;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 1.2rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            z-index: 10;
        }

        .favorite-btn:hover {
            background: rgba(255, 255, 255, 1);
            transform: scale(1.1);
            box-shadow: 0 4px 12px rgba(0,0,0,0.25);
        }

        .favorite-btn.favorited {
            background: #ff6b6b;
            color: white;
        }

        .favorite-btn.favorited:hover {
            background: #ff5252;
        }

        .product button {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
            outline: none;
            font-size: 1rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .product button:hover {
            background: linear-gradient(to right, #0c8976, #30c270);
            transform: scale(1.05);
        }

        #cart {
            flex: 1;
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 20px;
            min-width: 300px;
            position: sticky;
            top: 20px;
            max-height: 600px;
            overflow-y: auto;
        }

        #cart h2 {
            font-size: 1.8rem;
            margin-bottom: 1rem;
            color: #11998e;
        }

        #cart-items {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        .cart-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .cart-item-info {
            display: flex;
            align-items: center;
            gap: 10px;
            flex: 1;
        }

        .cart-item-icon {
            font-size: 1.5rem;
            flex-shrink: 0;
        }

        .cart-item-name {
            flex: 1;
            font-weight: bold;
            min-width: 100px;
        }

        .cart-item button.delete-btn {
            background: linear-gradient(to right, #ff4d4f, #ff6382);
            color: #ffffff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            outline: none;
            font-size: 0.9rem;
        }

        .cart-item button.delete-btn:hover {
            background: linear-gradient(to right, #e63c3f, #f34d6f);
        }

        .quantity {
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .quantity button {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: #ffffff;
            border: none;
            padding: 6px 12px;
            border-radius: 6px;
            cursor: pointer;
            outline: none;
            font-weight: bold;
        }

        .quantity button:hover {
            background: linear-gradient(to right, #0c8976, #30c270);
        }

        .quantity input {
            width: 50px;
            text-align: center;
            border: 2px solid #11998e;
            border-radius: 6px;
            padding: 6px;
            outline: none;
            font-weight: bold;
        }

        #total-price {
            margin-top: 20px;
            padding-top: 15px;
            border-top: 2px solid #11998e;
            font-weight: bold;
            font-size: 1.5rem;
            text-align: right;
            color: #11998e;
        }

        #buy-button {
            margin-top: 15px;
            width: 100%;
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: #fff;
            border: none;
            padding: 15px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        #buy-button:hover {
            background: linear-gradient(to right, #0c8976, #30c270);
            transform: scale(1.02);
        }

        .item-count {
            text-align: center;
            color: #666;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }

        /* Pagination styles (kept minimal to match existing UI) */
        #pagination {
            margin-top: 18px;
            text-align: center;
            display: flex;
            justify-content: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .page-btn {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #11998e;
            background: white;
            color: #11998e;
            cursor: pointer;
            font-weight: bold;
        }

        .page-btn.active {
            background: linear-gradient(to right, #11998e, #38ef7d);
            color: white;
            border: none;
        }

        .page-btn.disabled {
            opacity: 0.5;
            cursor: default;
        }

        /* Responsive design for header */
        @media (max-width: 768px) {
            .header-content {
                flex-direction: row;
                justify-content: space-between;
                align-items: flex-start;
                gap: 10px;
            }
            
            .header-left {
                align-items: flex-start;
                flex: 1;
            }
            
            .logo-text {
                font-size: 1.1rem;
                letter-spacing: 0.5px;
            }
            
            .logo-icon {
                font-size: 1.2rem;
            }
            
            .logo {
                padding: 6px 12px;
                gap: 8px;
            }
            
            .header-left {
                gap: 20px;
            }
            
            header h1 {
                font-size: 1.8rem;
                margin-bottom: 10px;
            }
            
            header nav ul {
                flex-wrap: wrap;
                gap: 10px;
                justify-content: flex-start;
                margin: 0;
            }
            
            header nav ul li a {
                font-size: 0.9rem;
                padding: 6px 12px;
            }
            
            .login-section {
                flex-shrink: 0;
                margin-top: 5px;
            }
            
            .login-btn, .profile-btn {
                padding: 8px 16px;
                font-size: 0.9rem;
                white-space: nowrap;
            }
        }

        @media (max-width: 480px) {
            .header-content {
                padding: 0 15px;
            }
            
            .logo-text {
                font-size: 1rem;
                letter-spacing: 0.5px;
            }
            
            .logo-icon {
                font-size: 1.1rem;
            }
            
            .logo {
                padding: 5px 10px;
                gap: 6px;
            }
            
            .header-left {
                gap: 12px;
                flex-direction: column;
                align-items: flex-start;
            }
            
            header nav ul {
                gap: 12px;
            }
            
            header h1 {
                font-size: 1.5rem;
            }
            
            header nav ul {
                gap: 8px;
            }
            
            header nav ul li a {
                font-size: 0.8rem;
                padding: 5px 10px;
            }
            
            .login-btn, .profile-btn {
                padding: 6px 12px;
                font-size: 0.8rem;
            }
            
            .profile-icon {
                font-size: 1rem;
            }
            
            .profile-dropdown {
                top: 70px;
                right: 10px;
                left: 10px;
                min-width: auto;
                max-width: none;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="header-content">
            <div class="header-left">
                <div class="logo-container">
                    <div class="logo">
                        <span class="logo-icon">🍟</span>
                        <span class="logo-text">AR Food</span>
                    </div>
                </div>
                <nav>
                    <ul>
                        <li><a href="#" onclick="showPage('home')">🏚️</a></li>
                        <li><a href="#" onclick="showPage('products')">Products</a></li>
                        <li class="auth-required"><a href="#" onclick="showPage('cart')">Cart</a></li>
                        <li><a href="#" onclick="showPage('contact')">Contact</a></li>
                    </ul>
                </nav>
            </div>
            <div class="login-section" id="auth-section">
                <!-- Login Button (shown when not logged in) -->
                <a href="login.php" class="login-btn" id="login-button">
                    <span class="profile-icon">👤</span>
                    Login
                </a>
                
                <!-- Profile Button (shown when logged in) -->
                <div class="profile-btn" id="profile-button" style="display: none;" onclick="toggleProfileDropdown()">
                    <div class="profile-avatar" id="header-avatar"></div>
                    <span class="profile-icon">👤</span>
                    <span id="user-display-name">Profile</span>
                </div>
            </div>
        </div>
    </header>

    <!-- Profile Dropdown (outside header for proper positioning) -->
    <div class="dropdown-backdrop" id="dropdown-backdrop" onclick="closeProfileDropdown()"></div>
    <div class="profile-dropdown" id="profile-dropdown">
        <div class="user-info">
            <div class="user-name" id="dropdown-user-name"></div>
            <div class="user-email" id="dropdown-user-email"></div>
        </div>
        <button class="dashboard-btn" onclick="goToDashboard()" style="background: linear-gradient(to right, #11998e, #38ef7d); color: white; border: none; padding: 12px 16px; border-radius: 8px; cursor: pointer; font-size: 0.9rem; font-weight: bold; width: 100%; transition: all 0.3s ease; margin-bottom: 15px;">📊 My Dashboard</button>
        <button class="logout-btn" onclick="logout()">🚪 Logout</button>
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

    <!-- Login Prompt Modal -->
    <div class="login-prompt-overlay" id="login-prompt-overlay">
        <div class="login-prompt-content">
            <div class="login-prompt-icon">🔐</div>
            <div class="login-prompt-title">Login Required</div>
            <div class="login-prompt-message">
                Please login or create an account to add items to your cart and enjoy our delicious food delivery service!
            </div>
            <div class="login-prompt-buttons">
                <button class="login-prompt-btn secondary" onclick="closeLoginPrompt()">Maybe Later</button>
                <button class="login-prompt-btn primary" onclick="goToLogin()">Login Now</button>
            </div>
        </div>
    </div>

    <!-- Product Detail Modal -->
    <div class="product-detail-modal" id="product-detail-modal">
        <div class="product-detail-content">
            <div class="product-detail-header">
                <button class="close-product-detail" onclick="closeProductDetail()">×</button>
                <div class="product-main-info">
                    <div class="product-icon-large" id="product-icon-large">🍔</div>
                    <div class="product-title-section">
                        <h2 id="product-title-large">Product Name</h2>
                        <div class="product-price-large" id="product-price-large">₹120</div>
                        <div class="product-tags" id="product-tags-container">
                            <!-- Tags will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="product-detail-body">
                <div class="product-description" id="product-description">
                    Product description will be displayed here.
                </div>
                
                <div class="nutrition-grid" id="nutrition-grid">
                    <!-- Nutrition cards will be populated by JavaScript -->
                </div>
                
                <div class="detail-section">
                    <h3>🌶️ Spice Level</h3>
                    <div class="spice-level" id="spice-level-container">
                        <span id="spice-level-text">Medium</span>
                        <div class="spice-indicators" id="spice-indicators">
                            <!-- Spice dots will be populated by JavaScript -->
                        </div>
                    </div>
                </div>
                
                <div class="detail-section">
                    <h3>🥘 Ingredients</h3>
                    <div class="ingredients-list" id="ingredients-list">
                        <!-- Ingredients will be populated by JavaScript -->
                    </div>
                </div>
                
                <div class="detail-section">
                    <h3>⚠️ Allergens</h3>
                    <div class="ingredients-list" id="allergens-list">
                        <!-- Allergens will be populated by JavaScript -->
                    </div>
                </div>
                
                <div class="detail-section">
                    <h3>⏱️ Preparation Time</h3>
                    <div style="background: #e8f5e8; padding: 10px 15px; border-radius: 10px; display: inline-block;">
                        <span id="preparation-time">15-20 minutes</span>
                    </div>
                </div>
                
                <div class="product-actions">
                    <button class="add-to-cart-detail auth-required" onclick="addToCartFromDetail()">
                        🛒 Add to Cart
                    </button>
                    <button class="login-required-btn" onclick="showLoginPrompt()" style="display: none; flex: 1;">
                        🔐 Login to Add to Cart
                    </button>
                    <button class="favorite-detail-btn" onclick="toggleFavoriteFromDetail()" id="favorite-detail-btn">
                        ❤️
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- HOME PAGE -->
    <div id="home-page" class="page-section active">
        <div class="container">
            <div class="hero-section">
                <div class="hero-left">
                    <div class="hero-tagline">FRESH • FAST • DELICIOUS</div>
                    <h2>Order fresh food from AR Food 🍽️</h2>
                    <p>Hot meals, cool drinks and tasty desserts delivered to your doorstep in minutes. Pick your favourites and we’ll handle the rest.</p>
                    <div class="hero-actions">
                        <button class="cta-button" onclick="showPage('products')">Browse Menu 🚀</button>
                        <button class="hero-secondary-btn" onclick="showPage('products')">View today’s offers</button>
                    </div>
                </div>
                <div class="hero-right">
                    <div class="hero-dish-list">
                        <div class="hero-dish-card">
                            <div class="hero-dish-name">🔥 Spicy Chicken Burger</div>
                            <div class="hero-dish-meta"><span>From ₹149</span><span>25 min</span></div>
                        </div>
                        <div class="hero-dish-card">
                            <div class="hero-dish-name">🍕 Cheesy Veg Pizza</div>
                            <div class="hero-dish-meta"><span>From ₹199</span><span>30 min</span></div>
                        </div>
                        <div class="hero-dish-card">
                            <div class="hero-dish-name">🍛 Hyderabadi Biryani</div>
                            <div class="hero-dish-meta"><span>From ₹229</span><span>35 min</span></div>
                        </div>
                        <div class="hero-dish-card">
                            <div class="hero-dish-name">🥤 Cold Coffee Combo</div>
                            <div class="hero-dish-meta"><span>From ₹99</span><span>20 min</span></div>
                        </div>
                    </div>
                    <div class="hero-mini-stats">
                        <div class="hero-mini-stat"><span>50K+</span><span>Orders delivered</span></div>
                        <div class="hero-mini-stat"><span>4.8★</span><span>Average rating</span></div>
                        <div class="hero-mini-stat"><span>30 min</span><span>Average delivery</span></div>
                    </div>
                </div>
            </div>

            <!-- Category Chips -->
            <div class="category-chips">
                <div class="chip">🥗 Veg</div>
                <div class="chip">🍗 Non‑Veg</div>
                <div class="chip">🍕 Pizza</div>
                <div class="chip">🍔 Burger</div>
                <div class="chip">🍰 Dessert</div>
                <div class="chip">☕ Beverage</div>
                <div class="chip">🔥 Spicy Picks</div>
                <div class="chip">🌟 Best Sellers</div>
            </div>

            <!-- Promo Banner -->
            <div class="promo-banner">
                <div class="promo-left"><span class="promo-badge">LIMITED</span> Flat 30% OFF on first order 🎉</div>
                <div class="promo-right">Use code <b>WELCOME30</b> at checkout. T&C apply.</div>
            </div>

            <div class="features-grid">
                <div class="feature-card">
                    <div class="feature-icon">🚚</div>
                    <h3>Fast Delivery</h3>
                    <p>Get your food delivered within 30 minutes or it's free!</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">👨‍🍳</div>
                    <h3>Fresh & Quality</h3>
                    <p>Made with fresh ingredients by our expert chefs daily.</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">💰</div>
                    <h3>Best Prices</h3>
                    <p>Affordable prices with amazing taste. Value for money guaranteed!</p>
                </div>
                <div class="feature-card">
                    <div class="feature-icon">📱</div>
                    <h3>Easy Ordering</h3>
                    <p>Simple and intuitive ordering process. Just a few clicks away!</p>
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="quick-stats">
                <div class="stat-card"><div class="stat-icon">🍽️</div><div class="stat-info"><div class="stat-num">50K+</div><div class="stat-label">Meals Served</div></div></div>
                <div class="stat-card"><div class="stat-icon">⏱️</div><div class="stat-info"><div class="stat-num">30 min</div><div class="stat-label">Avg Delivery</div></div></div>
                <div class="stat-card"><div class="stat-icon">🏙️</div><div class="stat-info"><div class="stat-num">25</div><div class="stat-label">Cities</div></div></div>
                <div class="stat-card"><div class="stat-icon">⭐</div><div class="stat-info"><div class="stat-num">4.8/5</div><div class="stat-label">Customer Rating</div></div></div>
            </div>

            <!-- Trust Badges -->
            <div class="trust-badges">
                <div class="badge-card">🧼 Hygienic Kitchens</div>
                <div class="badge-card">🧊 Fresh Ingredients</div>
                <div class="badge-card">💳 Secure Payments</div>
                <div class="badge-card">🤝 24x7 Support</div>
            </div>

            <!-- Testimonials -->
            <div class="testimonials">
                <h3>What our customers say</h3>
                <div class="testimonial-grid">
                    <div class="testimonial"><p>The biryani was absolutely delicious and delivery was super fast!</p><div class="author">😊 Riya S.</div></div>
                    <div class="testimonial"><p>Great taste, great prices. My go-to app for late night cravings.</p><div class="author">🍕 Arjun K.</div></div>
                    <div class="testimonial"><p>Love the fresh ingredients and the variety available. Highly recommended!</p><div class="author">🌟 Neha M.</div></div>
                </div>
            </div>

            <!-- Secondary CTA -->
            <div class="secondary-cta">
                <h3>Ready to taste happiness?</h3>
                <p>Order now and get exciting offers on your favorites!</p>
                <button class="cta-button" onclick="showPage('products')">Browse Menu 🍽️</button>
            </div>
        </div>
    </div>

    <!-- PRODUCTS PAGE -->
    <div id="products-page" class="page-section">
        <div class="container">
            <section id="products">
                <div id="filter-bar">
                    <input type="text" id="search-box" placeholder="🔍 Search food...">
                    <select id="category-filter">
                        <option value="all">All Categories</option>
                        <option value="veg">🥗 Veg</option>
                        <option value="non-veg">🍗 Non-Veg</option>
                        <option value="dessert">🍰 Dessert</option>
                        <option value="beverage">☕ Beverage</option>
                        <option value="pizza">🍕 Pizza</option>
                        <option value="spicy">🔥 Spicy Picks</option>
                        <option value="sweet">🍬 Sweet</option>
                    </select>
                </div>

                <h2>Available Products</h2>
                <div class="item-count" id="item-count"></div>
                <div id="product-grid" class="grid"></div>
                <div id="pagination"></div>
            </section>

            <aside id="cart" class="auth-required">
                <h2>🛒 Shopping Cart</h2>
                <ul id="cart-items"></ul>
                <p id="total-price">Total: ₹0.00</p>
                <button id="buy-button" onclick="checkout()">💳 Checkout</button>
            </aside>
        </div>
    </div>

    <!-- CART PAGE -->
    <div id="cart-page" class="page-section">
        <div class="container">
            <div class="cart-page-container">
                <h2 style="text-align: center; color: #11998e; margin-bottom: 30px;">🛒 Your Shopping Cart</h2>
                
                <div id="cart-page-content">
                    <div class="empty-cart" id="empty-cart-message">
                        <div class="empty-cart-icon">🛒</div>
                        <h3>Your cart is empty!</h3>
                        <p>Looks like you haven't added any delicious items to your cart yet.</p>
                        <button class="cta-button" onclick="showPage('products')" style="margin-top: 20px;">Browse Products</button>
                    </div>
                    
                    <div id="cart-items-page" style="display: none;">
                        <ul id="cart-items-full"></ul>
                        <div style="border-top: 2px solid #11998e; padding-top: 20px; margin-top: 30px;">
                            <p id="total-price-page" style="font-size: 1.8rem; font-weight: bold; text-align: right; color: #11998e;">Total: ₹0.00</p>
                            <button class="submit-btn" onclick="checkout()" style="margin-top: 15px;">Complete Order 🎉</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CONTACT PAGE -->
    <div id="contact-page" class="page-section">
        <div class="container">
            <h2 style="text-align: center; color: #11998e; margin-bottom: 40px;">📞 Contact Us</h2>
            
            <div class="contact-form">
                <form id="contact-form" onsubmit="submitContactForm(event)">
                    <div class="form-group">
                        <label for="name">Full Name *</label>
                        <input type="text" id="name" name="name" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email Address *</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone">
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject *</label>
                        <select id="subject" name="subject" required>
                            <option value="">Select a subject</option>
                            <option value="order">Order Related</option>
                            <option value="complaint">Complaint</option>
                            <option value="suggestion">Suggestion</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="message">Message *</label>
                        <textarea id="message" name="message" rows="5" required placeholder="Tell us how we can help you..."></textarea>
                    </div>
                    
                    <button type="submit" class="submit-btn">Send Message 📧</button>
                </form>
            </div>
            
            <div style="margin-top: 50px; text-align: center;">
                <h3 style="color: #11998e; margin-bottom: 20px;">Other Ways to Reach Us</h3>
                <div class="features-grid" style="max-width: 800px; margin: 0 auto;">
                    <div class="feature-card">
                        <div class="feature-icon">📞</div>
                        <h4>Call Us</h4>
                        <p>+91 98765 43210<br>Available 24/7</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📧</div>
                        <h4>Email Us</h4>
                        <p>support@fooddelivery.com<br>Response within 2 hours</p>
                    </div>
                    <div class="feature-card">
                        <div class="feature-icon">📍</div>
                        <h4>Visit Us</h4>
                        <p>123 Food Street, Taste City<br>Open: 9 AM - 11 PM</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Welcome Modal -->
    <div id="welcome-modal" class="welcome-modal">
        <div class="welcome-content">
            <div class="welcome-logo">🍽️</div>
            <h1>Welcome to My AR Fool E-Restaurant!</h1>
            <p>Experience the finest culinary delights delivered fresh to your doorstep. Discover amazing flavors and enjoy exceptional service!</p>
            <button class="welcome-btn" onclick="closeWelcomeModal()">Let's Explore! 🚀</button>
        </div>
    </div>

    <!-- Modern Welcome Popup -->
    <div id="welcome-popup-overlay" class="welcome-popup-overlay">
        <div class="welcome-popup">
            <div class="welcome-popup-header">
                <span class="welcome-popup-icon">🎉</span>
                <h1 class="welcome-popup-title">Welcome to AR Food!</h1>
                <p class="welcome-popup-subtitle">Login successful</p>
            </div>
            
            <div class="welcome-popup-body">
                <div class="welcome-message">
                    Great! You're now logged in. Explore our delicious menu and enjoy fresh food delivered to your doorstep!
                </div>
                
                <div class="welcome-features">
                    <div class="welcome-feature">
                        <span class="welcome-feature-icon">🍕</span>
                        <div class="welcome-feature-text">Fresh</div>
                    </div>
                    <div class="welcome-feature">
                        <span class="welcome-feature-icon">🚚</span>
                        <div class="welcome-feature-text">Fast</div>
                    </div>
                    <div class="welcome-feature">
                        <span class="welcome-feature-icon">⭐</span>
                        <div class="welcome-feature-text">Quality</div>
                    </div>
                    <div class="welcome-feature">
                        <span class="welcome-feature-icon">💳</span>
                        <div class="welcome-feature-text">Secure</div>
                    </div>
                </div>
            </div>
            
            <div class="welcome-popup-footer">
                <button class="welcome-close-btn" onclick="closeWelcomePopup()">
                    Let's Explore! 🚀
                </button>
            </div>
        </div>
    </div>

    <!-- Checkout Modal (multi-step) -->
    <div id="checkout-modal" class="modal-overlay">
        <div class="modal-content">
            <button class="modal-close" onclick="closeCheckoutModal()">&times;</button>
            <div id="checkout-flow"><!-- Steps will be rendered by JS --></div>
            <div id="checkout-confetti-container"></div>
        </div>
    </div>

    <script>
        const products = [
            // Non-Veg Items (15 items)
            { 
                name: "Chicken Burger", 
                price: 120, 
                category: "non-veg", 
                icon: "🍔",
                description: "Juicy grilled chicken patty with fresh lettuce, tomatoes, and special sauce in a toasted bun.",
                calories: 450,
                protein: "28g",
                carbs: "35g",
                fat: "22g",
                sugar: "5g",
                fiber: "3g",
                sodium: "850mg",
                weight: "250g",
                ingredients: ["Chicken breast", "Whole wheat bun", "Lettuce", "Tomato", "Onion", "Special sauce", "Cheese"],
                allergens: ["Gluten", "Dairy", "Eggs"],
                spiceLevel: "Mild",
                preparationTime: "12-15 minutes",
                tags: ["Popular", "Protein Rich"]
            },
            { 
                name: "Beef Burger", 
                price: 150, 
                category: "non-veg", 
                icon: "🍔",
                description: "Premium beef patty with caramelized onions, pickles, and signature sauce.",
                calories: 520,
                protein: "32g",
                carbs: "38g",
                fat: "28g",
                sugar: "6g",
                fiber: "4g",
                sodium: "920mg",
                weight: "280g",
                ingredients: ["Ground beef", "Brioche bun", "Caramelized onions", "Pickles", "Lettuce", "Tomato", "Signature sauce"],
                allergens: ["Gluten", "Dairy"],
                spiceLevel: "Medium",
                preparationTime: "15-18 minutes",
                tags: ["Premium", "Chef's Special"]
            },
            { 
                name: "Chicken Biryani", 
                price: 200, 
                category: "non-veg", 
                icon: "🍛",
                description: "Aromatic basmati rice cooked with tender chicken pieces and traditional spices.",
                calories: 680,
                protein: "35g",
                carbs: "78g",
                fat: "18g",
                sugar: "8g",
                fiber: "6g",
                sodium: "1200mg",
                weight: "400g",
                ingredients: ["Basmati rice", "Chicken", "Onions", "Yogurt", "Garam masala", "Saffron", "Mint", "Coriander"],
                allergens: ["Dairy"],
                spiceLevel: "Medium-Hot",
                preparationTime: "25-30 minutes",
                tags: ["Traditional", "Bestseller", "Aromatic"]
            },
            { 
                name: "Mutton Biryani", 
                price: 280, 
                category: "non-veg", 
                icon: "🍛",
                description: "Royal mutton biryani with slow-cooked tender meat and fragrant rice.",
                calories: 750,
                protein: "40g",
                carbs: "82g",
                fat: "25g",
                sugar: "9g",
                fiber: "7g",
                sodium: "1350mg",
                weight: "450g",
                ingredients: ["Basmati rice", "Mutton", "Onions", "Yogurt", "Royal spices", "Saffron", "Mint", "Ghee"],
                allergens: ["Dairy"],
                spiceLevel: "Hot",
                preparationTime: "35-40 minutes",
                tags: ["Royal", "Premium", "Slow Cooked"]
            },
            { 
                name: "Chicken Tikka", 
                price: 180, 
                category: "non-veg", 
                icon: "🍗",
                description: "Marinated chicken pieces grilled to perfection with Indian spices.",
                calories: 320,
                protein: "42g",
                carbs: "8g",
                fat: "12g",
                sugar: "3g",
                fiber: "2g",
                sodium: "680mg",
                weight: "200g",
                ingredients: ["Chicken breast", "Yogurt", "Ginger-garlic paste", "Red chili powder", "Garam masala", "Lemon juice"],
                allergens: ["Dairy"],
                spiceLevel: "Medium-Hot",
                preparationTime: "20-25 minutes",
                tags: ["Grilled", "High Protein", "Low Carb"]
            },
            { name: "Chicken Wings", price: 160, category: "non-veg", icon: "🍗" },
            { name: "Fish Fry", price: 220, category: "non-veg", icon: "🐟" },
            { name: "Prawn Curry", price: 300, category: "non-veg", icon: "🦐" },
            { name: "Chicken Kebab", price: 190, category: "non-veg", icon: "🍢" },
            { name: "Chicken Pizza", price: 250, category: "non-veg", icon: "🍕" },
            { name: "BBQ Chicken", price: 240, category: "non-veg", icon: "🍗" },
            { name: "Chicken Shawarma", price: 130, category: "non-veg", icon: "🌯" },
            { name: "Egg Curry", price: 100, category: "non-veg", icon: "🥚" },
            { name: "Butter Chicken", price: 220, category: "non-veg", icon: "🍗" },
            { name: "Tandoori Chicken", price: 200, category: "non-veg", icon: "🍗" },

            // Veg Items (20 items)
            { name: "Veg Noodles", price: 150, category: "veg", icon: "🍜" },
            { name: "Paneer Tikka", price: 170, category: "veg", icon: "🧀" },
            { name: "Veg Biryani", price: 160, category: "veg", icon: "🍛" },
            { name: "Paneer Butter Masala", price: 190, category: "veg", icon: "🧀" },
            { name: "Veg Pizza", price: 220, category: "veg", icon: "🍕" },
            { name: "Veg Burger", price: 90, category: "veg", icon: "🍔" },
            { name: "Aloo Paratha", price: 80, category: "veg", icon: "🫓" },
            { name: "Dal Makhani", price: 140, category: "veg", icon: "🍲" },
            { name: "Chole Bhature", price: 120, category: "veg", icon: "🫓" },
            { name: "Palak Paneer", price: 160, category: "veg", icon: "🥬" },
            { name: "Veg Manchurian", price: 130, category: "veg", icon: "🥟" },
            { name: "Veg Fried Rice", price: 140, category: "veg", icon: "🍚" },
            { name: "Masala Dosa", price: 100, category: "veg", icon: "🫓" },
            { name: "Idli Sambar", price: 80, category: "veg", icon: "🫓" },
            { name: "Veg Spring Roll", price: 110, category: "veg", icon: "🥟" },
            { name: "Pav Bhaji", price: 100, category: "veg", icon: "🍞" },
            { name: "Veg Pasta", price: 150, category: "veg", icon: "🍝" },
            { name: "Paneer Sandwich", price: 90, category: "veg", icon: "🥪" },
            { name: "Mushroom Curry", price: 170, category: "veg", icon: "🍄" },
            { name: "Veg Pulao", price: 130, category: "veg", icon: "🍚" },

            // Desserts (15 items)
            { name: "Gulab Jamun", price: 100, category: "dessert", icon: "🍡" },
            { name: "Rasgulla", price: 90, category: "dessert", icon: "🍡" },
            { name: "Chocolate Cake", price: 180, category: "dessert", icon: "🍰" },
            { name: "Ice Cream", price: 120, category: "dessert", icon: "🍨" },
            { name: "Brownie", price: 140, category: "dessert", icon: "🍫" },
            { name: "Rasmalai", price: 110, category: "dessert", icon: "🍡" },
            { name: "Jalebi", price: 80, category: "dessert", icon: "🥨" },
            { name: "Kheer", price: 90, category: "dessert", icon: "🥣" },
            { name: "Tiramisu", price: 200, category: "dessert", icon: "🍰" },
            { name: "Cheesecake", price: 220, category: "dessert", icon: "🍰" },
            { name: "Donut", price: 70, category: "dessert", icon: "🍩" },
            { name: "Cupcake", price: 80, category: "dessert", icon: "🧁" },
            { name: "Pancake", price: 130, category: "dessert", icon: "🥞" },
            { name: "Waffle", price: 150, category: "dessert", icon: "🧇" },
            { name: "Muffin", price: 90, category: "dessert", icon: "🧁" },

            // Beverages (12 items)
            { name: "Coffee", price: 60, category: "beverage", icon: "☕" },
            { name: "Tea", price: 40, category: "beverage", icon: "🍵" },
            { name: "Mango Shake", price: 100, category: "beverage", icon: "🥤" },
            { name: "Cold Coffee", price: 80, category: "beverage", icon: "🧋" },
            { name: "Lemonade", price: 60, category: "beverage", icon: "🍋" },
            { name: "Orange Juice", price: 80, category: "beverage", icon: "🍊" },
            { name: "Smoothie", price: 120, category: "beverage", icon: "🥤" },
            { name: "Lassi", price: 70, category: "beverage", icon: "🥛" },
            { name: "Masala Chai", price: 50, category: "beverage", icon: "🍵" },
            { name: "Mojito", price: 90, category: "beverage", icon: "🍹" },
            { name: "Hot Chocolate", price: 100, category: "beverage", icon: "☕" },
            { name: "Green Tea", price: 50, category: "beverage", icon: "🍵" },

            // Additional Non-Veg Items (35 more items)
            { name: "Chicken Wrap", price: 140, category: "non-veg", icon: "🌯" },
            { name: "Fish Curry", price: 250, category: "non-veg", icon: "🐟" },
            { name: "Mutton Curry", price: 320, category: "non-veg", icon: "🍲" },
            { name: "Chicken Noodles", price: 170, category: "non-veg", icon: "🍜" },
            { name: "Beef Steak", price: 400, category: "non-veg", icon: "🥩" },
            { name: "Chicken Sandwich", price: 110, category: "non-veg", icon: "🥪" },
            { name: "Fish Biryani", price: 230, category: "non-veg", icon: "🍛" },
            { name: "Chicken Rolls", price: 120, category: "non-veg", icon: "🌯" },
            { name: "Mutton Kebab", price: 270, category: "non-veg", icon: "🍢" },
            { name: "Chicken Pasta", price: 180, category: "non-veg", icon: "🍝" },
            { name: "Fish Tikka", price: 210, category: "non-veg", icon: "🐟" },
            { name: "Beef Curry", price: 290, category: "non-veg", icon: "🍲" },
            { name: "Chicken Fried Rice", price: 160, category: "non-veg", icon: "🍚" },
            { name: "Turkey Sandwich", price: 150, category: "non-veg", icon: "🥪" },
            { name: "Lamb Chops", price: 350, category: "non-veg", icon: "🍖" },
            { name: "Chicken Quesadilla", price: 190, category: "non-veg", icon: "🌮" },
            { name: "Fish Tacos", price: 200, category: "non-veg", icon: "🌮" },
            { name: "Chicken Salad", price: 130, category: "non-veg", icon: "🥗" },
            { name: "Pork Ribs", price: 380, category: "non-veg", icon: "🍖" },
            { name: "Chicken Momos", price: 140, category: "non-veg", icon: "🥟" },
            { name: "Fish & Chips", price: 220, category: "non-veg", icon: "🍟" },
            { name: "Beef Burger Deluxe", price: 180, category: "non-veg", icon: "🍔" },
            { name: "Chicken Chow Mein", price: 160, category: "non-veg", icon: "🍜" },
            { name: "Mutton Biryani Special", price: 320, category: "non-veg", icon: "🍛" },
            { name: "Grilled Chicken", price: 210, category: "non-veg", icon: "🍗" },
            { name: "Fish Masala", price: 240, category: "non-veg", icon: "🐟" },
            { name: "Chicken Tandoori Platter", price: 280, category: "non-veg", icon: "🍗" },
            { name: "Beef Stroganoff", price: 310, category: "non-veg", icon: "🍲" },
            { name: "Chicken Caesar Wrap", price: 150, category: "non-veg", icon: "🌯" },
            { name: "Salmon Grilled", price: 350, category: "non-veg", icon: "🐟" },
            { name: "Chicken Manchurian", price: 170, category: "non-veg", icon: "🍗" },
            { name: "Duck Curry", price: 380, category: "non-veg", icon: "🦆" },
            { name: "Chicken Hot Wings", price: 180, category: "non-veg", icon: "🍗" },
            { name: "Fish Fingers", price: 160, category: "non-veg", icon: "🐟" },
            { name: "Mutton Korma", price: 300, category: "non-veg", icon: "🍲" },

            // Additional Veg Items (50 more items)
            { name: "Veggie Wrap", price: 120, category: "veg", icon: "🌯" },
            { name: "Mushroom Pizza", price: 200, category: "veg", icon: "🍕" },
            { name: "Veg Sandwich", price: 80, category: "veg", icon: "🥪" },
            { name: "Stuffed Paratha", price: 90, category: "veg", icon: "🫓" },
            { name: "Veg Momos", price: 100, category: "veg", icon: "🥟" },
            { name: "Rajma Rice", price: 120, category: "veg", icon: "🍚" },
            { name: "Veg Hakka Noodles", price: 130, category: "veg", icon: "🍜" },
            { name: "Paneer Pizza", price: 240, category: "veg", icon: "🍕" },
            { name: "Veg Quesadilla", price: 140, category: "veg", icon: "🌮" },
            { name: "Mushroom Biryani", price: 180, category: "veg", icon: "🍛" },
            { name: "Veg Club Sandwich", price: 110, category: "veg", icon: "🥪" },
            { name: "Paneer Wrap", price: 130, category: "veg", icon: "🌯" },
            { name: "Veg Thali", price: 150, category: "veg", icon: "🍽️" },
            { name: "Spinach Pizza", price: 190, category: "veg", icon: "🍕" },
            { name: "Veg Burger", price: 90, category: "veg", icon: "🍔" },
            { name: "Paneer Noodles", price: 140, category: "veg", icon: "🍜" },
            { name: "Veg Rolls", price: 100, category: "veg", icon: "🌯" },
            { name: "Mushroom Curry", price: 160, category: "veg", icon: "🍄" },
            { name: "Veg Pasta", price: 130, category: "veg", icon: "🍝" },
            { name: "Paneer Salad", price: 120, category: "veg", icon: "🥗" },
            { name: "Veg Schezwan Rice", price: 140, category: "veg", icon: "🍚" },
            { name: "Stuffed Kulcha", price: 100, category: "veg", icon: "🫓" },
            { name: "Veg Manchow Soup", price: 80, category: "veg", icon: "🍲" },
            { name: "Paneer Tikka Roll", price: 150, category: "veg", icon: "🌯" },
            { name: "Veg Grilled Sandwich", price: 100, category: "veg", icon: "🥪" },
            { name: "Mushroom Pasta", price: 160, category: "veg", icon: "🍝" },
            { name: "Veg Caesar Salad", price: 110, category: "veg", icon: "🥗" },
            { name: "Paneer Burger", price: 120, category: "veg", icon: "🍔" },
            { name: "Veg Chow Mein", price: 120, category: "veg", icon: "🍜" },
            { name: "Stuffed Capsicum", price: 140, category: "veg", icon: "🫑" },
            { name: "Veg Tacos", price: 130, category: "veg", icon: "🌮" },
            { name: "Paneer Kofta", price: 170, category: "veg", icon: "🍲" },
            { name: "Veg Hot & Sour Soup", price: 70, category: "veg", icon: "🍲" },
            { name: "Mushroom Sandwich", price: 90, category: "veg", icon: "🥪" },
            { name: "Veg Spring Rolls", price: 110, category: "veg", icon: "🥟" },
            { name: "Paneer Paratha", price: 100, category: "veg", icon: "🫓" },
            { name: "Veg Seekh Kebab", price: 140, category: "veg", icon: "🍢" },
            { name: "Mushroom Biryani Special", price: 200, category: "veg", icon: "🍛" },
            { name: "Veg Laksa", price: 150, category: "veg", icon: "🍜" },
            { name: "Paneer Makhani", price: 180, category: "veg", icon: "🍲" },
            { name: "Veg Sizzler", price: 220, category: "veg", icon: "🔥" },
            { name: "Stuffed Naan", price: 80, category: "veg", icon: "🫓" },
            { name: "Veg Tom Yum Soup", price: 90, category: "veg", icon: "🍲" },
            { name: "Paneer Chilli", price: 160, category: "veg", icon: "🌶️" },
            { name: "Veg Mediterranean Bowl", price: 170, category: "veg", icon: "🥗" },
            { name: "Mushroom Stroganoff", price: 180, category: "veg", icon: "🍲" },
            { name: "Veg Pho", price: 140, category: "veg", icon: "🍜" },
            { name: "Paneer Shawarma", price: 130, category: "veg", icon: "🌯" },
            { name: "Veg Paella", price: 190, category: "veg", icon: "🥘" },
            { name: "Mushroom Risotto", price: 200, category: "veg", icon: "🍚" },
            { name: "Veg Burrito Bowl", price: 160, category: "veg", icon: "🥗" },

            // Additional Desserts (30 more items)
            { name: "Chocolate Mousse", price: 150, category: "dessert", icon: "🍫" },
            { name: "Strawberry Cake", price: 160, category: "dessert", icon: "🍰" },
            { name: "Vanilla Ice Cream", price: 100, category: "dessert", icon: "🍨" },
            { name: "Apple Pie", price: 140, category: "dessert", icon: "🥧" },
            { name: "Chocolate Chip Cookie", price: 60, category: "dessert", icon: "🍪" },
            { name: "Red Velvet Cake", price: 180, category: "dessert", icon: "🍰" },
            { name: "Mango Kulfi", price: 80, category: "dessert", icon: "🍨" },
            { name: "Chocolate Brownie Sundae", price: 170, category: "dessert", icon: "🍨" },
            { name: "Lemon Tart", price: 120, category: "dessert", icon: "🥧" },
            { name: "Chocolate Lava Cake", price: 190, category: "dessert", icon: "🍰" },
            { name: "Fruit Salad", price: 90, category: "dessert", icon: "🥗" },
            { name: "Caramel Pudding", price: 110, category: "dessert", icon: "🍮" },
            { name: "Black Forest Cake", price: 200, category: "dessert", icon: "🍰" },
            { name: "Chocolate Shake", price: 120, category: "dessert", icon: "🥤" },
            { name: "Banana Split", price: 150, category: "dessert", icon: "🍌" },
            { name: "Chocolate Truffle", price: 80, category: "dessert", icon: "🍫" },
            { name: "Strawberry Milkshake", price: 110, category: "dessert", icon: "🥤" },
            { name: "Chocolate Eclair", price: 90, category: "dessert", icon: "🥐" },
            { name: "Vanilla Cake", price: 160, category: "dessert", icon: "🍰" },
            { name: "Mango Cheesecake", price: 180, category: "dessert", icon: "🍰" },
            { name: "Chocolate Sundae", price: 130, category: "dessert", icon: "🍨" },
            { name: "Pineapple Cake", price: 170, category: "dessert", icon: "🍰" },
            { name: "Chocolate Cookie Shake", price: 140, category: "dessert", icon: "🥤" },
            { name: "Butterscotch Ice Cream", price: 110, category: "dessert", icon: "🍨" },
            { name: "Chocolate Fudge", price: 100, category: "dessert", icon: "🍫" },
            { name: "Strawberry Cheesecake", price: 190, category: "dessert", icon: "🍰" },
            { name: "Vanilla Milkshake", price: 100, category: "dessert", icon: "🥤" },
            { name: "Chocolate Wafer", price: 70, category: "dessert", icon: "🍪" },
            { name: "Mango Ice Cream", price: 120, category: "dessert", icon: "🍨" },
            { name: "Chocolate Pastry", price: 80, category: "dessert", icon: "🧁" },

            // Additional Beverages (40 more items)
            { name: "Iced Tea", price: 70, category: "beverage", icon: "🧊" },
            { name: "Fresh Lime Water", price: 50, category: "beverage", icon: "🍋" },
            { name: "Apple Juice", price: 90, category: "beverage", icon: "🍎" },
            { name: "Coconut Water", price: 60, category: "beverage", icon: "🥥" },
            { name: "Banana Shake", price: 100, category: "beverage", icon: "🍌" },
            { name: "Pineapple Juice", price: 85, category: "beverage", icon: "🍍" },
            { name: "Watermelon Juice", price: 75, category: "beverage", icon: "🍉" },
            { name: "Pomegranate Juice", price: 95, category: "beverage", icon: "🥤" },
            { name: "Ginger Tea", price: 45, category: "beverage", icon: "🍵" },
            { name: "Cardamom Tea", price: 50, category: "beverage", icon: "🍵" },
            { name: "Mint Lemonade", price: 70, category: "beverage", icon: "🍋" },
            { name: "Rose Lassi", price: 80, category: "beverage", icon: "🥛" },
            { name: "Sweet Lassi", price: 70, category: "beverage", icon: "🥛" },
            { name: "Salted Lassi", price: 65, category: "beverage", icon: "🥛" },
            { name: "Chocolate Milkshake", price: 120, category: "beverage", icon: "🥤" },
            { name: "Vanilla Milkshake", price: 110, category: "beverage", icon: "🥤" },
            { name: "Strawberry Smoothie", price: 130, category: "beverage", icon: "🍓" },
            { name: "Mixed Fruit Juice", price: 100, category: "beverage", icon: "🥤" },
            { name: "Espresso", price: 80, category: "beverage", icon: "☕" },
            { name: "Cappuccino", price: 90, category: "beverage", icon: "☕" },
            { name: "Latte", price: 100, category: "beverage", icon: "☕" },
            { name: "Americano", price: 85, category: "beverage", icon: "☕" },
            { name: "Macchiato", price: 95, category: "beverage", icon: "☕" },
            { name: "Mocha", price: 110, category: "beverage", icon: "☕" },
            { name: "Frappuccino", price: 140, category: "beverage", icon: "🧋" },
            { name: "Bubble Tea", price: 120, category: "beverage", icon: "🧋" },
            { name: "Thai Iced Tea", price: 90, category: "beverage", icon: "🧋" },
            { name: "Matcha Latte", price: 110, category: "beverage", icon: "🍵" },
            { name: "Turmeric Latte", price: 100, category: "beverage", icon: "☕" },
            { name: "Cold Brew", price: 95, category: "beverage", icon: "☕" },
            { name: "Nitro Coffee", price: 120, category: "beverage", icon: "☕" },
            { name: "Virgin Mojito", price: 85, category: "beverage", icon: "🍹" },
            { name: "Blue Lagoon", price: 90, category: "beverage", icon: "🍹" },
            { name: "Shirley Temple", price: 80, category: "beverage", icon: "🍹" },
            { name: "Arnold Palmer", price: 75, category: "beverage", icon: "🥤" },
            { name: "Cranberry Juice", price: 85, category: "beverage", icon: "🥤" },
            { name: "Grape Juice", price: 80, category: "beverage", icon: "🍇" },
            { name: "Peach Iced Tea", price: 85, category: "beverage", icon: "🧊" },
            { name: "Lemon Iced Tea", price: 80, category: "beverage", icon: "🧊" },
            { name: "Energy Drink", price: 120, category: "beverage", icon: "⚡" },

            // Pizza (20)
            { name: "Margherita Pizza", price: 220, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?pizza,margherita&sig=1" },
            { name: "Farmhouse Pizza", price: 260, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?pizza,vegetable&sig=2" },
            { name: "Pepperoni Pizza", price: 280, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?pepperoni,pizza&sig=3" },
            { name: "BBQ Chicken Pizza", price: 300, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?bbq,chicken,pizza&sig=4" },
            { name: "Four Cheese Pizza", price: 290, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?four,cheese,pizza&sig=5" },
            { name: "Veggie Supreme", price: 270, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?veggie,pizza&sig=6" },
            { name: "Paneer Tikka Pizza", price: 275, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?paneer,pizza&sig=7" },
            { name: "Mexican Wave Pizza", price: 285, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?mexican,pizza&sig=8" },
            { name: "Hawaiian Pizza", price: 290, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?hawaiian,pizza&sig=9" },
            { name: "Mushroom Delight Pizza", price: 250, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?mushroom,pizza&sig=10" },
            { name: "Classic Cheese Pizza", price: 210, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?cheese,pizza&sig=11" },
            { name: "Tandoori Chicken Pizza", price: 310, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?tandoori,chicken,pizza&sig=12" },
            { name: "Spinach Corn Pizza", price: 240, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?spinach,corn,pizza&sig=13" },
            { name: "Peri-Peri Pizza", price: 295, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?peri,peri,pizza&sig=14" },
            { name: "Garlic Bread Pizza", price: 230, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?garlic,bread,pizza&sig=15" },
            { name: "Sausage Feast Pizza", price: 300, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?sausage,pizza&sig=16" },
            { name: "Marinara Neapolitan", price: 260, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?neapolitan,pizza&sig=17" },
            { name: "Truffle Mushroom Pizza", price: 330, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?truffle,pizza&sig=18" },
            { name: "Corn & Cheese Pizza", price: 235, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?corn,cheese,pizza&sig=19" },
            { name: "Olive & Jalapeno Pizza", price: 255, category: "pizza", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?olive,jalapeno,pizza&sig=20" },

            // Spicy Picks (15)
            { name: "Spicy Paneer Roll", price: 140, category: "spicy", icon: "🌯", image: "https://source.unsplash.com/featured/800x600/?paneer,wrap,spicy&sig=1021" },
            { name: "Peri-Peri Fries", price: 120, category: "spicy", icon: "🍟", image: "https://source.unsplash.com/featured/800x600/?peri,peri,fries&sig=1022" },
            { name: "Chili Chicken", price: 220, category: "spicy", icon: "🍗", image: "https://source.unsplash.com/featured/800x600/?chilli,chicken,stir,fry&sig=1023" },
            { name: "Spicy Schezwan Noodles", price: 160, category: "spicy", icon: "🍜", image: "https://source.unsplash.com/featured/800x600/?schezwan,noodles,spicy&sig=1024" },
            { name: "Hot Wings", price: 190, category: "spicy", icon: "🍗", image: "https://source.unsplash.com/featured/800x600/?hot,spicy,chicken,wings&sig=1025" },
            { name: "Fiery Tacos", price: 170, category: "spicy", icon: "🌮", image: "https://source.unsplash.com/featured/800x600/?spicy,tacos,street&sig=1026" },
            { name: "Schezwan Fried Rice", price: 150, category: "spicy", icon: "🍚", image: "https://source.unsplash.com/featured/800x600/?schezwan,fried,rice,spicy&sig=1027" },
            { name: "Spicy Momos", price: 130, category: "spicy", icon: "🥟", image: "https://source.unsplash.com/featured/800x600/?spicy,momos,dumplings&sig=1028" },
            { name: "Piri-Piri Burger", price: 180, category: "spicy", icon: "🍔", image: "https://source.unsplash.com/featured/800x600/?piri,piri,spicy,burger&sig=1029" },
            { name: "Ghost Pepper Wings", price: 240, category: "spicy", icon: "🍗", image: "https://source.unsplash.com/featured/800x600/?ghost,pepper,wings,spicy&sig=1030" },
            { name: "Volcano Pizza Slice", price: 160, category: "spicy", icon: "🍕", image: "https://source.unsplash.com/featured/800x600/?spicy,pizza,slice&sig=1031" },
            { name: "Chili Paneer", price: 190, category: "spicy", icon: "🧀", image: "https://source.unsplash.com/featured/800x600/?chilli,paneer,indo,chinese&sig=1032" },
            { name: "Spicy Ramen Bowl", price: 210, category: "spicy", icon: "🍜", image: "https://source.unsplash.com/featured/800x600/?spicy,ramen,bowl&sig=1033" },
            { name: "Jalapeno Poppers", price: 150, category: "spicy", icon: "🌶️", image: "https://source.unsplash.com/featured/800x600/?jalapeno,poppers,cheese&sig=1034" },
            { name: "Kung Pao Veg", price: 200, category: "spicy", icon: "🥦", image: "https://source.unsplash.com/featured/800x600/?kung,pao,vegetables,spicy&sig=1035" },

            // Sweet (15)
            { name: "Chocolate Donut", price: 90, category: "sweet", icon: "🍩", image: "https://source.unsplash.com/featured/800x600/?chocolate,donut&sig=36" },
            { name: "Strawberry Cupcake", price: 110, category: "sweet", icon: "🧁", image: "https://source.unsplash.com/featured/800x600/?strawberry,cupcake&sig=37" },
            { name: "Blueberry Cheesecake", price: 220, category: "sweet", icon: "🍰", image: "https://source.unsplash.com/featured/800x600/?blueberry,cheesecake&sig=38" },
            { name: "Chocolate Brownie", price: 130, category: "sweet", icon: "🍫", image: "https://source.unsplash.com/featured/800x600/?chocolate,brownie&sig=39" },
            { name: "Vanilla Ice Cream", price: 100, category: "sweet", icon: "🍨", image: "https://source.unsplash.com/featured/800x600/?vanilla,icecream&sig=40" },
            { name: "Red Velvet Slice", price: 150, category: "sweet", icon: "🍰", image: "https://source.unsplash.com/featured/800x600/?red,velvet,cake&sig=41" },
            { name: "Butterscotch Sundae", price: 140, category: "sweet", icon: "🍨", image: "https://source.unsplash.com/featured/800x600/?butterscotch,sundae&sig=42" },
            { name: "Caramel Custard", price: 120, category: "sweet", icon: "🍮", image: "https://source.unsplash.com/featured/800x600/?caramel,custard&sig=43" },
            { name: "Pancake Stack", price: 160, category: "sweet", icon: "🥞", image: "https://source.unsplash.com/featured/800x600/?pancakes,syrup&sig=44" },
            { name: "Waffle & Berries", price: 170, category: "sweet", icon: "🧇", image: "https://source.unsplash.com/featured/800x600/?waffles,berries&sig=45" },
            { name: "Gulab Jamun Bowl", price: 120, category: "sweet", icon: "🍡", image: "https://source.unsplash.com/featured/800x600/?gulab,jamun&sig=46" },
            { name: "Rasmalai Cup", price: 130, category: "sweet", icon: "🍨", image: "https://source.unsplash.com/featured/800x600/?rasmalai,dessert&sig=47" },
            { name: "Tiramisu Slice", price: 200, category: "sweet", icon: "🍰", image: "https://source.unsplash.com/featured/800x600/?tiramisu,dessert&sig=48" },
            { name: "Fruit Tart", price: 150, category: "sweet", icon: "🥧", image: "https://source.unsplash.com/featured/800x600/?fruit,tart&sig=49" },
            { name: "Chocolate Mousse Cup", price: 160, category: "sweet", icon: "🍫", image: "https://source.unsplash.com/featured/800x600/?chocolate,mousse&sig=50" }
        ];

        let Items = [];

        // Pagination variables
        let currentPage = 1;
        const itemsPerPage = 10;
        let currentFilteredList = products.slice(); // default to full list
        let currentActivePage = 'home';

        // Navigation function
        function showPage(pageName) {
            // Hide all pages
            const pages = document.querySelectorAll('.page-section');
            pages.forEach(page => page.classList.remove('active'));
            
            // Show selected page
            const targetPage = document.getElementById(pageName + '-page');
            if (targetPage) {
                targetPage.classList.add('active');
            }
            
            // Update navigation active state
            const navLinks = document.querySelectorAll('header nav ul li a');
            navLinks.forEach(link => link.classList.remove('active'));
            
            // Find and activate current nav link
            navLinks.forEach(link => {
                if (link.textContent.toLowerCase().includes(pageName)) {
                    link.classList.add('active');
                }
            });
            
            currentActivePage = pageName;
            
            // Save current page to localStorage for refresh persistence
            localStorage.setItem('currentPage', pageName);
            
            // Update cart page when switching to cart
            if (pageName === 'cart') {
                updateCartPage();
            }
            
            // Update authentication-based UI for all pages
            updateAuthUI();
            
            // For products page, ensure auth UI is updated after any dynamic rendering
            if (pageName === 'products') {
                setTimeout(() => {
                    updateAuthUI();
                }, 100);
            }
            
            // Show welcome modal only when navigating to home page (not on initial load)
            if (pageName === 'home' && currentActivePage !== 'home') {
                setTimeout(() => {
                    showWelcomeModal();
                }, 300);
            }
            
            // Scroll to top
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }

        // Contact form submission
        function submitContactForm(event) {
            event.preventDefault();
            
            const formData = new FormData(event.target);
            const name = formData.get('name');
            const email = formData.get('email');
            const phone = formData.get('phone');
            const subject = formData.get('subject');
            const message = formData.get('message');
            
            // Simulate form submission
            alert(`Thank you ${name}! 🎉\n\nYour message has been received. We'll get back to you at ${email} within 24 hours.\n\nSubject: ${subject}\nMessage: ${message.substring(0, 100)}${message.length > 100 ? '...' : ''}`);
            
            // Reset form
            event.target.reset();
        }

        // Update cart page display
        function updateCartPage() {
            const emptyMessage = document.getElementById('empty-cart-message');
            const cartItems = document.getElementById('cart-items-page');
            const cartItemsFull = document.getElementById('cart-items-full');
            const totalPricePage = document.getElementById('total-price-page');
            
            if (Items.length === 0) {
                emptyMessage.style.display = 'block';
                cartItems.style.display = 'none';
            } else {
                emptyMessage.style.display = 'none';
                cartItems.style.display = 'block';
                
                // Update cart items in full page view
                cartItemsFull.innerHTML = '';
                let total = 0;
                
                Items.forEach((item, index) => {
                    total += item.price * item.quantity;
                    const li = document.createElement('li');
                    li.className = 'cart-item';
                    li.style.marginBottom = '20px';
                    li.innerHTML = `
                        <div class="cart-item-info" style="display: flex; align-items: center; gap: 15px; flex: 1;">
                            <span class="cart-item-icon" style="font-size: 2rem;">${item.icon || '🍽️'}</span>
                            <div class="cart-item-name" style="font-size: 1.2rem;">${item.name}<br><small style="color: #666;">₹${item.price} each</small></div>
                        </div>
                        <div class="quantity">
                            <button onclick="updateQuantity(${index}, ${item.quantity - 1})">-</button>
                            <input type="number" value="${item.quantity}" min="1" max="99"
                                onchange="updateQuantity(${index}, this.value)">
                            <button onclick="updateQuantity(${index}, ${item.quantity + 1})">+</button>
                        </div>
                        <div style="text-align: right;">
                            <div style="font-weight: bold; color: #11998e; font-size: 1.1rem;">₹${(item.price * item.quantity).toFixed(2)}</div>
                            <button class="delete-btn" onclick="deleteFromCart(${index})" style="margin-top: 8px;">🗑️ Remove</button>
                        </div>
                    `;
                    cartItemsFull.appendChild(li);
                });
                
                totalPricePage.textContent = `Total: ₹${total.toFixed(2)}`;
            }
        }

        function saveCart() {
            try {
                const cartData = JSON.stringify(Items);
                window.cartStorage = { cart: cartData };
            } catch (e) {
                console.error('Error saving cart:', e);
            }
        }

        function loadCart() {
            try {
                if (window.cartStorage && window.cartStorage.cart) {
                    Items = JSON.parse(window.cartStorage.cart);
                    updateCartDisplay();
                }
            } catch (e) {
                console.error('Error loading cart:', e);
            }
        }

        function renderProducts(list) {
            const grid = document.getElementById("product-grid");
            const countEl = document.getElementById("item-count");
            grid.innerHTML = "";

            // update item count to show total filtered items
            countEl.textContent = `Showing ${list.length} items`;

            // apply pagination
            const startIndex = (currentPage - 1) * itemsPerPage;
            const paginated = list.slice(startIndex, startIndex + itemsPerPage);

            paginated.forEach(p => {
                const div = document.createElement("div");
                div.className = "product";

                // Determine badge text: veg -> Best Seller, else -> Best Price
                let badgeHtml = "";
                if (p.category === "veg") {
                    badgeHtml = `<div class="badge">Best Seller</div>`;
                } else {
                    badgeHtml = `<div class="badge">Best Price</div>`;
                }

                div.innerHTML = `
                    ${badgeHtml}
                    <button class="favorite-btn" onclick="toggleFavorite('${p.name}', ${p.price}, '${p.icon}', '${p.category}')" id="fav-${p.name.replace(/\s+/g, '-')}">
                        ❤️
                    </button>
                    <div class="product-content" onclick="showProductDetail('${p.name}')" style="cursor: pointer;">
                        ${p.image ? `<img src="${p.image}" alt="${p.name}" class="product-image">` : ''}
                        <span class="product-icon">${p.icon}</span>
                        <span class="category-tag tag-${p.category}">${p.category.toUpperCase()}</span>
                        <h3>${p.name}</h3>
                        <p class="price">₹${p.price}</p>
                    </div>
                    <button class="auth-required" onclick="addToCart('${p.name}', ${p.price}, '${p.icon}')">Add to Cart</button>
                    <button class="login-required-btn" onclick="showLoginPrompt()" style="display: none;">Login to Add to Cart</button>
                `;
                grid.appendChild(div);
            });

            renderPagination(list.length);
            
            // Update favorite states after rendering products
            setTimeout(() => {
                updateFavoriteStates();
                updateAuthUI(); // Ensure auth UI is updated after products are rendered
            }, 50);
        }

        function renderPagination(totalItems) {
            const paginationEl = document.getElementById("pagination");
            paginationEl.innerHTML = "";

            const totalPages = Math.ceil(totalItems / itemsPerPage);
            if (totalPages <= 1) return;

            for (let i = 1; i <= totalPages; i++) {
                const btn = document.createElement("button");
                btn.className = "page-btn" + (i === currentPage ? " active" : "");
                btn.textContent = i;
                btn.onclick = function() {
                    if (i === currentPage) return;
                    currentPage = i;
                    // re-render using current filtered list
                    renderProducts(currentFilteredList);
                    // scroll to top of products for better UX
                    window.scrollTo({ top: 0, behavior: 'smooth' });
                };
                paginationEl.appendChild(btn);
            }
        }

        function filterProducts() {
            const search = document.getElementById("search-box").value.toLowerCase();
            const category = document.getElementById("category-filter").value;

            const filtered = products.filter(p => {
                const matchesName = p.name.toLowerCase().includes(search);
                const matchesCategory = category === "all" || p.category === category;
                return matchesName && matchesCategory;
            });

            // reset to page 1 when filter/search changes
            currentPage = 1;
            currentFilteredList = filtered;
            renderProducts(filtered);
        }

        document.getElementById("search-box").addEventListener("input", filterProducts);
        document.getElementById("category-filter").addEventListener("change", filterProducts);

        function addToCart(name, price, icon = '🍽️') {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            if (!currentUser) {
                showLoginPrompt();
                return;
            }
            
            const index = Items.findIndex(item => item.name === name);
            if (index !== -1) {
                Items[index].quantity += 1;
            } else {
                Items.push({ name, price, icon, quantity: 1 });
            }
            saveCart();
            updateCartDisplay();
        }

        function deleteFromCart(index) {
            Items.splice(index, 1);
            saveCart();
            updateCartDisplay();
        }

        function updateQuantity(index, quantity) {
            quantity = parseInt(quantity);
            if (quantity < 1) quantity = 1;
            if (quantity > 99) quantity = 99;
            Items[index].quantity = quantity;
            saveCart();
            updateCartDisplay();
        }

        let checkoutDeliveryAddress = '';
        let checkoutDeliveryPin = '';
        let checkoutPaymentMethod = '';
        let checkoutUpiId = '';

        function checkout() {
            if (Items.length === 0) {
                showErrorPopup('Your cart is empty! Please add items first.', 'Empty Cart');
                return;
            }

            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            if (!currentUser) {
                showLoginPrompt();
                return;
            }

            // Prefill delivery details from profile if not already set
            checkoutDeliveryAddress = checkoutDeliveryAddress || currentUser.address || '';
            checkoutDeliveryPin = checkoutDeliveryPin || currentUser.pin || '';

            renderCheckoutStep1();
            showCheckoutModal();
        }

        function renderCheckoutStep1() {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            const flow = document.getElementById('checkout-flow');
            if (!flow || !currentUser) return;

            let totalPrice = 0;
            let itemsHtml = '';
            Items.forEach(item => {
                totalPrice += item.price * item.quantity;
                itemsHtml += `
                    <div class="order-item">
                        <div class="item-details">
                            <div class="item-name">${item.name}</div>
                            <div class="item-quantity">Quantity: ${item.quantity}</div>
                        </div>
                        <div class="item-price">₹${(item.price * item.quantity).toFixed(2)}</div>
                    </div>
                `;
            });

            flow.innerHTML = `
                <div style="margin-bottom:12px;">
                    <div style="display:flex; justify-content:space-between; font-size:0.8rem; color:#6b7280; margin-bottom:6px;">
                        <span>Review</span>
                        <span>Payment</span>
                        <span>Confirmed</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:4px;">
                        <div style="flex:1; height:4px; border-radius:999px; background:linear-gradient(to right,#22c55e,#4ade80);"></div>
                        <div style="flex:1; height:4px; border-radius:999px; background:#e5e7eb;"></div>
                        <div style="flex:1; height:4px; border-radius:999px; background:#e5e7eb;"></div>
                    </div>
                </div>
                <div class="modal-header">
                    <div class="success-icon">📝</div>
                    <h2>Review Your Order</h2>
                    <p style="color:#666;margin:0;">Confirm your details and delivery address</p>
                </div>
                <div class="order-summary">
                    <div style="margin-bottom:15px; padding:12px; border-radius:14px; background:linear-gradient(135deg,#eff6ff,#eef2ff); border:1px solid #e5e7eb; display:flex; gap:10px; align-items:flex-start;">
                        <div style="font-size:1.4rem;">👤</div>
                        <div>
                            <div style="font-weight:bold; margin-bottom:4px; font-size:0.95rem;">Your Details</div>
                            <div style="font-size:0.9rem; color:#374151;">
                                <div>${currentUser.name || ''}</div>
                                <div>${currentUser.email || ''}</div>
                                <div>${currentUser.phone || ''}</div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom:15px; padding:12px; border-radius:14px; background:linear-gradient(135deg,#fef3c7,#fffbeb); border:1px solid #fde68a;">
                        <div style="font-weight:bold; margin-bottom:6px; display:flex; justify-content:space-between; align-items:center;">
                            <span>Delivery Address</span>
                            <span style="font-size:0.75rem; color:#92400e; background:#ffedd5; padding:2px 8px; border-radius:999px;">Editable</span>
                        </div>
                        <label style="font-size:0.8rem; color:#6b7280;">Address</label>
                        <input id="checkout-address-input" type="text" value="${checkoutDeliveryAddress || ''}" style="width:100%; padding:8px 10px; border-radius:8px; border:1px solid #d1d5db; margin-bottom:8px; font-size:0.9rem;" />
                        <label style="font-size:0.8rem; color:#6b7280;">PIN Code</label>
                        <input id="checkout-pin-input" type="text" value="${checkoutDeliveryPin || ''}" style="width:100%; padding:8px 10px; border-radius:8px; border:1px solid #d1d5db; font-size:0.9rem;" />
                        <div style="margin-top:6px; font-size:0.8rem; color:#6b7280;">This address will be used only for this order.</div>
                    </div>
                    <div style="margin-bottom:10px; font-weight:bold; display:flex; justify-content:space-between; align-items:center;">
                        <span>Items in your cart</span>
                        <span style="font-size:0.8rem; color:#6b7280;">${Items.length} item(s)</span>
                    </div>
                    ${itemsHtml}
                    <div class="order-item" style="border-top:1px solid #e5e7eb; margin-top:8px; padding-top:10px;">
                        <div class="item-details">
                            <div class="item-name">Total Amount</div>
                        </div>
                        <div class="item-price" style="font-size:1.1rem; color:#16a34a; font-weight:bold;">₹${totalPrice.toFixed(2)}</div>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button class="modal-btn secondary" onclick="closeCheckoutModal()">Cancel</button>
                    <button class="modal-btn primary" onclick="handleCheckoutContinue()">Continue to Payment</button>
                </div>
            `;
        }

        function handleCheckoutContinue() {
            const addressInput = document.getElementById('checkout-address-input');
            const pinInput = document.getElementById('checkout-pin-input');
            const address = addressInput ? addressInput.value.trim() : '';
            const pin = pinInput ? pinInput.value.trim() : '';

            if (!address || !pin) {
                showErrorPopup('Please enter delivery address and PIN code to continue.', 'Address Required');
                return;
            }

            checkoutDeliveryAddress = address;
            checkoutDeliveryPin = pin;

            renderCheckoutStep2();
        }

        function renderCheckoutStep2() {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            const flow = document.getElementById('checkout-flow');
            if (!flow || !currentUser) return;

            let totalPrice = 0;
            Items.forEach(item => {
                totalPrice += item.price * item.quantity;
            });

            flow.innerHTML = `
                <div style="margin-bottom:12px;">
                    <div style="display:flex; justify-content:space-between; font-size:0.8rem; color:#6b7280; margin-bottom:6px;">
                        <span>Review</span>
                        <span>Payment</span>
                        <span>Confirmed</span>
                    </div>
                    <div style="display:flex; align-items:center; gap:4px;">
                        <div style="flex:1; height:4px; border-radius:999px; background:#22c55e;"></div>
                        <div style="flex:1; height:4px; border-radius:999px; background:linear-gradient(to right,#22c55e,#4ade80);"></div>
                        <div style="flex:1; height:4px; border-radius:999px; background:#e5e7eb;"></div>
                    </div>
                </div>
                <div class="modal-header">
                    <div class="success-icon">💳</div>
                    <h2>Payment Details</h2>
                    <p style=\"color:#666;margin:0;\">Choose how you want to pay</p>
                </div>
                <div class="order-summary">
                    <div style="margin-bottom:15px; padding:12px; border-radius:14px; background:linear-gradient(135deg,#ecfdf3,#dcfce7); border:1px solid #bbf7d0; display:flex; gap:10px; align-items:flex-start;">
                        <div style="font-size:1.4rem;">📍</div>
                        <div>
                            <div style="font-weight:bold; margin-bottom:4px; font-size:0.95rem;">Delivering To</div>
                            <div style="font-size:0.9rem; color:#374151;">
                                <div>${currentUser.name || ''}</div>
                                <div>${checkoutDeliveryAddress}</div>
                                <div>PIN: ${checkoutDeliveryPin}</div>
                            </div>
                        </div>
                    </div>
                    <div style="margin-bottom:15px; padding:12px; border-radius:14px; background:linear-gradient(135deg,#eff6ff,#dbeafe); border:1px solid #bfdbfe; display:flex; justify-content:space-between; align-items:center;">
                        <div>
                            <div style="font-weight:bold; margin-bottom:4px;">Total Payable</div>
                            <div style="font-size:0.75rem; color:#6b7280;">Including all taxes & charges</div>
                        </div>
                        <div style="font-size:1.3rem; color:#16a34a; font-weight:bold;">₹${totalPrice.toFixed(2)}</div>
                    </div>
                    <div style="margin-bottom:10px; font-weight:bold;">Select Payment Method</div>
                    <div style="display:flex; flex-direction:column; gap:10px; font-size:0.95rem;">
                        <label style="display:flex; align-items:center; gap:10px; padding:10px; border-radius:12px; border:1px solid #e5e7eb; background:${checkoutPaymentMethod === 'cod' ? '#ecfdf3' : '#ffffff'}; cursor:pointer;">
                            <input type="radio" name="payment-method" value="cod" ${checkoutPaymentMethod === 'cod' ? 'checked' : ''} />
                            <div>
                                <div>Cash on Delivery</div>
                                <div style="font-size:0.75rem; color:#6b7280;">Pay in cash when your food arrives</div>
                            </div>
                        </label>
                        <label style="display:flex; align-items:center; gap:10px; padding:10px; border-radius:12px; border:1px solid #e5e7eb; background:${checkoutPaymentMethod === 'upi' ? '#ecfeff' : '#ffffff'}; cursor:pointer;">
                            <input type="radio" name="payment-method" value="upi" ${checkoutPaymentMethod === 'upi' ? 'checked' : ''} />
                            <div>
                                <div>UPI Payment</div>
                                <div style="font-size:0.75rem; color:#6b7280;">Fast & secure payment via your UPI app</div>
                            </div>
                        </label>
                    </div>
                    <div id="upi-section" style="margin-top:10px; display:${checkoutPaymentMethod === 'upi' ? 'block' : 'none'};">
                        <label style="font-size:0.8rem; color:#6b7280;">UPI ID</label>
                        <input id="upi-id-input" type="text" value="${checkoutUpiId || ''}" placeholder="yourname@upi" style="width:100%; padding:8px 10px; border-radius:8px; border:1px solid #d1d5db; font-size:0.9rem;" />
                        <div style="margin-top:4px; font-size:0.8rem; color:#6b7280;">You will complete payment in your UPI app.</div>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button class="modal-btn secondary" onclick="renderCheckoutStep1()">Back</button>
                    <button class="modal-btn primary" onclick="handleOrderConfirm()">Confirm Order</button>
                </div>
            `;

            // Attach change handler for payment radio to toggle UPI section
            const radios = document.querySelectorAll('input[name="payment-method"]');
            radios.forEach(r => {
                r.addEventListener('change', () => {
                    checkoutPaymentMethod = r.value;
                    const upiSection = document.getElementById('upi-section');
                    if (upiSection) {
                        upiSection.style.display = checkoutPaymentMethod === 'upi' ? 'block' : 'none';
                    }
                });
            });
        }

        function handleOrderConfirm() {
            const radios = document.querySelectorAll('input[name="payment-method"]');
            let selected = '';
            radios.forEach(r => { if (r.checked) selected = r.value; });

            if (!selected) {
                showErrorPopup('Please select a payment method to continue.', 'Payment Required');
                return;
            }

            checkoutPaymentMethod = selected;
            if (checkoutPaymentMethod === 'upi') {
                const upiInput = document.getElementById('upi-id-input');
                const upiId = upiInput ? upiInput.value.trim() : '';
                if (!upiId) {
                    showErrorPopup('Please enter your UPI ID.', 'UPI ID Required');
                    return;
                }
                checkoutUpiId = upiId;
            }

            completeOrder();
        }

        function generateOrderCode(currentUser, address) {
            const nameRaw = (currentUser && currentUser.name) ? currentUser.name : '';
            const phoneRaw = (currentUser && currentUser.phone) ? currentUser.phone : '';
            const addrRaw = address || (currentUser && currentUser.address) || '';

            const namePart = nameRaw.replace(/[^A-Za-z0-9]/g, '').toUpperCase().slice(0, 2).padEnd(2, 'X');
            const phoneDigits = phoneRaw.replace(/\D/g, '');
            const phonePart = phoneDigits.slice(0, 2).padEnd(2, '0');
            const addrPart = addrRaw.replace(/[^A-Za-z0-9]/g, '').toUpperCase().slice(0, 2).padEnd(2, 'X');
            const numPart = String(Date.now()).slice(-4); // last 4 digits from timestamp

            return namePart + phonePart + addrPart + numPart;
        }

        function completeOrder() {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            if (!currentUser || Items.length === 0) return;

            const orderAddress = checkoutDeliveryAddress || (currentUser.address || '');
            const orderCode = generateOrderCode(currentUser, orderAddress);

            const order = {
                id: orderCode,
                date: new Date().toISOString().split('T')[0],
                items: Items.map(item => ({
                    name: item.name,
                    quantity: item.quantity,
                    price: item.price,
                    icon: item.icon || '🍽️'
                })),
                total: Items.reduce((sum, item) => sum + (item.price * item.quantity), 0),
                status: 'pending',
                address: orderAddress,
                pin: checkoutDeliveryPin,
                paymentMethod: checkoutPaymentMethod,
                upiId: checkoutPaymentMethod === 'upi' ? checkoutUpiId : null
            };

            const existingOrders = JSON.parse(localStorage.getItem(`orders_${currentUser.id}`) || '[]');
            existingOrders.push(order);
            localStorage.setItem(`orders_${currentUser.id}`, JSON.stringify(existingOrders));

            // Also send to backend to store in database (best-effort)
            try {
                const formData = new FormData();
                formData.append('user_id', currentUser.id);
                formData.append('order_code', order.id || '');
                formData.append('address', order.address || '');
                formData.append('pin', order.pin || '');
                formData.append('payment_method', order.paymentMethod || '');
                formData.append('upi_id', order.upiId || '');
                formData.append('total', order.total);
                formData.append('items', JSON.stringify(order.items));

                fetch('../backend/create_order.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if (!data || !data.success) {
                        console.warn('Order DB save failed:', data);
                    }
                })
                .catch(err => {
                    console.warn('Order DB save error:', err);
                });
            } catch (e) {
                console.warn('Order DB save exception:', e);
            }

            // Clear cart and update UI
            Items = [];
            saveCart();
            updateCartDisplay();
            if (currentActivePage === 'cart') {
                updateCartPage();
            }

            renderCheckoutSuccess(order);
            launchCheckoutConfetti();
        }

        let lastCompletedOrder = null;

        function renderCheckoutSuccess(order) {
            const flow = document.getElementById('checkout-flow');
            if (!flow) return;

            // Remember last completed order so other actions (like PDF download) can use it
            lastCompletedOrder = order;

            flow.innerHTML = `
                <div class="modal-header">
                    <div class="success-icon">🎉</div>
                    <h2>Order Confirmed!</h2>
                    <p style="color:#666;margin:0;">Thank you for your order.</p>
                </div>
                <div class="order-summary">
                    <div style="margin-bottom:10px; font-size:0.95rem;">
                        Order ID: <strong>${order.id}</strong><br>
                        Delivery to: <strong>${order.address}</strong> (PIN: ${order.pin})<br>
                        Payment: <strong>${order.paymentMethod === 'upi' ? 'UPI' : 'Cash on Delivery'}</strong>
                    </div>
                    <div class="order-item" style="border-top:1px solid #e5e7eb; margin-top:8px; padding-top:8px;">
                        <div class="item-details">
                            <div class="item-name">Total Amount</div>
                        </div>
                        <div class="item-price">₹${order.total.toFixed(2)}</div>
                    </div>
                </div>
                <div class="modal-buttons">
                    <button class="modal-btn secondary" onclick="downloadOrderBill()">Print / Download Bill</button>
                    <button class="modal-btn secondary" onclick="goToDashboardOrders()">Continue Shopping</button>
                    <button class="modal-btn primary" onclick="goToDashboardOrders()">Track Order</button>
                </div>
            `;
        }

        function downloadOrderBill() {
            try {
                const currentUser = JSON.parse(localStorage.getItem('currentUser')) || {};
                const order = lastCompletedOrder;
                if (!order) {
                    showErrorPopup('No order found to generate bill. Please place an order again.', 'No Order');
                    return;
                }
                const websiteName = 'AR Food Delivery';
                const now = new Date();
                const dateStr = now.toLocaleDateString();
                const timeStr = now.toLocaleTimeString();

                const itemsRows = (order.items || []).map(it => {
                    const qty = Number(it.quantity || 0);
                    const price = Number(it.price || 0);
                    const lineTotal = (price * qty).toFixed(2);
                    const icon = String(it.icon || '🍽️');
                    return `
                        <tr>
                            <td style="padding:10px 8px; border-bottom:1px solid #e5e7eb;">
                                <div style="display:flex; align-items:center; gap:10px;">
                                    <span style="width:34px; height:34px; border-radius:12px; display:inline-flex; align-items:center; justify-content:center; background: rgba(17,153,142,0.10); border: 1px solid rgba(17,153,142,0.18); font-size:18px;">${icon}</span>
                                    <div style="font-weight:800;">${String(it.name || '')}</div>
                                </div>
                            </td>
                            <td style="padding:10px 8px; border-bottom:1px solid #e5e7eb; text-align:right;">${qty}</td>
                            <td style="padding:10px 8px; border-bottom:1px solid #e5e7eb; text-align:right;">₹${lineTotal}</td>
                        </tr>
                    `;
                }).join('');

                const html = `
                    <!doctype html>
                    <html>
                    <head>
                        <meta charset="utf-8" />
                        <meta name="viewport" content="width=device-width, initial-scale=1" />
                        <title>Bill_${order.id}</title>
                        <style>
                            * { box-sizing: border-box; }
                            :root {
                                --brand-a: #11998e;
                                --brand-b: #38ef7d;
                                --ink: #0f172a;
                                --muted: #475569;
                                --line: #e5e7eb;
                                --paper: #ffffff;
                                --tint: rgba(17,153,142,0.10);
                            }
                            body {
                                margin: 0;
                                padding: 24px;
                                font-family: ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
                                color: var(--ink);
                                background: linear-gradient(180deg, rgba(17,153,142,0.04), rgba(56,239,125,0.02));
                            }
                            .wrap { max-width: 860px; margin: 0 auto; position: relative; }

                            .watermark {
                                position: absolute;
                                inset: 0;
                                pointer-events: none;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                opacity: 0.08;
                                transform: rotate(-18deg);
                                font-weight: 900;
                                letter-spacing: 8px;
                                font-size: 64px;
                                color: #0f172a;
                                user-select: none;
                            }

                            .top {
                                border-radius: 18px;
                                overflow: hidden;
                                border: 1px solid rgba(15,23,42,0.08);
                                box-shadow: 0 24px 60px rgba(2, 6, 23, 0.10);
                                background: var(--paper);
                            }
                            .head {
                                padding: 16px 18px;
                                background: linear-gradient(135deg, var(--brand-a), var(--brand-b));
                                color: white;
                                display:flex;
                                justify-content:space-between;
                                align-items:flex-start;
                                gap: 12px;
                            }
                            .brandrow { display:flex; gap: 12px; align-items:center; }
                            .logo {
                                width: 44px;
                                height: 44px;
                                border-radius: 14px;
                                background: rgba(255,255,255,0.22);
                                border: 1px solid rgba(255,255,255,0.35);
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                font-size: 22px;
                                font-weight: 900;
                            }
                            .brand { font-size: 18px; font-weight: 900; line-height: 1.1; }
                            .sub { font-size: 12px; opacity: 0.9; margin-top: 4px; }
                            .meta {
                                font-size: 12px;
                                text-align:right;
                                opacity: 0.95;
                                line-height: 1.35;
                            }
                            .content { padding: 16px 18px 18px 18px; position: relative; }

                            .card {
                                border: 1px solid var(--line);
                                border-radius: 16px;
                                padding: 14px;
                                margin-bottom: 14px;
                                background: white;
                            }
                            .grid { display:grid; grid-template-columns: 1fr 1fr; gap: 12px; }
                            .label { color: var(--muted); font-size: 11px; font-weight: 900; text-transform: uppercase; letter-spacing: .22px; }
                            .val { font-weight: 900; margin-top: 3px; }
                            .hint { color: var(--muted); font-size: 12px; margin-top: 2px; }

                            table { width:100%; border-collapse: collapse; font-size: 13.5px; }
                            thead th {
                                text-align:left;
                                padding:12px 10px;
                                background: rgba(17,153,142,0.08);
                                border-bottom:1px solid var(--line);
                                font-size: 11px;
                                text-transform: uppercase;
                                letter-spacing: .22px;
                                color: var(--muted);
                            }
                            tbody td { padding: 10px 10px; }

                            .total {
                                display:flex;
                                justify-content:space-between;
                                align-items:center;
                                gap: 10px;
                                font-weight: 900;
                                font-size: 15px;
                                padding: 12px 12px;
                                border-radius: 14px;
                                background: linear-gradient(135deg, rgba(17,153,142,0.10), rgba(56,239,125,0.08));
                                border: 1px solid rgba(17,153,142,0.18);
                            }

                            .footer {
                                text-align:center;
                                color: var(--muted);
                                font-size: 12px;
                                margin-top: 12px;
                            }

                            @media (max-width: 640px) {
                                body { padding: 12px; }
                                .grid { grid-template-columns: 1fr; }
                                .meta { text-align:left; }
                            }
                            @media print {
                                body { padding: 0; background: white; }
                                .wrap { max-width: none; }
                                .top { box-shadow: none; border: none; }
                                .watermark { opacity: 0.06; }
                            }
                        </style>
                    </head>
                    <body>
                        <div class="wrap">
                            <div class="watermark">AR FOOD</div>
                            <div class="top">
                                <div class="head">
                                    <div class="brandrow">
                                        <div class="logo">🍽️</div>
                                        <div>
                                            <div class="brand">${websiteName}</div>
                                            <div class="sub">Official Order Bill • Premium Receipt</div>
                                        </div>
                                    </div>
                                    <div class="meta">
                                        <div><strong>Order:</strong> ${order.id}</div>
                                        <div><strong>Date:</strong> ${dateStr} ${timeStr}</div>
                                    </div>
                                </div>

                                <div class="content">
                                    <div class="card">
                                        <div class="grid">
                                            <div>
                                                <div class="label">Customer</div>
                                                <div class="val">${currentUser.name || ''}</div>
                                                <div class="hint">${currentUser.phone || ''}</div>
                                            </div>
                                            <div>
                                                <div class="label">Delivery</div>
                                                <div class="val">${order.address || ''}</div>
                                                <div class="hint">PIN: ${order.pin || ''}</div>
                                            </div>
                                            <div>
                                                <div class="label">Payment</div>
                                                <div class="val">${order.paymentMethod === 'upi' ? 'UPI' : 'Cash on Delivery'}</div>
                                            </div>
                                            <div>
                                                <div class="label">Status</div>
                                                <div class="val">Pending</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="card">
                                        <table>
                                            <thead>
                                                <tr><th>Item</th><th style="text-align:right;">Qty</th><th style="text-align:right;">Amount</th></tr>
                                            </thead>
                                            <tbody>
                                                ${itemsRows}
                                            </tbody>
                                        </table>
                                        <div style="margin-top:12px;" class="total">
                                            <span>Total Payable</span>
                                            <span>₹${Number(order.total || 0).toFixed(2)}</span>
                                        </div>
                                    </div>

                                    <div class="footer">
                                        Tip: Use your browser print dialog to “Save as PDF”.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </body>
                    </html>
                `;

                const w = window.open('', '_blank');
                if (!w) {
                    showErrorPopup('Popup blocked. Please allow popups to print/download bill.', 'Popup Blocked');
                    return;
                }
                w.document.open();
                w.document.write(html);
                w.document.close();
                w.focus();
                setTimeout(() => {
                    w.print();
                }, 400);
            } catch (e) {
                console.error('PDF generation error', e);
                showErrorPopup('Could not generate bill. Please try again.', 'Download Failed');
            }
        }

        function showCheckoutModal() {
            const modal = document.getElementById('checkout-modal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeCheckoutModal() {
            const modal = document.getElementById('checkout-modal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        function goToDashboardOrders() {
            closeCheckoutModal();
            window.location.href = 'user-dashboard.php#orders';
        }

        // Welcome Modal Functions
        function showWelcomeModal() {
            const modal = document.getElementById('welcome-modal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeWelcomeModal() {
            const modal = document.getElementById('welcome-modal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
        }

        // Modern Welcome Popup Functions
        let welcomePopupTimer;
        
        function showWelcomePopup() {
            const popup = document.getElementById('welcome-popup-overlay');
            popup.classList.add('show');
            document.body.style.overflow = 'hidden';
            
            // Auto-close after 8 seconds
            welcomePopupTimer = setTimeout(() => {
                closeWelcomePopup();
            }, 8000);
        }

        function closeWelcomePopup() {
            const popup = document.getElementById('welcome-popup-overlay');
            popup.classList.remove('show');
            document.body.style.overflow = 'auto';
            
            // Clear the auto-close timer
            if (welcomePopupTimer) {
                clearTimeout(welcomePopupTimer);
                welcomePopupTimer = null;
            }
        }

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const checkoutModal = document.getElementById('checkout-modal');
            const welcomeModal = document.getElementById('welcome-modal');
            const welcomePopup = document.getElementById('welcome-popup-overlay');
            
            if (event.target === checkoutModal) {
                closeCheckoutModal();
            }
            if (event.target === welcomeModal) {
                closeWelcomeModal();
            }
            if (event.target === welcomePopup) {
                closeWelcomePopup();
            }
        });

        function launchCheckoutConfetti() {
            const container = document.getElementById('checkout-confetti-container') || document.body;
            if (!container) return;
            container.innerHTML = '';
            const colors = ['#f97316','#22c55e','#3b82f6','#eab308','#ec4899'];
            for (let i = 0; i < 80; i++) {
                const piece = document.createElement('div');
                piece.className = 'confetti-piece';
                piece.style.left = Math.random() * 100 + '%';
                piece.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                piece.style.animationDelay = (Math.random() * 1) + 's';
                piece.style.animationDuration = (2 + Math.random() * 1.5) + 's';
                container.appendChild(piece);
                setTimeout(() => piece.remove(), 4000);
            }
        }

        function updateCartDisplay() {
            const cartElement = document.getElementById('cart-items');
            cartElement.innerHTML = '';
            let total = 0;

            if (Items.length === 0) {
                cartElement.innerHTML = '<li style="text-align: center; color: #999; padding: 20px;">Cart is empty</li>';
            }

            Items.forEach((item, index) => {
                total += item.price * item.quantity;
                const li = document.createElement('li');
                li.className = 'cart-item';
                li.innerHTML = `
                    <div class="cart-item-info">
                        <span class="cart-item-icon">${item.icon || '🍽️'}</span>
                        <div class="cart-item-name">${item.name}<br><small>₹${item.price}</small></div>
                    </div>
                    <div class="quantity">
                        <button onclick="updateQuantity(${index}, ${item.quantity - 1})">-</button>
                        <input type="number" value="${item.quantity}" min="1" max="99"
                            onchange="updateQuantity(${index}, this.value)">
                        <button onclick="updateQuantity(${index}, ${item.quantity + 1})">+</button>
                    </div>
                    <button class="delete-btn" onclick="deleteFromCart(${index})">🗑️</button>
                `;
                cartElement.appendChild(li);
            });

            document.getElementById('total-price').textContent = `Total: ₹${total.toFixed(2)}`;
            
            // Also update cart page if it exists
            if (currentActivePage === 'cart') {
                updateCartPage();
            }
        }

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
            messageEl.textContent = options.message || '';
            
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

        // Close popup when clicking outside
        document.addEventListener('click', function(event) {
            const overlay = document.getElementById('custom-popup-overlay');
            if (event.target === overlay) {
                closeCustomPopup();
            }
        });

        // Product Detail Modal Functions
        let currentDetailProduct = null;

        function showProductDetail(productName) {
            const product = products.find(p => p.name === productName);
            if (!product) {
                showErrorPopup('Product not found!', 'Error');
                return;
            }

            currentDetailProduct = product;
            populateProductDetail(product);
            
            const modal = document.getElementById('product-detail-modal');
            modal.classList.add('show');
            document.body.style.overflow = 'hidden';
        }

        function closeProductDetail() {
            const modal = document.getElementById('product-detail-modal');
            modal.classList.remove('show');
            document.body.style.overflow = 'auto';
            currentDetailProduct = null;
        }

        function populateProductDetail(product) {
            // Set basic info
            document.getElementById('product-icon-large').textContent = product.icon;
            document.getElementById('product-title-large').textContent = product.name;
            document.getElementById('product-price-large').textContent = `₹${product.price}`;
            
            // Set description (fallback if not available)
            const description = product.description || `Delicious ${product.name} prepared with fresh ingredients and authentic flavors. A perfect choice for food lovers!`;
            document.getElementById('product-description').textContent = description;
            
            // Set tags
            const tagsContainer = document.getElementById('product-tags-container');
            if (product.tags && product.tags.length > 0) {
                tagsContainer.innerHTML = product.tags.map(tag => 
                    `<span class="product-tag">${tag}</span>`
                ).join('');
            } else {
                tagsContainer.innerHTML = `<span class="product-tag">Delicious</span><span class="product-tag">Fresh</span>`;
            }
            
            // Set nutrition info
            populateNutritionInfo(product);
            
            // Set spice level
            populateSpiceLevel(product);
            
            // Set ingredients
            populateIngredients(product);
            
            // Set allergens
            populateAllergens(product);
            
            // Set preparation time
            const prepTime = product.preparationTime || '15-20 minutes';
            document.getElementById('preparation-time').textContent = prepTime;
            
            // Update favorite button state
            updateDetailFavoriteButton(product);
        }

        function populateNutritionInfo(product) {
            const nutritionGrid = document.getElementById('nutrition-grid');
            
            // Default nutrition values if not provided
            const nutrition = {
                calories: product.calories || getDefaultCalories(product.category),
                protein: product.protein || getDefaultProtein(product.category),
                carbs: product.carbs || getDefaultCarbs(product.category),
                fat: product.fat || getDefaultFat(product.category),
                sugar: product.sugar || getDefaultSugar(product.category),
                fiber: product.fiber || getDefaultFiber(product.category),
                sodium: product.sodium || getDefaultSodium(product.category),
                weight: product.weight || getDefaultWeight(product.category)
            };
            
            nutritionGrid.innerHTML = `
                <div class="nutrition-card">
                    <h4>Calories</h4>
                    <div class="nutrition-value">${nutrition.calories}</div>
                </div>
                <div class="nutrition-card">
                    <h4>Protein</h4>
                    <div class="nutrition-value">${nutrition.protein}</div>
                </div>
                <div class="nutrition-card">
                    <h4>Carbs</h4>
                    <div class="nutrition-value">${nutrition.carbs}</div>
                </div>
                <div class="nutrition-card">
                    <h4>Fat</h4>
                    <div class="nutrition-value">${nutrition.fat}</div>
                </div>
                <div class="nutrition-card">
                    <h4>Sugar</h4>
                    <div class="nutrition-value">${nutrition.sugar}</div>
                </div>
                <div class="nutrition-card">
                    <h4>Fiber</h4>
                    <div class="nutrition-value">${nutrition.fiber}</div>
                </div>
                <div class="nutrition-card">
                    <h4>Sodium</h4>
                    <div class="nutrition-value">${nutrition.sodium}</div>
                </div>
                <div class="nutrition-card">
                    <h4>Weight</h4>
                    <div class="nutrition-value">${nutrition.weight}</div>
                </div>
            `;
        }

        function populateSpiceLevel(product) {
            const spiceLevel = product.spiceLevel || 'Mild';
            const spiceLevels = ['Mild', 'Medium', 'Medium-Hot', 'Hot', 'Very Hot'];
            const currentLevel = spiceLevels.indexOf(spiceLevel);
            
            document.getElementById('spice-level-text').textContent = spiceLevel;
            
            const indicators = document.getElementById('spice-indicators');
            indicators.innerHTML = '';
            
            for (let i = 0; i < 5; i++) {
                const dot = document.createElement('div');
                dot.className = `spice-dot ${i <= currentLevel ? 'active' : ''}`;
                indicators.appendChild(dot);
            }
        }

        function populateIngredients(product) {
            const ingredientsList = document.getElementById('ingredients-list');
            const ingredients = product.ingredients || getDefaultIngredients(product.name, product.category);
            
            ingredientsList.innerHTML = ingredients.map(ingredient => 
                `<span class="ingredient-tag">${ingredient}</span>`
            ).join('');
        }

        function populateAllergens(product) {
            const allergensList = document.getElementById('allergens-list');
            const allergens = product.allergens || getDefaultAllergens(product.category);
            
            if (allergens.length > 0) {
                allergensList.innerHTML = allergens.map(allergen => 
                    `<span class="allergen-tag">${allergen}</span>`
                ).join('');
            } else {
                allergensList.innerHTML = '<span style="color: #28a745; font-weight: bold;">No known allergens</span>';
            }
        }

        function updateDetailFavoriteButton(product) {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            const favoriteBtn = document.getElementById('favorite-detail-btn');
            
            if (!currentUser) {
                favoriteBtn.innerHTML = '❤️';
                return;
            }
            
            const favoriteKey = `favorites_${currentUser.id}`;
            const favorites = JSON.parse(localStorage.getItem(favoriteKey) || '[]');
            const isFavorited = favorites.some(fav => fav.name === product.name);
            
            favoriteBtn.innerHTML = isFavorited ? '💖' : '❤️';
        }

        function addToCartFromDetail() {
            if (currentDetailProduct) {
                addToCart(currentDetailProduct.name, currentDetailProduct.price, currentDetailProduct.icon);
                showSuccessPopup(`${currentDetailProduct.name} added to cart! 🛒`, 'Added to Cart');
            }
        }

        function toggleFavoriteFromDetail() {
            if (currentDetailProduct) {
                toggleFavorite(currentDetailProduct.name, currentDetailProduct.price, currentDetailProduct.icon, currentDetailProduct.category);
                // Update the detail favorite button
                setTimeout(() => {
                    updateDetailFavoriteButton(currentDetailProduct);
                }, 100);
            }
        }

        // Default nutrition value functions
        function getDefaultCalories(category) {
            const defaults = {
                'non-veg': 450,
                'veg': 320,
                'dessert': 280,
                'beverage': 120
            };
            return defaults[category] || 350;
        }

        function getDefaultProtein(category) {
            const defaults = {
                'non-veg': '25g',
                'veg': '12g',
                'dessert': '6g',
                'beverage': '3g'
            };
            return defaults[category] || '15g';
        }

        function getDefaultCarbs(category) {
            const defaults = {
                'non-veg': '35g',
                'veg': '45g',
                'dessert': '40g',
                'beverage': '25g'
            };
            return defaults[category] || '40g';
        }

        function getDefaultFat(category) {
            const defaults = {
                'non-veg': '18g',
                'veg': '8g',
                'dessert': '12g',
                'beverage': '2g'
            };
            return defaults[category] || '12g';
        }

        function getDefaultSugar(category) {
            const defaults = {
                'non-veg': '4g',
                'veg': '6g',
                'dessert': '25g',
                'beverage': '18g'
            };
            return defaults[category] || '8g';
        }

        function getDefaultFiber(category) {
            const defaults = {
                'non-veg': '3g',
                'veg': '8g',
                'dessert': '2g',
                'beverage': '1g'
            };
            return defaults[category] || '4g';
        }

        function getDefaultSodium(category) {
            const defaults = {
                'non-veg': '850mg',
                'veg': '520mg',
                'dessert': '180mg',
                'beverage': '45mg'
            };
            return defaults[category] || '600mg';
        }

        function getDefaultWeight(category) {
            const defaults = {
                'non-veg': '280g',
                'veg': '220g',
                'dessert': '150g',
                'beverage': '300ml'
            };
            return defaults[category] || '250g';
        }

        function getDefaultIngredients(name, category) {
            // Generate realistic ingredients based on product name and category
            const commonIngredients = {
                'non-veg': ['Chicken', 'Spices', 'Onions', 'Garlic', 'Oil'],
                'veg': ['Vegetables', 'Spices', 'Onions', 'Tomatoes', 'Oil'],
                'dessert': ['Sugar', 'Milk', 'Flour', 'Butter', 'Vanilla'],
                'beverage': ['Water', 'Natural flavors', 'Sugar', 'Preservatives']
            };
            
            // Add specific ingredients based on product name
            let ingredients = [...commonIngredients[category] || []];
            
            if (name.includes('Burger')) ingredients.unshift('Bun', 'Lettuce', 'Tomato');
            if (name.includes('Pizza')) ingredients.unshift('Dough', 'Cheese', 'Tomato sauce');
            if (name.includes('Biryani')) ingredients.unshift('Basmati rice', 'Saffron', 'Yogurt');
            if (name.includes('Curry')) ingredients.unshift('Curry leaves', 'Coconut', 'Ginger');
            
            return ingredients.slice(0, 6); // Limit to 6 ingredients
        }

        function getDefaultAllergens(category) {
            const commonAllergens = {
                'non-veg': ['Dairy'],
                'veg': ['Dairy', 'Nuts'],
                'dessert': ['Dairy', 'Gluten', 'Eggs'],
                'beverage': []
            };
            return commonAllergens[category] || [];
        }

        // Close product detail when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('product-detail-modal');
            if (event.target === modal) {
                closeProductDetail();
            }
        });

        // Authentication-based UI Management
        function updateAuthUI() {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            const authRequiredElements = document.querySelectorAll('.auth-required');
            const loginRequiredButtons = document.querySelectorAll('.login-required-btn');
            
            if (currentUser) {
                // User is logged in - show auth-required elements
                authRequiredElements.forEach(element => {
                    element.classList.add('user-logged-in');
                    if (element.style.display === 'flex') {
                        element.classList.add('flex');
                    }
                    if (element.style.display === 'inline-block') {
                        element.classList.add('inline-block');
                    }
                });
                
                // Hide login-required buttons
                loginRequiredButtons.forEach(button => {
                    button.style.display = 'none';
                });
            } else {
                // User is not logged in - hide auth-required elements
                authRequiredElements.forEach(element => {
                    element.classList.remove('user-logged-in', 'flex', 'inline-block');
                });
                
                // Show login-required buttons
                loginRequiredButtons.forEach(button => {
                    button.style.display = 'block';
                });
            }
        }

        // Login Prompt Modal Functions
        function showLoginPrompt() {
            const overlay = document.getElementById('login-prompt-overlay');
            overlay.style.display = 'flex';
            document.body.style.overflow = 'hidden';
        }

        function closeLoginPrompt() {
            const overlay = document.getElementById('login-prompt-overlay');
            overlay.style.display = 'none';
            document.body.style.overflow = 'auto';
        }

        function goToLogin() {
            window.location.href = 'login.php';
        }

        // Close login prompt when clicking outside
        document.addEventListener('click', function(event) {
            const overlay = document.getElementById('login-prompt-overlay');
            if (event.target === overlay) {
                closeLoginPrompt();
            }
        });

        // Initialize auth UI on page load
        document.addEventListener('DOMContentLoaded', function() {
            updateAuthUI();
        });

        // Update auth UI when storage changes (for login/logout from other tabs)
        window.addEventListener('storage', function(e) {
            if (e.key === 'currentUser') {
                updateAuthUI();
            }
        });

        // Favorites functionality
        function toggleFavorite(name, price, icon, category) {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            if (!currentUser) {
                showErrorPopup('Please login to add favorites! 🔐', 'Login Required');
                return;
            }

            const favoriteKey = `favorites_${currentUser.id}`;
            let favorites = JSON.parse(localStorage.getItem(favoriteKey) || '[]');
            
            const existingIndex = favorites.findIndex(fav => fav.name === name);
            const favoriteBtn = document.getElementById(`fav-${name.replace(/\s+/g, '-')}`);
            
            if (existingIndex !== -1) {
                // Remove from favorites
                favorites.splice(existingIndex, 1);
                favoriteBtn.classList.remove('favorited');
                favoriteBtn.innerHTML = '🤍';
                showFavoriteNotification(`${name} removed from favorites! 💔`, 'removed');
            } else {
                // Add to favorites
                favorites.push({ name, price, icon, category, addedAt: new Date().toISOString() });
                favoriteBtn.classList.add('favorited');
                favoriteBtn.innerHTML = '❤️';
                showFavoriteNotification(`${name} added to favorites! 💖`, 'added');
            }
            
            localStorage.setItem(favoriteKey, JSON.stringify(favorites));
            updateFavoriteStates();
        }

        function updateFavoriteStates() {
            const currentUser = JSON.parse(localStorage.getItem('currentUser'));
            if (!currentUser) return;

            const favoriteKey = `favorites_${currentUser.id}`;
            const favorites = JSON.parse(localStorage.getItem(favoriteKey) || '[]');
            
            // Update all favorite buttons on the page
            favorites.forEach(fav => {
                const favoriteBtn = document.getElementById(`fav-${fav.name.replace(/\s+/g, '-')}`);
                if (favoriteBtn) {
                    favoriteBtn.classList.add('favorited');
                    favoriteBtn.innerHTML = '❤️';
                }
            });
        }

        function showFavoriteNotification(message, type) {
            // Create notification element
            const notification = document.createElement('div');
            notification.style.cssText = `
                position: fixed;
                top: 100px;
                right: 20px;
                background: ${type === 'added' ? '#4caf50' : '#ff5722'};
                color: white;
                padding: 15px 20px;
                border-radius: 10px;
                box-shadow: 0 4px 12px rgba(0,0,0,0.3);
                z-index: 10000;
                font-weight: bold;
                animation: slideInRight 0.3s ease-out;
            `;
            notification.textContent = message;
            
            // Add animation styles
            const style = document.createElement('style');
            style.textContent = `
                @keyframes slideInRight {
                    from { transform: translateX(100%); opacity: 0; }
                    to { transform: translateX(0); opacity: 1; }
                }
            `;
            document.head.appendChild(style);
            
            document.body.appendChild(notification);
            
            // Remove notification after 3 seconds
            setTimeout(() => {
                notification.style.animation = 'slideInRight 0.3s ease-out reverse';
                setTimeout(() => {
                    document.body.removeChild(notification);
                    document.head.removeChild(style);
                }, 300);
            }, 3000);
        }

        // Authentication functions
        function getFirstNameDisplay(fullName) {
            if (!fullName || typeof fullName !== 'string') return 'Profile';
            const parts = fullName.trim().split(/\s+/);
            if (parts.length === 0) return 'Profile';
            const first = parts[0];
            const display = first.length > 6 ? first.slice(0, 6) : first;
            return display || 'Profile';
        }
        function checkAuthStatus() {
            const currentUser = JSON.parse(localStorage.getItem('currentUser') || 'null');
            const loginButton = document.getElementById('login-button');
            const profileButton = document.getElementById('profile-button');
            const headerAvatar = document.getElementById('header-avatar');
            
            if (currentUser) {
                // User is logged in - show profile button
                loginButton.style.display = 'none';
                profileButton.style.display = 'flex';
                
                // Update user info in profile
                document.getElementById('user-display-name').textContent = getFirstNameDisplay(currentUser.name);
                document.getElementById('dropdown-user-name').textContent = currentUser.name;
                document.getElementById('dropdown-user-email').textContent = currentUser.email;

                // Update header avatar if available
                if (headerAvatar) {
                    if (currentUser.avatar) {
                        headerAvatar.style.backgroundImage = `url(${currentUser.avatar})`;
                        profileButton.classList.add('has-avatar');
                    } else {
                        headerAvatar.style.backgroundImage = '';
                        profileButton.classList.remove('has-avatar');
                    }
                }
                
                // Check if this is a fresh login and show welcome popup
                const showWelcome = localStorage.getItem('showWelcomePopup');
                if (showWelcome === 'true') {
                    localStorage.removeItem('showWelcomePopup'); // Remove flag
                    setTimeout(() => {
                        showWelcomePopup();
                    }, 500); // Small delay for smooth transition
                }
            } else {
                // User is not logged in - show login button
                loginButton.style.display = 'flex';
                profileButton.style.display = 'none';
            }
            
            // Update authentication-based UI
            updateAuthUI();
        }

        function toggleProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            const backdrop = document.getElementById('dropdown-backdrop');
            
            if (dropdown.classList.contains('show')) {
                closeProfileDropdown();
            } else {
                dropdown.classList.add('show');
                backdrop.classList.add('show');
            }
        }

        function closeProfileDropdown() {
            const dropdown = document.getElementById('profile-dropdown');
            const backdrop = document.getElementById('dropdown-backdrop');
            dropdown.classList.remove('show');
            backdrop.classList.remove('show');
        }

        function goToDashboard() {
            // Close dropdown
            closeProfileDropdown();
            
            // Navigate to dashboard
            window.location.href = 'user-dashboard.php';
        }

        function logout() {
            showConfirmPopup({
                icon: '🚪',
                title: 'Logout Confirmation',
                message: 'Are you sure you want to logout?',
                confirmText: 'Yes, Logout',
                confirmType: 'danger',
                cancelText: 'Cancel',
                onConfirm: () => {
                    localStorage.removeItem('currentUser');
                    checkAuthStatus();
                    closeProfileDropdown();
                    showSuccessPopup('You have been logged out successfully! 👋', 'Logged Out');
                    showPage('home');
                }
            });
        }

        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            const profileButton = document.getElementById('profile-button');
            const dropdown = document.getElementById('profile-dropdown');
            
            if (!profileButton.contains(event.target) && !dropdown.contains(event.target)) {
                closeProfileDropdown();
            }
        });

        window.onload = function() {
            loadCart();
            // initialize filtered list and render first page
            currentFilteredList = products.slice();
            renderProducts(currentFilteredList);
            
            // Restore the last active page or default to home
            const savedPage = localStorage.getItem('currentPage') || 'home';
            showPage(savedPage);
            
            // Check authentication status
            checkAuthStatus();
            
            // Update favorite states after products are rendered
            setTimeout(() => {
                updateFavoriteStates();
            }, 100);
            
            // Show welcome modal after a short delay, but only on home page
            setTimeout(() => {
                const currentPage = localStorage.getItem('currentPage') || 'home';
                if (currentPage === 'home') {
                    showWelcomeModal();
                }
            }, 500);
        };
    </script>
</body>
</html>
