<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Appraiser Dashboard</title>

<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

<style>
        *{box-sizing:border-box}

        body{
            margin:0;
            font-family:'Roboto',sans-serif;
            background:#f4f6f9;
        }

        /* LAYOUT */
        .layout{display:flex;height:100vh}

        /* SIDEBAR */
        .sidebar{
            width:250px;
            background:#1f2d3d;
            color:white;
            padding:20px 0;
        }

        .sidebar h3{
            text-align:center;
            margin-bottom:25px;
        }

        .menu{list-style:none;padding:0;margin:0}

        .menu li{
            padding:14px 22px;
            cursor:pointer;
            display:flex;
            align-items:center;
            gap:10px;
            transition:.25s;
        }

        .menu li:hover{background:#34495e}

        .menu li.active{
            background:#2980b9;
        }

        /* Notification Badge */
        .notification-badge {
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 12px;
            margin-left: auto;
            animation: pulse 2s infinite;
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        /* Notification Panel */
        .notification-panel {
            position: fixed;
            top: 70px;
            right: 20px;
            width: 350px;
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.15);
            z-index: 1000;
            display: none;
            overflow: hidden;
        }

        .notification-panel.show {
            display: block;
            animation: slideIn 0.3s ease;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-header {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notification-header h4 {
            margin: 0;
            font-size: 1.1em;
        }

        .mark-all-read {
            background: rgba(255,255,255,0.2);
            border: none;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            cursor: pointer;
            font-size: 0.85em;
            transition: background 0.3s;
        }

        .mark-all-read:hover {
            background: rgba(255,255,255,0.3);
        }

        .notification-list {
            max-height: 400px;
            overflow-y: auto;
        }

        .notification-item {
            padding: 15px 20px;
            border-bottom: 1px solid #edf2f7;
            display: flex;
            align-items: center;
            gap: 15px;
            transition: background 0.3s;
            cursor: pointer;
        }

        .notification-item:hover {
            background: #f7fafc;
        }

        .notification-item.unread {
            background: #ebf8ff;
        }

        .notification-icon {
            width: 40px;
            height: 40px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2em;
        }

        .notification-content {
            flex: 1;
        }

        .notification-title {
            font-weight: 600;
            color: #2d3748;
            margin-bottom: 3px;
        }

        .notification-message {
            font-size: 0.9em;
            color: #718096;
        }

        .notification-time {
            font-size: 0.75em;
            color: #a0aec0;
            margin-top: 3px;
        }

        .notification-actions {
            margin-top: 8px;
        }

        .view-btn {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
            border: none;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 0.85em;
            cursor: pointer;
            transition: all 0.3s;
            text-decoration: none;
            display: inline-block;
        }

        .view-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 10px rgba(52, 152, 219, 0.3);
        }

        .notification-empty {
            padding: 30px;
            text-align: center;
            color: #a0aec0;
        }

        /* submenu animation */
       .submenu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease;
        }

        .submenu li a {
            color: white !important;
            text-decoration: none;
            display: block;
            padding: 8px 0;
            transition: opacity 0.3s ease;
        }

        .submenu li a:hover {
            opacity: 0.8;
            text-decoration: underline;
        }

        .submenu.active {
            max-height: 500px;
        }
        .submenu div{
            padding:12px 45px;
            font-size:14px;
            cursor:pointer;
        }

        .submenu div:hover{
            background:#3b4b5b;
        }

        .submenu div a{
            color:white;
            text-decoration:none;
        }

        /* MAIN */
        .main{
            flex:1;
            display:flex;
            flex-direction:column;
        }

        .navbar{
            background:#2980b9;
            color:white;
            padding:16px 25px;
            display:flex;
            justify-content:space-between;
            align-items: center;
        }

        .navbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon-wrapper {
            position: relative;
            cursor: pointer;
            font-size: 1.3em;
        }

        .notification-count {
            position: absolute;
            top: -8px;
            right: -8px;
            background: #ef4444;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 11px;
            font-weight: bold;
            min-width: 18px;
            text-align: center;
        }

        .content{
            padding:30px;
            overflow:auto;
        }

        /* card */
        .card{
            background:white;
            padding:25px;
            border-radius:14px;
            box-shadow:0 8px 20px rgba(0,0,0,.08);
        }

        /* loader */
        .loader{
            text-align:center;
            font-size:18px;
            padding:50px;
            color:#555;
        }

        /* modal same as yours */
        .modal-overlay{
            display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,.5);
            z-index:999;
            align-items:center;
            justify-content:center;
        }

        .modal-box{
            background:white;
            padding:30px;
            border-radius:12px;
            width:320px;
            text-align:center;
        }

    
        /* FULL SCREEN OVERLAY */
        #pageLoader{
            position:fixed;
            top:0;
            left:0;
            width:100%;
            height:100%;
            background:white;
            display:flex;
            align-items:center;
            justify-content:center;
            z-index:99999;
            transition:opacity .3s ease;
        }

        /* SPINNER */
        .loader-spinner{
            width:45px;
            height:45px;
            border:5px solid #e5e7eb;
            border-top:5px solid #2563eb;
            border-radius:50%;
            animation:spin 0.8s linear infinite;
        }

        @keyframes spin{
            100%{ transform:rotate(360deg); }
        }

        /* hidden state */
        .loader-hide{
            opacity:0;
            pointer-events:none;
        }

