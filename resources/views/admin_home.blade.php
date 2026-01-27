<!DOCTYPE html>
<html>
<head>
    <title>Admin Home</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: #f4f6f9;
        }
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #27ae60;
            color: white;
            padding: 15px 25px;
            position: sticky;
            top: 0;
        }
        .navbar h2 { margin: 0; font-size: 20px; }
        .logout-arrow {
            cursor: pointer;
            font-size: 32px; /* Bigger icon */
        }
        .container { padding: 25px; }
        .welcome { font-size: 24px; margin-bottom: 20px; }
        .dashboard, .quick-links { display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 25px; }
        .card {
            background: white;
            padding: 20px;
            border-radius: 12px;
            flex: 1 1 250px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            transition: 0.3s;
            cursor: pointer;
        }
        .card:hover { transform: translateY(-5px); box-shadow: 0 12px 25px rgba(0,0,0,0.15);}
        .card h3 { margin-top: 0; margin-bottom: 10px; color: #27ae60; }
        .card p { margin: 5px 0; font-size: 16px; }

        /* User table */
        .user-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .user-table th, .user-table td { border: 1px solid #ccc; padding: 10px; text-align: left; font-size: 15px; }
        .user-table th { background: #27ae60; color: white; }
        .user-table td button { padding: 5px 10px; border: none; border-radius: 6px; cursor: pointer; color: white; font-size: 14px;}
        .edit-btn { background: #f39c12; }
        .delete-btn { background: #e74c3c; }

        /* Quick links icons */
        .quick-links .card h3::before {
            content: '\f0c9'; /* Default icon (FontAwesome fallback) */
            font-family: 'Font Awesome 5 Free';
            margin-right: 8px;
            font-weight: 900;
        }

                /* Modal Overlay */
        .modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: 100%;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }


        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            transition: 0.3s;
        }


        /* Modal Box */
        .modal-box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 15px 30px rgba(0,0,0,0.3);
            animation: fadeIn 0.3s ease-in-out;
        }

        .modal-box h3 {
            margin-top: 0;
            color: #27ae60;
        }

        .modal-box p {
            margin: 15px 0;
            font-size: 16px;
        }

        /* Buttons */
        .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .btn-cancel {
            background: #bdc3c7;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            cursor: pointer;
        }

        /* Animation */
        @keyframes fadeIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

    </style>
</head>
<body>

<div class="navbar">
    <i class='bx bx-arrow-back logout-arrow' onclick="logoutConfirm()"></i>

    <h2>Welcome, {{ session('name') }}</h2>
    
    @if(session('role') === 'staff')
        <p>{{ session('position') }}</p>
    @endif


</div>

<div class="container">
    <!-- Dashboard -->
    <div class="welcome">Admin Dashboard</div>
    <div class="dashboard">
        <div class="card">
            <h3>Staff Users</h3>
            <p>Number using system: {{ $staffCount }}</p>
        </div>
        <div class="card">
            <h3>Appraisers</h3>
            <p>Number: {{ $appraiserCount }}</p>
        </div>
        <div class="card">
            <h3>Admins</h3>
            <p>Number: {{ $adminCount }}</p>
        </div>
    </div>

    <!-- Quick Links -->
    <div class="dashboard">
        <a href="/admin/add-user" style="text-decoration:none; color:inherit;">
            <div class="card" style="cursor:pointer;">
                <h3><i class='bx bx-user'></i> User Management</h3>
                <p>Add / Edit / Remove Users</p>
            </div>
        </a>

        <a href="/admin/kpi/teaching-outreach" style="text-decoration:none; color:inherit;">
            <div class="card">
                <a href="/admin/kpi/teaching-outreach">
                <h3><i class='bx bx-bar-chart'></i> KPI & Appraisal</h3>
                <p>Set up appraisal cycles & KPIs</p>
            </div>
        </a>


        <div class="card">
            <h3><i class='bx bx-cog'></i> System Settings</h3>
            <p>Password policy, notifications, file settings</p>
        </div>
        <div class="card">
            <h3><i class='bx bx-file'></i> Reports & Analytics</h3>
            <p>Export reports, track performance trends</p>
        </div>
        <div class="card">
            <h3><i class='bx bx-lock'></i> Audit & Logs</h3>
            <p>Monitor login, uploads, score changes</p>
        </div>
    </div>

    <!-- User Table -->
    <div class="card" style="margin-top: 20px; flex: 1 1 100%;">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h3 style="margin-bottom: 0;">All Users</h3>
            <div>
                <label for="roleFilter" style="font-size: 15px; margin-right: 6px;">Filter:</label>
                <select id="roleFilter" style="padding: 6px 12px; border-radius: 6px; border: 1px solid #ccc;">
                    <option value="all">All</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                    <option value="appraiser">Appraiser</option>
                </select>
            </div>
        </div>
        <table class="user-table" id="userTable">
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            @foreach($users as $user)
            <tr data-role="{{ strtolower($user->role) }}">
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <button class="edit-btn">Edit</button>
                    <button class="delete-btn">Delete</button>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>

<!-- Logout Modal -->
<div id="logoutModal" class="modal-overlay">
    <div class="modal-box">
        <h3>KPI Appraisal System</h3>
        <p>Do you really want to logout?</p>

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeLogout()">Cancel</button>
            <button class="btn-logout" onclick="confirmLogout()">Yes, Logout</button>
        </div>
    </div>
</div>


<script>
function logoutConfirm() {
    document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogout() {
    document.getElementById('logoutModal').style.display = 'none';
}

function confirmLogout() {
    window.location.href = "/logout";
}

// User role filter logic
document.addEventListener('DOMContentLoaded', function() {
    var filter = document.getElementById('roleFilter');
    var table = document.getElementById('userTable');
    filter.addEventListener('change', function() {
        var value = filter.value;
        var rows = table.querySelectorAll('tr[data-role]');
        rows.forEach(function(row) {
            if (value === 'all' || row.getAttribute('data-role') === value) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
});
</script>


</body>
</html>
