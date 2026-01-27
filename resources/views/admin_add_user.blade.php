<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add User</title>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: "Segoe UI", Arial, sans-serif;
            background: linear-gradient(135deg, #e3f2fd, #f1f8ff);
            margin: 0;
            min-height: 100vh;
        }

        /* Back button */
        .back-btn {
            position: absolute;
            top: 20px;
            left: 20px;
            text-decoration: none;
            color: #333;
            font-size: 18px;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .back-btn i {
            font-size: 26px;
            margin-right: 6px;
        }

        /* Card box */
        .box {
            max-width: 430px;
            margin: 100px auto;
            padding: 30px;
            background: #fff;
            border-radius: 14px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        /* Input wrapper */
        .field {
            position: relative;
            margin-bottom: 15px;
        }

        .field i {
            position: absolute;
            top: 50%;
            left: 12px;
            transform: translateY(-50%);
            color: #777;
            font-size: 18px;
        }

        input, select {
            width: 100%;
            padding: 12px 12px 12px 38px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 14px;
            transition: border 0.2s, box-shadow 0.2s;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #4CAF50;
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.15);
        }

        /* Button */
        button {
            width: 100%;
            padding: 13px;
            background: linear-gradient(135deg, #4CAF50, #43a047);
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 15px;
            cursor: pointer;
            margin-top: 10px;
            font-weight: 600;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        button:hover {
            opacity: 0.95;
        }

        /* Success message */
        .success {
            color: #2e7d32;
            background: #e8f5e9;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
            text-align: center;
            font-weight: 600;
        }

        /* Error message */
        .error {
            background: #ffebee;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 15px;
        }

        .error li {
            color: #c62828;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- Back Button -->
<a href="/admin/home" class="back-btn">
    <i class='bx bx-arrow-back'></i> Back
</a>

<div class="box">

    <h2>Add New User</h2>

    {{-- Success --}}
    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Errors --}}
    @if($errors->any())
        <div class="error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="/admin/add-user" autocomplete="off">
        @csrf

        <div class="field">
            <i class='bx bx-user'></i>
            <input type="text" name="name" placeholder="Full Name" required>
        </div>

        <div class="field">
            <i class='bx bx-envelope'></i>
            <input type="email" name="email" placeholder="Email Address" required>
        </div>

        <div class="field">
            <i class='bx bx-lock'></i>
            <input type="password" name="password" placeholder="Password" required>
        </div>

        <!-- Role -->
        <div class="field">
            <i class='bx bx-user-pin'></i>
            <select name="role" id="roleSelect" required>
                <option value="">Select Role</option>
                <option value="staff">Staff</option>
                <option value="appraiser">Appraiser</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <!-- Position (ONLY for Staff) -->
        <div class="field" id="positionField" style="display:none;">
            <i class='bx bx-briefcase'></i>
            <select name="position">
                <option value="">Select Position</option>
                <option value="Lecturer">Lecturer</option>
                <option value="Senior Lecturer">Senior Lecturer</option>
                <option value="Associate Professor">Associate Professor</option>
                <option value="Professor">Professor</option>
            </select>
        </div>

        <button type="submit">
            <i class='bx bx-save'></i> Save User
        </button>
    </form>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const roleSelect = document.getElementById('roleSelect');
    const positionField = document.getElementById('positionField');

    roleSelect.addEventListener('change', function () {
        if (this.value === 'staff') {
            positionField.style.display = 'block';
        } else {
            positionField.style.display = 'none';
            positionField.querySelector('select').value = '';
        }
    });
});
</script>

</body>
</html>