</style>
</head>
<body>

<div class="layout">

<!-- SIDEBAR -->
<div class="sidebar">

<h3>Appraiser Panel</h3>

<ul class="menu">

    <li onclick="goTo('/appraiser/home')" id="dashBtn">
        <i class='bx bx-home'></i> Dashboard
    </li>

    <li onclick="loadPage('/appraiser/kpi')">
        <i class='bx bx-bar-chart'></i> KPI Management
        @if(isset($pendingKpiCount) && $pendingKpiCount > 0)
            <span class="notification-badge">{{ $pendingKpiCount }}</span>
        @endif
    </li>

    <li onclick="loadPage('/appraiser/profile')">
        <i class='bx bx-user'></i> Profile
    </li>

    <li onclick="openLogout()">
        <i class='bx bx-log-out'></i> Logout
    </li>

</ul>
</div>


<!-- MAIN -->
<div class="main">

    <div class="navbar">
        <h2>Welcome, {{ ucfirst(session('name')) }}</h2>
        <div class="navbar-right">
            <div class="notification-icon-wrapper" onclick="toggleNotifications()">
                <i class='bx bx-bell'></i>
                @if(isset($pendingKpiCount) && $pendingKpiCount > 0)
                    <span class="notification-count">{{ $pendingKpiCount }}</span>
                @endif
            </div>
            <p>{{ session('position') }}</p>
        </div>
    </div>

    <!-- Notification Panel -->
    <div class="notification-panel" id="notificationPanel">
        <div class="notification-header">
            <h4>Notifications</h4>
            @if(isset($pendingKpis) && count($pendingKpis) > 0)
                <button class="mark-all-read" onclick="markAllAsRead()">Mark all as read</button>
            @endif
        </div>
        <div class="notification-list" id="notificationList">
            @if(isset($pendingKpis) && count($pendingKpis) > 0)
                @foreach($pendingKpis as $kpi)
                <div class="notification-item unread" data-id="{{ $kpi->id }}">
                    <div class="notification-icon">
                        <i class='bx bx-bar-chart-alt'></i>
                    </div>
                    <div class="notification-content">
                        <div class="notification-title">New KPI for Appraisal</div>
                        <div class="notification-message">
                            {{ $kpi->staff_name }} has submitted {{ $kpi->kpi_criteria }} for appraisal
                        </div>
                        <div class="notification-time">{{ $kpi->created_at->diffForHumans() }}</div>
                        <div class="notification-actions">
                            <a href="/appraiser/kpi/{{ $kpi->id }}" class="view-btn" onclick="markAsRead({{ $kpi->id }})">
                                View KPI
                            </a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="notification-empty">
                    <i class='bx bx-check-circle' style="font-size: 3em; color: #cbd5e0;"></i>
                    <p style="margin-top: 10px;">No new notifications</p>
                </div>
            @endif
        </div>
    </div>

    <div class="content" id="contentArea">

         <div class="card">
            <h3>📌 KPI Appraisal System</h3>
            <p>Review staff performance and score their KPI submissions.</p>
         </div>

        <!-- Summary Cards -->
        @if(isset($pendingKpis) && count($pendingKpis) > 0)
        <div class="summary-cards" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; margin: 20px 0;">
            <div class="card" style="background: linear-gradient(135deg, #667eea, #764ba2); color: white;">
                <h4 style="margin: 0; font-size: 0.9em; opacity: 0.9;">Pending KPI Reviews</h4>
                <p style="font-size: 2.5em; margin: 10px 0; font-weight: 600;">{{ count($pendingKpis) }}</p>
                <small>Awaiting your appraisal</small>
            </div>
        </div>
        @endif

        <div class="content" id="contentArea">
            @yield('content')
        </div>

    </div>

   
    
</div>


