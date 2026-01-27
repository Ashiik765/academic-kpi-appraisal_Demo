<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KPI Appraisal System</title>

    <!-- Boxicons -->
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .container {
            background: white;
            width: 700px;
            max-width: 90%;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
            text-align: center;
        }

        .app-title {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 8px;
        }

        .subtitle {
            color: #555;
            font-size: 16px;
            margin-bottom: 20px;
        }

        .description {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-bottom: 35px;
        }

        .roles {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
            gap: 20px;
        }

        .role-card {
            text-decoration: none;
            color: white;
            padding: 25px 15px;
            border-radius: 14px;
            transition: transform 0.2s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 140px;
        }

        .role-card i {
            font-size: 40px;
            margin-bottom: 10px;
        }

        .role-card span {
            font-size: 16px;
            font-weight: bold;
        }

        .staff {
            background: linear-gradient(135deg, #3498db, #2980b9);
        }

        .appraiser {
            background: linear-gradient(135deg, #e67e22, #d35400);
        }

        .admin {
            background: linear-gradient(135deg, #2ecc71, #27ae60);
        }

        .role-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.25);
        }

        footer {
            margin-top: 30px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="container">

    <div class="app-title">KPI Appraisal System</div>
    <div class="subtitle">Academic Performance & Evaluation Platform</div>

    <div class="description">
        This system is designed to manage staff performance appraisal through
        Key Performance Indicators (KPIs).  
        It allows staff to submit activities and evidence, appraisers to evaluate
        performance, and administrators to manage users and appraisal cycles
        efficiently.
    </div>

    <div class="roles">
        <a href="/staff/login" class="role-card staff">
            <i class='bx bx-user'></i>
            <span>Staff</span>
        </a>

        <a href="/appraiser/login" class="role-card appraiser">
            <i class='bx bx-check-shield'></i>
            <span>Appraiser</span>
        </a>

        <a href="/admin/login" class="role-card admin">
            <i class='bx bx-cog'></i>
            <span>Admin</span>
        </a>
    </div>

    <footer>
        © 2026 KPI Appraisal System • All Rights Reserved
    </footer>

</div>

</body>
</html>
