<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Staff Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 600px;
            max-width: 95%;
            position: relative;
            
        }

        .back-btn {
            position: absolute;
            top: -55px;
            left: 0;
            text-decoration: none;
            color: white;
            font-size: 20px;
            display: flex;
            align-items: center;
            gap: 6px;
            opacity: 0.9;
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
            text-align: center;
        }

        .card h2 {
            color: #4f46e5;
            margin-bottom: 5px;
            font-weight: 700;
        }

        .subtitle {
            font-size: 14px;
            color: #666;
            margin-bottom: 25px;
        }

        .field {
            position: relative;
            margin-bottom: 15px;
        }

        .field input {
            width: 100%;
            padding: 12px 40px 12px 14px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            appearance: none;
        }

        .field input:focus {
            outline: none;
            border-color: #4f46e5;
        }

        .field i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #777;
            cursor: pointer;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: linear-gradient(135deg, #4f46e5, #6366f1);
            color: white;
            border: none;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        .error {
            background: #fde2e2;
            color: #b91c1c;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
        }

        .footer-text {
            margin-top: 20px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <a href="/" class="back-btn">
        <i class='bx bx-arrow-back'></i> Back
    </a>

    <div class="card">
        <h2>Staff Login</h2>
        <div class="subtitle">Login to access your KPI dashboard</div>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <!-- 🔥 AUTOFILL FIX APPLIED HERE -->
        <form action="/login" method="post" autocomplete="off">
            @csrf

            <!-- Dummy fields to trap browser autofill -->
            <input type="text" style="display:none">
            <input type="password" style="display:none">

            <div class="field">
                <input 
                    type="email"
                    name="email"
                    placeholder="Email address"
                    autocomplete="new-email"
                    required
                >
                <i class='bx bx-show'></i>
            </div>

            <div class="field">
                <input 
                    type="password"
                    name="password"
                    placeholder="Password"
                    autocomplete="new-password"
                    required
                >
                <i class='bx bx-show' onclick="toggleVisibility('password', this)"></i>
            </div>

            <input type="hidden" name="role" value="staff">

            <button type="submit">Login</button>
        </form>

        <div class="footer-text">
            KPI Appraisal System © 2026
        </div>
    </div>
</div>



<script>
function toggleVisibility(inputId, icon) {
    const input = document.getElementById(inputId);
    if (input.type === "password") {
        input.type = "text";
        icon.classList.replace("bx-show", "bx-hide");
    } else {
        input.type = "password";
        icon.classList.replace("bx-hide", "bx-show");
    }
}
</script>

</body>
</html>
