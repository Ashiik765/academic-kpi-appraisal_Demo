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

    <li>
        <a href="/appraiser/kpi">
            <i class='bx bx-list-check'></i> KPI Entry
        </a>
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
<p>{{ session('position') }}</p>
</div>

<div class="content" id="contentArea">

<div class="card">
<h3>📌 KPI Appraisal System</h3>
<p>Review staff performance and score their KPI submissions.</p>
</div>

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
        document.getElementById("pageLoader").classList.remove("loader-hide");
        
        fetch(url)

        .then(response => {
                if (!response.ok) throw new Error();
                return response.text();
            })
            .then(html => {
                area.innerHTML = html;
                document.getElementById("pageLoader").classList.add("loader-hide");
            })
            .catch(() => {
                area.innerHTML = "<div class='card'>⚠ Failed to load page</div>";
                document.getElementById("pageLoader").classList.add("loader-hide");
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

    /* ⭐ universal loader */
    function loadPage(url){

        const area=document.getElementById('contentArea');

        area.innerHTML="<div class='loader'>Loading...</div>";

        fetch(url)
        .then(res=>{
            if(!res.ok) throw new Error();
            return res.text();
        })
        .then(html=>{
            area.innerHTML=html;
        })
        .catch(()=>{
            area.innerHTML="<div class='card'>⚠ Failed to load page</div>";
        });
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


</body>
</html>
