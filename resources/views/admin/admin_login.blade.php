<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background: linear-gradient(135deg, #2ecc71, #27ae60);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-wrapper {
            width: 500px;
            max-width: 90%;
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
        }

        .card {
            background: white;
            padding: 40px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.25);
            text-align: center;
        }

        h2 {
            margin-bottom: 8px;
            color: #27ae60;
            font-weight: 700;
        }

        .subtitle {
            font-size: 14px;
            color: #777;
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
        }

        .field input:focus {
            outline: none;
            border-color: #27ae60;
            box-shadow: 0 0 0 3px rgba(39, 174, 96, 0.15);
        }

        .field i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 20px;
            color: #999;
            cursor: pointer;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 15px;
            background: linear-gradient(135deg, #27ae60, #2ecc71);
            color: white;
            border: none;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
        }

        .register-link {
            display: block;
            margin-top: 15px;
            text-decoration: none;
            color: white;
            background: linear-gradient(135deg, #16a085, #1abc9c);
            padding: 12px;
            border-radius: 8px;
            font-weight: bold;
        }

        .error {
            background: #f8d7da;
            color: #721c24;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <a href="/" class="back-btn">
        <i class='bx bx-arrow-back'></i> Back
    </a>

    <div class="card">
        <h2>Admin Login</h2>
        <div class="subtitle">Administrator access panel</div>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <!-- 🔐 Disable browser autofill -->
        <form action="/login" method="post" autocomplete="off">
            @csrf

            <!-- Dummy fields to block autofill -->
            <input type="text" name="fakeusernameremembered" style="display:none">
            <input type="password" name="fakepasswordremembered" style="display:none">

            <!-- Email -->
            <div class="field">
                <input 
                    type="email"
                    name="email"
                    placeholder="Email address"
                    autocomplete="email"
                    required
                >
            </div>

            <!-- Password -->
            <div class="field">
                <input 
                    type="password"
                    id="password"
                    name="password"
                    placeholder="Password"
                    autocomplete="new-password"
                    required
                >
                <i class='bx bx-show' onclick="togglePassword(this)"></i>
            </div>

            <input type="hidden" name="role" value="admin">

            <button type="submit">Login</button>
        </form>

        <a href="/admin/register" class="register-link">Register as Admin</a>
    </div>
</div>

<script>
    function togglePassword(icon) {
        const input = document.getElementById("password");

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
