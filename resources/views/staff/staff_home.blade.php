<!DOCTYPE html>
<html>
<head>
    <title>Staff Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Roboto', sans-serif;
            background: #f4f6f9;
        }

        .layout {
            display: flex;
            height: 100vh;
        }

        /* ===== SIDEBAR ===== */
            /* SIDEBAR */
        .sidebar {
            width: 250px;
            background: #1f2d3d;
            color: white;
            padding: 20px 0;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 25px;
            font-weight: 600;
        }


        .menu {
            list-style: none;
            padding: 0;
        }

        .menu li {
            padding: 14px 24px;
            transition: 0.2s;
            font-size: 14px;
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .menu li:hover {
            background: #34495e;
        }

        .menu a {
            color: white;
            text-decoration: none;
            display: flex;
            gap: 10px;
            align-items: center;
        }

        .menu-toggle .arrow {
            transition: transform 0.3s ease;
        }
        .menu-toggle.active .arrow {
            transform: rotate(180deg);
        }

         .submenu {
            background: #2c3e50;
            list-style:none;
            padding:0;
            margin:0;
            max-height:0;
            overflow:hidden;
            transition: max-height 0.3s ease;
        }

        .submenu.active {
            max-height: 500px;
        }
        .submenu li a {
            display:block;
            padding: 14px 24px;
            font-size: 13px;
            color:white;
            text-decoration:none;
        }
        .submenu li a:hover {
            background:#3b4b5b;
        }

        .menu-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 100%;
        }



        /* ===== MAIN ===== */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            background: #2563eb;
            color: white;
            padding: 16px 30px;
            display: flex;
            justify-content: space-between;
        }

        .content {
            padding: 30px;
            overflow-y: auto;
        }

        .navbar h2 {
            margin: 0;
            font-size: 20px;
        }

        .content {
            padding: 30px;
            overflow-y: auto;
        }

        /* ===== CARDS ===== */
        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 22px;
            margin-top: 20px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.08);
        }

        .card h3 {
            margin-top: 0;
            font-size: 18px;
        }

        .card small {
            color: #777;
        }

        .btn {
            background: #2563eb;
            color: white;
            padding: 8px 14px;
            border-radius: 6px;
            text-decoration: none;
            font-size: 14px;
            display: inline-block;
            margin-top: 12px;
        }

        /* ===== STATUS ===== */
        .status {
            font-weight: 600;
            color: #16a34a;
        }

        /* ===== MODAL ===== */
        .modal {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.5);
            align-items: center;
            justify-content: center;
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


        .modal-box {
            background: white;
            padding: 25px;
            border-radius: 10px;
            width: 350px;
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
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
        }

        .btn-logout {
            background: #e74c3c;
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 6px;
            cursor: pointer;
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


        .menu-toggle {
            cursor: pointer;
        }

        .menu-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu-row span {
            display: flex;
            align-items: center;
            gap: 10px;
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
        <h3>Staff Panel</h3>

        <ul class="menu">

            <li>
                <a href="/staff/home">
                    <i class='bx bx-home'></i> Dashboard
                </a>
            </li>

            <li onclick="toggleMenu('kpiSubMenu', this)" class="menu-toggle">
                <div class="menu-row">
                    <span><i class='bx bx-list-check'></i> KPI Entry</span>
                    <i class='bx bx-chevron-down arrow'></i>
                </div>
                <ul class="submenu" id="kpiSubMenu">
                    <li>
                        <a href="/staff/kpi/teaching">
                            a. Teaching & Outreach
                        </a>
                    </li>
                    <li>
                        <a href="/staff/kpi/research">
                            b. Research & Innovation
                        </a>
                    </li>
                    <li>
                        <a href="/staff/kpi/internal">
                            c. Internal Processes
                        </a>
                    </li>
                    <li>
                        <a href="/staff/kpi/learning">
                            d. Learning & Growth
                        </a>
                    </li>
                </ul>
            </li>


            <li>
                <a href="/staff/profile">
                    <i class='bx bx-user'></i> Profile
                </a>    
            </li>

            

  

            <li>
                <a href="/logout">
                    <i class='bx bx-log-out'></i> Logout
                </a>
            </li>

        </ul>
    </div>

    <!-- MAIN -->
    <div class="main">

        <div class="navbar">
            <h2>Welcome, {{ ucfirst(session('name')) }}</h2>
            <span>{{ session('position') }}</span>
        </div>

        <div class="content" id="contentArea">
            @yield('content')
        </div>

    </div>

</div>
<!-- ===== LOGOUT MODAL ===== -->
<div class="modal" id="logoutModal">
    <div class="modal-box">
        <h3>Confirm Logout</h3>
        <p>Are you sure you want to logout?</p>

        <div class="modal-actions">
            <button class="btn-cancel" onclick="closeLogoutModal()">Cancel</button>
            <button class="btn-logout" onclick="confirmLogout()">Logout</button>
        </div>
    </div>
</div>

<script>

function toggleMenu(menuId, toggleElement) {
    const menu = document.getElementById(menuId);
    menu.classList.toggle("active");
    if (toggleElement) {
        toggleElement.classList.toggle("active");
    }
}




function loadDashboard() {
    document.getElementById('contentArea').innerHTML = `
        <h2>Staff KPI Dashboard</h2>
        <p>Current appraisal cycle status overview</p>

        <div class="cards">
            <div class="card">
                <h3>Appraisal Status</h3>
                <p class="status">Active</p>
                <small>Submission window open</small>
            </div>

            <div class="card">
                <h3>KPI Progress</h3>
                <p>Teaching, Research, Internal & Learning</p>
                <small>Complete all sections before deadline</small>
            </div>

            <div class="card">
                <h3>Quick Action</h3>
                <a href="/staff/kpi" class="btn">Start KPI Entry</a>
            </div>
        </div>
    `;
}

function openLogoutModal() {
    document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}

function confirmLogout() {
    window.location.href = "/logout";
}


/* Hide loader when page fully loaded */
window.addEventListener("load", function(){
    document.getElementById("pageLoader").classList.add("loader-hide");
});


/* Show loader when clicking links or submitting forms */
document.addEventListener("DOMContentLoaded", function(){

    /* for all links */
    document.querySelectorAll("a").forEach(link=>{
        link.addEventListener("click", function(){
            document.getElementById("pageLoader").classList.remove("loader-hide");
        });
    });

    /* for all forms */
    document.querySelectorAll("form").forEach(form=>{
        form.addEventListener("submit", function(){
            document.getElementById("pageLoader").classList.remove("loader-hide");
        });
    });

});

</script>



<!-- GLOBAL PAGE LOADER -->
<div id="pageLoader">
    <div class="loader-spinner"></div>
</div>




</body>
</html>