<!-- MODAL -->
<div class="modal-overlay" id="logoutModal">
<div class="modal-box">
<h3>Logout?</h3>
<button onclick="confirmLogout()">Yes</button>
<button onclick="closeLogout()">Cancel</button>
</div>
</div>


<script>

    // Notification functions
    function toggleNotifications() {
        const panel = document.getElementById('notificationPanel');
        panel.classList.toggle('show');
    }

    function markAsRead(kpiId) {
        // Update notification count via AJAX
        fetch(`/appraiser/notifications/mark-read/${kpiId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove unread class from notification
                const notification = document.querySelector(`.notification-item[data-id="${kpiId}"]`);
                if (notification) {
                    notification.classList.remove('unread');
                }
                
                // Update notification count
                updateNotificationCount();
            }
        });
    }

    function markAllAsRead() {
        fetch('/appraiser/notifications/mark-all-read', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Remove unread class from all notifications
                document.querySelectorAll('.notification-item').forEach(item => {
                    item.classList.remove('unread');
                });
                
                // Update notification count
                updateNotificationCount();
                
                // Close panel or show empty state
                location.reload();
            }
        });
    }

    function updateNotificationCount() {
        fetch('/appraiser/notifications/count')
        .then(response => response.json())
        .then(data => {
            const badge = document.querySelector('.notification-count');
            const sidebarBadge = document.querySelector('.notification-badge');
            
            if (data.count > 0) {
                if (badge) {
                    badge.textContent = data.count;
                } else {
                    const iconWrapper = document.querySelector('.notification-icon-wrapper');
                    const newBadge = document.createElement('span');
                    newBadge.className = 'notification-count';
                    newBadge.textContent = data.count;
                    iconWrapper.appendChild(newBadge);
                }
                
                if (sidebarBadge) {
                    sidebarBadge.textContent = data.count;
                }
            } else {
                if (badge) badge.remove();
                if (sidebarBadge) sidebarBadge.remove();
            }
        });
    }

    // Close notification panel when clicking outside
    document.addEventListener('click', function(event) {
        const panel = document.getElementById('notificationPanel');
        const icon = document.querySelector('.notification-icon-wrapper');
        
        if (panel.classList.contains('show') && 
            !panel.contains(event.target) && 
            !icon.contains(event.target)) {
            panel.classList.remove('show');
        }
    });

    function loadTeachingKpi(submissionId) {
    const area = document.getElementById('contentArea');
    area.innerHTML = "<div class='loader'>Loading KPI data...</div>";
    
    // Show page loader
    document.getElementById("pageLoader").classList.remove("loader-hide");
    
    // Make AJAX request to get the teaching KPI page
    fetch(`/appraiser/kpi/teaching/${submissionId}`)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.text();
        })
        .then(html => {
            area.innerHTML = html;
            document.getElementById("pageLoader").classList.add("loader-hide");
        })
        .catch(error => {
            console.error('Error:', error);
            area.innerHTML = "<div class='card' style='padding:20px; text-align:center; color:#dc2626;'>⚠ Failed to load KPI data. Please try again.</div>";
            document.getElementById("pageLoader").classList.add("loader-hide");
        });
    }

// Also update the existing loadPage function to handle regular pages

    function loadPage(url) {
        const area = document.getElementById('contentArea');
        area.innerHTML = "<div class='loader'>Loading...</div>";

        fetch(url)
            .then(res => {
                if (!res.ok) throw new Error();
                return res.text();
            })
            .then(html => {
                area.innerHTML = html;
            })
            .catch(() => {
                area.innerHTML = "<div class='card'>⚠ Failed to load page</div>";
            });
    }


    function toggleMenu(id){
        const menu = document.getElementById(id);
        menu.classList.toggle("active");
    }

    function goTo(url) {
    document.getElementById("pageLoader").classList.remove("loader-hide");
    window.location.href = url;
    }


    function openLogout(){
        document.getElementById('logoutModal').style.display='flex';
    }

    function closeLogout(){
        document.getElementById('logoutModal').style.display='none';
    }

    function confirmLogout(){
        window.location='/logout';
    }


    /* Hide loader when page fully loaded */
    window.addEventListener("load", function(){
        document.getElementById("pageLoader").classList.add("loader-hide");
    });


    /* Show loader when clicking links or submitting forms */
    document.addEventListener("DOMContentLoaded", function(){



        /* for all forms */
        document.querySelectorAll("form").forEach(form=>{
            form.addEventListener("submit", function(){
                document.getElementById("pageLoader").classList.remove("loader-hide");
            });

        });


    });




</script>


<div id="pageLoader">
    <div class="loader-spinner"></div>
</div>


</body>
</html>