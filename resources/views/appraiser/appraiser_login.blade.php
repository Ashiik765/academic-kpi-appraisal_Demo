<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appraiser Login</title>

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
            background: linear-gradient(135deg, #f3c37a, #d97706); /* softer yellow */
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
            opacity: 0.9;
        }

        .back-btn:hover {
            opacity: 1;
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
            color: #d97706;
            font-weight: 700;
        }

        .subtitle {
            font-size: 14px;
            color: #777;
            margin-bottom: 25px;
        }

        /* Input wrapper */
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
            border-color: #d97706;
            box-shadow: 0 0 0 3px rgba(217, 119, 6, 0.15);
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
            background: linear-gradient(135deg, #d97706, #f59e0b);
            color: white;
            border: none;
            font-weight: bold;
            border-radius: 8px;
            cursor: pointer;
            font-size: 15px;
            transition: 0.3s;
        }

        button:hover {
            opacity: 0.95;
        }

        .error {
            background: #fde2e2;
            color: #b91c1c;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 8px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<div class="login-wrapper">

    <!-- Back to Welcome -->
    <a href="/" class="back-btn">
        <i class='bx bx-arrow-back'></i> Back
    </a>

    <div class="card">
        <h2>Appraiser Login</h2>
        <div class="subtitle">Access appraisal dashboard</div>

        @if(session('error'))
            <div class="error">{{ session('error') }}</div>
        @endif

        <!-- 🔒 AUTOFILL FIX APPLIED -->
        <form action="/login" method="post" autocomplete="off">
            @csrf

            <!-- Dummy inputs to block browser autofill -->
            <input type="text" style="display:none">
            <input type="password" style="display:none">

            <!-- Email -->
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
                <i class='bx bx-show' onclick="toggleVisibility('password', this)"></i>
            </div>

            <input type="hidden" name="role" value="appraiser">

            <button type="submit">Login</button>
        </form>
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
