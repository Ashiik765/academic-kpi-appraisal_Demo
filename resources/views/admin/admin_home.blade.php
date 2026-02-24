<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body { margin: 0; font-family: 'Roboto', sans-serif; background: #f4f6f9; }
        .layout { display: flex; height: 100vh; }

        .sidebar {
            width: 260px;
            background: #1f2d3d;
            color: white;
            padding: 20px 0;
        }

        .sidebar h3 {
            text-align: center;
            margin-bottom: 30px;
        }

        .menu { list-style: none; padding: 0; margin: 0; }

        .menu li {
            padding: 14px 20px;
            cursor: pointer;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .menu li:hover { background: #34495e; }

        .submenu { display: none; background: #2c3e50; }
        .submenu div {
            padding: 12px 40px;
            cursor: pointer;
            font-size: 14px;
        }
        .submenu div:hover { background: #3b4b5b; }

        .main { flex: 1; display: flex; flex-direction: column; }

        .navbar {
            background: #27ae60;
            color: white;
            padding: 16px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .content {
            padding: 30px;
            overflow-y: auto;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            margin-bottom: 20px;
        }

        .overview-cards {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .overview-card {
            flex: 1;
            min-width: 220px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 30px 20px;
            border-radius: 16px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }

        .overview-card i {
            font-size: 3em;
            margin-bottom: 10px;
        }

        .overview-card .count {
            font-size: 2.4em;
            font-weight: bold;
        }

        #toast {
            position: fixed;
            top: 20px;
            right: 20px;
            background: #27ae60;
            color: white;
            padding: 14px 22px;
            border-radius: 10px;
            display: none;
            z-index: 9999;
            box-shadow: 0 8px 20px rgba(0,0,0,0.25);
        }


                /* ===== MODAL ===== */
        .modal {
            display:none;
            position:fixed;
            inset:0;
            background:rgba(0,0,0,0.5);
            justify-content:center;
            align-items:center;
            z-index:9999;
        }

        .modal-box {
            background:white;
            padding:30px;
            border-radius:12px;
            text-align:center;
            width:260px;
        }

        .btn {
            background:#27ae60;
            color:white;
            padding:8px 14px;
            border-radius:6px;
            text-decoration:none;
            border:none;
            cursor:pointer;
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

<div id="toast"></div>

<div class="layout">

    <!-- SIDEBAR -->
    <div class="sidebar">
        <h3>Admin Panel</h3>

        <ul class="menu">
            <li onclick="loadDashboard()">
                <span><i class='bx bx-home'></i> Dashboard</span>
            </li>

            <li onclick="toggleMenu('kpiMenu')">
                <span><i class='bx bx-bar-chart'></i> KPI Management</span>
                <i class='bx bx-chevron-down'></i>
            </li>

            <div class="submenu" id="kpiMenu">
                <div onclick="loadPage('/admin/kpi/teaching')">
                    a. Teaching & Outreach
                </div>

                <div onclick="loadPage('/admin/kpi/research')">
                    b. Research & Innovation
                </div>

                <div onclick="loadPage('/admin/kpi/internal')">
                    c. Internal Processes
                </div>

                <div onclick="loadPage('/admin/kpi/learning')">
                    d. Learning & Growth
                </div>
            </div>

            

            <li onclick="loadPage('/admin/users')">
                <span><i class='bx bx-group'></i> Users</span>
            </li>

            <li onclick="openLogoutModal()">
                <span><i class='bx bx-log-out'></i> Logout</span>
            </li>


        </ul>
    </div>

    <!-- MAIN -->
    <div class="main">
        <div class="navbar">
            <h2>Welcome, {{ ucfirst(session('name')) }}</h2>
            <span>Administrator</span>
        </div>

        <div class="content" id="contentArea"></div>
    </div>

</div>



<!-- ===== LOGOUT MODAL ===== -->
<div id="logoutModal" class="modal">
    <div class="modal-box">
        <h3>Logout?</h3>
        <br>
        <a href="/logout" class="btn">Yes Logout</a>
        <button onclick="closeLogoutModal()" class="btn">Cancel</button>
    </div>
</div>



<script>
/* ===== DASHBOARD (SINGLE SOURCE) ===== */
function loadDashboard() {

    document.getElementById('contentArea').innerHTML = `
        <div class="card">
            <h2>Dashboard Overview</h2>
            <p>
                Welcome to the KPI Appraisal System.  
                From here you can manage users, KPIs, and view system statistics.
            </p>

            <!-- Graph placeholder -->
            <div class="card" style="margin-top:20px; background:#f8f9fb;">
                <h3>Performance Summary</h3>
                <p style="color:#777;">(Graph will be added here later)</p>
            </div>

            <div class="overview-cards">
                <div class="overview-card">
                    <i class='bx bx-user'></i>
                    <div class="count">{{ $staffCount }}</div>
                    <div>Total Staff</div>
                </div>

                <div class="overview-card">
                    <i class='bx bx-check-circle'></i>
                    <div class="count">{{ $appraiserCount }}</div>
                    <div>Total Appraisers</div>
                </div>

                <div class="overview-card">
                    <i class='bx bx-shield-alt'></i>
                    <div class="count">{{ $adminCount }}</div>
                    <div>Total Admins</div>
                </div>
            </div>
        </div>
    `;
}

/* Load dashboard on FIRST login */
loadDashboard();

/* ===== AJAX PAGE LOADER ===== */
function loadPage(url) {

    fetch(url,{
        credentials: 'same-origin'  
    })
        .then(res => {
            if (!res.ok) throw new Error("error");
            return res.text();
        })
        .then(html => {

            document.getElementById('contentArea').innerHTML = html;

            /* 🔥 VERY IMPORTANT — reattach ALL page scripts */
            if (typeof attachUsersPage === "function") attachUsersPage();
            if (typeof attachAddUserForm === "function") attachAddUserForm();

        })
        .catch(() => {
            document.getElementById('contentArea').innerHTML =
                '<div class="card">⚠️ Page failed to load</div>';
        });
}



/* ===== UI HELPERS ===== */
function toggleMenu(id) {
    const menu = document.getElementById(id);
    menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

function openLogoutModal() {
    document.getElementById('logoutModal').style.display = 'flex';
}

function closeLogoutModal() {
    document.getElementById('logoutModal').style.display = 'none';
}



function showToast(msg) {
    const t = document.getElementById('toast');
    t.innerText = msg;
    t.style.display = 'block';
    setTimeout(() => t.style.display = 'none', 2500);
}
</script>



<script>
function attachAddUserForm() {
    const form = document.getElementById('addUserFormEl');
    if (!form) return;

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        const formData = new FormData(form);

        fetch('/admin/users/store', {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') || '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                showToast('User added successfully');
                loadPage('/admin/users');
            } else {
                showToast('Error: ' + (data.message || 'Failed to add user'), 'error');
            }
        })
        .catch(err => {
            console.error(err);
            showToast('An error occurred. Please try again.', 'error');
        });
    });

    // Show position field only when Staff is selected
    const roleSelect = document.getElementById('roleSelect');
    if (roleSelect) {
        roleSelect.addEventListener('change', function() {
            const positionField = document.getElementById('positionField');
            if (this.value === 'staff') {
                positionField.style.display = 'block';
            } else {
                positionField.style.display = 'none';
            }
        });
    }
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

<div id="pageLoader">
    <div class="loader-spinner"></div>
</div>


@yield('scripts')


<script>
function addRow() {
    let table = document.getElementById('kpiTable');

    if (!table) {
        alert("Table not found");
        return;
    }

    let row = table.insertRow(-1);

    row.innerHTML = `
        <td>
            <input type="text" name="criteria[]" required style="width:100%; padding:5px;">
        </td>
        <td>
            <input type="number" name="weightage[]" required style="width:100%; padding:5px;">
        </td>
        <td>
            <button type="button" onclick="this.closest('tr').remove()" style="background:red;color:white;border:none;">
                X
            </button>
        </td>
    `;
}
</script>


</body>

</html>


