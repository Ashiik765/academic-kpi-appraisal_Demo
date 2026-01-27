<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Appraiser Dashboard</title>

    <!-- Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        * { box-sizing: border-box; }

        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f4f6f9;
        }

        .layout {
            display: flex;
            height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 260px;
            background: #1f2d3d;
            color: white;
            padding: 20px 0;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 18px;
        }

        .menu {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .menu li {
            padding: 14px 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: 0.3s;
        }

        .menu li:hover {
            background: #34495e;
        }

        .submenu {
            display: none;
            background: #2c3e50;
        }

        .submenu div {
            padding: 12px 40px;
            cursor: pointer;
            font-size: 14px;
        }

        .submenu div:hover {
            background: #3b4b5b;
        }

        /* MAIN */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #2980b9;
            color: white;
            padding: 16px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .navbar h2 {
            margin: 0;
            font-size: 18px;
        }

        .navbar p {
            margin: 0;
            font-size: 14px;
        }

        .content {
            padding: 30px;
            overflow-y: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
        }

        /* LOGOUT MODAL */
        .modal-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            z-index: 999;
            align-items: center;
            justify-content: center;
        }

        .modal-box {
            background: white;
            padding: 30px;
            width: 350px;
            border-radius: 12px;
            text-align: center;
        }

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
    </style>
</head>
<body>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Appraiser Panel</h3>

        <ul class="menu">

            <li onclick="goTo('/appraiser/home')">
                <span><i class='bx bx-home'></i> Dashboard</span>
            </li>

            <li onclick="toggleMenu('kpiMenu')">
                <span><i class='bx bx-list-check'></i> Staff KPI Review</span>
                <i class='bx bx-chevron-down'></i>
            </li>
            <div class="submenu" id="kpiMenu">
                <div onclick="goTo('/appraiser/teaching-outreach')">Teaching & Outreach</div>
                <div onclick="goTo('/appraiser/evidence')">Evidence Files</div>
                <div onclick="goTo('/appraiser/feedback')">Feedback & Comments</div>
                <div onclick="goTo('/appraiser/return')">Return for Correction</div>
            </div>

            <li onclick="toggleMenu('moderationMenu')">
                <span><i class='bx bx-lock'></i> Moderation</span>
                <i class='bx bx-chevron-down'></i>
            </li>
            <div class="submenu" id="moderationMenu">
                <div onclick="goTo('/appraiser/moderation/lock')">Lock Scores</div>
                <div onclick="goTo('/appraiser/moderation/apply')">Apply Moderation</div>
                <div onclick="goTo('/appraiser/moderation/batch')">Batch Approval</div>
            </div>

            <li onclick="toggleMenu('reportMenu')">
                <span><i class='bx bx-bar-chart'></i> Reports</span>
                <i class='bx bx-chevron-down'></i>
            </li>
            <div class="submenu" id="reportMenu">
                <div onclick="goTo('/appraiser/reports/individual')">Individual Reports</div>
                <div onclick="goTo('/appraiser/reports/department')">Department Summary</div>
                <div onclick="goTo('/appraiser/reports/export')">Export PDF / Excel</div>
            </div>

            <li onclick="toggleMenu('profileMenu')">
                <span><i class='bx bx-user'></i> Profile</span>
                <i class='bx bx-chevron-down'></i>
            </li>
            <div class="submenu" id="profileMenu">
                <div onclick="goTo('/appraiser/profile')">Personal Info</div>
                <div onclick="goTo('/appraiser/password')">Change Password</div>
            </div>

            <li onclick="openLogout()">
                <span><i class='bx bx-log-out'></i> Logout</span>
            </li>

        </ul>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="navbar">
            <h2>Welcome, {{ ucfirst(trim(session('name'))) }}</h2>
            <p>{{ session('position') }}</p>
        </div>

        <div class="content">
            <div class="card">
                <h3>Appraiser Dashboard</h3>
                <p>Select a KPI module from the left menu to begin review.</p>
            </div>
        </div>

    </div>
</div>

<!-- LOGOUT MODAL -->
<div class="modal-overlay" id="logoutModal">
    <div class="modal-box">
        <h3>KPI Appraisal System</h3>
        <p>Do you really want t logout?</p>
        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeLogout()">Cancel</button>
            <button class="btn-logout" onclick="confirmLogout()">Yes, Logout</button>
        </div>
    </div>
</div>

<script>
function toggleMenu(id) {
    const menu = document.getElementById(id);
    menu.style.display = menu.style.display === "block" ? "none" : "block";
}

function goTo(url) {
    window.location.href = url;
}

function openLogout() {
    document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogout() {
    document.getElementById('logoutModal').style.display = 'none';
}

function confirmLogout() {
    window.location.href = "/logout";
}
</script>

</body>
</html>
