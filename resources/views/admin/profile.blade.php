<!DOCTYPE html>
<html>
<head>
    <title>Profile</title>

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body{
            font-family: 'Roboto', sans-serif;
            background:#f4f6f9;
            margin:0;
        }

        .profile-wrapper {
            max-width: 1100px;
            margin: 40px auto;
            padding: 20px;
        }

        /* HEADER */
        .profile-header {
            background: linear-gradient(135deg, #2563eb, #1d4ed8);
            color: white;
            padding: 30px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 30px;
        }

        .profile-header i {
            font-size: 60px;
        }

        .profile-header h2 {
            margin: 0;
        }

        .profile-header p {
            margin: 4px 0 0;
            opacity: 0.9;
        }

        /* GRID */
        .profile-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 24px;
        }

        /* CARD */
        .profile-card {
            background: white;
            padding: 24px;
            border-radius: 14px;
            box-shadow: 0 8px 22px rgba(0,0,0,0.08);
        }

        .profile-card h3 {
            margin-top: 0;
            margin-bottom: 18px;
            color: #2563eb;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* INFO ROW */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #eee;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        /* ACTION ROW */
        .action-row {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 0;
        }

        .action-row i {
            font-size: 28px;
            color: #2563eb;
        }

        .action-row p {
            margin: 2px 0 0;
            font-size: 13px;
            color: #666;
        }

        /* BUTTONS */
        .btn {
            margin-left: auto;
            background: #2563eb;
            color: white;
            border: none;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-outline {
            margin-left: auto;
            background: transparent;
            color: #2563eb;
            border: 1px solid #2563eb;
            padding: 8px 14px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-danger{
            background:#e74c3c;
            color:white;
        }

        .top-actions{
            margin-bottom:15px;
        }
    </style>
</head>
<body>

<div class="profile-wrapper">

    <!-- Back button -->
    <div class="top-actions">
        <button class="btn-outline" onclick="window.location.href='/admin/home'">
            ← Back
        </button>
    </div>

    <!-- HEADER -->
    <div class="profile-header">
        <i class='bx bx-user-circle'></i>
        <div>
            <h2>{{ ucfirst(session('name')) }}</h2>
            <p>{{ session('position') ?? 'Admin Member' }}</p>
        </div>
    </div>

    <!-- PROFILE CARDS -->
    <div class="profile-grid">

        <!-- PERSONAL INFO -->
        <div class="profile-card">
            <h3><i class='bx bx-id-card'></i> Personal Information</h3>

            <div class="info-row">
                <span>Name</span>
                <strong>{{ session('name') }}</strong>
            </div>

            <div class="info-row">
                <span>Email</span>
                <strong>{{ session('email') ?? '-' }}</strong>
            </div>

            <div class="info-row">
                <span>Role</span>
                <strong>{{ ucfirst(session('role')) }}</strong>
            </div>

            <div class="info-row">
                <span>User ID</span>
                <strong>{{ session('user_id') }}</strong>
            </div>

            <div class="info-row">
                <span>Position</span>
                <strong>{{ session('position') ?? '-' }}</strong>
            </div>
        </div>


        <!-- ACCOUNT SETTINGS -->
        <div class="profile-card">
            <h3><i class='bx bx-cog'></i> Account Settings</h3>

            <div class="action-row">
                <i class='bx bx-lock'></i>
                <div>
                    <strong>Change Password</strong>
                    <p>Update your login credentials</p>
                </div>
                <button class="btn">Soon</button>
            </div>

            <div class="action-row">
                <i class='bx bx-envelope'></i>
                <div>
                    <strong>Update Email</strong>
                    <p>Modify contact email</p>
                </div>
                <button class="btn-outline">Soon</button>
            </div>

            <div class="action-row">
                <i class='bx bx-log-out'></i>
                <div>
                    <strong>Logout</strong>
                    <p>Sign out from the system</p>
                </div>
                <button class="btn btn-danger" onclick="window.location.href='/logout'">
                    Logout
                </button>
            </div>
        </div>

    </div>
</div>

</body>
</html>
