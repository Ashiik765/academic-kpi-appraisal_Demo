<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
        }

        /* ================= TOP BAR ================= */
        .topbar {
            background: #1e3a8a;
            color: white;
            padding: 14px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .top-left {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logout-btn {
            background: none;
            color: white;
            border: none;
            font-size: 22px;
            cursor: pointer;
        }

        .username {
            font-size: 15px;
            opacity: 0.9;
        }

        .username {
            text-align: right;
        }

        .username div:last-child {
            font-size: 13px;
            opacity: 0.85;
        }


        /* ================= MAIN ================= */
        .container {
            padding: 30px;
        }

        h2.section-title {
            margin-bottom: 20px;
            color: #1f2937;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.08);
            transition: 0.3s;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 22px rgba(0,0,0,0.12);
        }

        .card h3 {
            margin-bottom: 10px;
            color: #111827;
        }

        .card p, .card li {
            font-size: 14px;
            color: #4b5563;
        }

        /* ================= PROGRESS ================= */
        .progress-bar {
            background: #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            margin-top: 12px;
        }

        .progress {
            background: #22c55e;
            height: 10px;
            width: 60%; /* demo value */
        }

        .progress-text {
            margin-top: 8px;
            font-size: 13px;
            color: #374151;
        }

        /* ================= BUTTONS ================= */
        .btn {
            display: inline-block;
            margin-top: 10px;
            background: #2563eb;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
        }

        .btn:hover {
            background: #1d4ed8;
        }

        /* ================= MODAL ================= */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            align-items: center;
            justify-content: center;
        }

        .modal-box {
            background: white;
            padding: 28px;
            width: 360px;
            border-radius: 12px;
            text-align: center;
        }

        .modal-box h2 {
            margin-bottom: 10px;
            color: #1e3a8a;
        }

        .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 22px;
        }

        .btn-danger {
            background: #dc2626;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
        }

        .btn-secondary {
            background: #e5e7eb;
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- ================= TOP BAR ================= -->
<div class="topbar">
    <div class="top-left">
        <button class="logout-btn" onclick="openLogoutModal()">←</button>
        <h2>Staff Dashboard</h2>
    </div>

    <div class="username">
    <div>Welcome, {{ ucfirst(trim(session('name'))) }}</div>
    <div style="font-size: 13px; opacity: 0.8;">
        {{ session('position') }}
    </div>

</div>

</div>

<!-- ================= CONTENT ================= -->
<div class="container">

    <h2 class="section-title">Dashboard Overview</h2>

    <div class="cards">

        <!-- Appraisal Status -->
        <div class="card">
            <h3>Appraisal Status</h3>
            <p>Current Appraisal Cycle: <strong>Active</strong></p>
            <div class="progress-bar">
                <div class="progress"></div>
            </div>
            <div class="progress-text">KPI Completion: 60%</div>
        </div>

        <!-- Notifications -->
        <div class="card">
            <h3>Notifications</h3>
            <ul>
                <li>Pending Self-Evaluation submission</li>
                <li>Upcoming Deadline: 30 September</li>
            </ul>
        </div>

        <!-- Quick Actions -->
        <div class="card">
            <h3>Quick Actions</h3>
            <a href="/staff/teaching-outreach" class="btn">KPI Entry</a>

            <a href="#" class="btn">Upload Evidence</a><br>
            <a href="#" class="btn">Self Evaluation</a>
        </div>

        <!-- KPI History -->
        <div class="card">
            <h3>KPI History</h3>
            <p>View previous appraisal cycles and results.</p>
            <a href="#" class="btn">View History</a>
        </div>

        <!-- Profile -->
        <div class="card">
            <h3>Profile</h3>
            <p>View and update your personal information.</p>
            <a href="#" class="btn">Profile Settings</a>
        </div>

    </div>
</div>

<!-- ================= LOGOUT MODAL ================= -->
<div id="logoutModal" class="modal">
    <div class="modal-box">
        <h2>Leveral KPI System</h2>
        <p>Do you really want to logout?</p>

        <div class="modal-actions">
            <a href="/logout" class="btn-danger">Yes, Logout</a>
            <button onclick="closeLogoutModal()" class="btn-secondary">Cancel</button>
        </div>
    </div>
</div>

<script>
function openLogoutModal() {
    document.getElementById('logoutModal').style.display = 'flex';
}
function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}
</script>

</body>
</html>
