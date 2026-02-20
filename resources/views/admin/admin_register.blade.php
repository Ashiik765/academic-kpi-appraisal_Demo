<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Register</title>

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

        .register-wrapper {
            width: 380px;
            max-width: 90%;
            position: relative;
        }

        /* Back Arrow */
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
            margin-bottom: 20px;
            color: #27ae60;
            font-weight: 700;
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

        .success {
            background: #d4edda;
            color: #155724;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
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

<div class="register-wrapper">

    <!-- Back to Admin Login -->
    <a href="/admin/login" class="back-btn">
        <i class='bx bx-arrow-back'></i> Back
    </a>

    <div class="card">
        <h2>Register as Admin</h2>

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <!-- 🔐 Autofill disabled -->
        <form action="/admin/register" method="post" autocomplete="off">
            @csrf

            <!-- Dummy inputs to block browser autofill -->
            <input type="text" style="display:none">
            <input type="password" style="display:none">

            <div class="field">
                <input
                    type="text"
                    name="name"
                    placeholder="Full Name"
                    autocomplete="off"
                    required
                >
            </div>

            <div class="field">
                <input
                    type="email"
                    name="email"
                    placeholder="Email Address"
                    autocomplete="email"
                    required
                >
            </div>

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

            <button type="submit">Register</button>
        </form>
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
