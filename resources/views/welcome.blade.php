<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>KPI Appraisal System</title>

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #667eea, #764ba2);
            margin: 0;
            min-height: 100vh;
            display: flex;
            color: #333;
        }

        /* FULL SCREEN CONTAINER */
        .container {
            width: 100%;
            min-height: 100vh;
            padding: 60px 8%;
            display: flex;
            flex-direction: column;
            justify-content: center;
            text-align: center;
            background: rgba(255,255,255,0.95);
        }

        .app-title {
            font-size: 48px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #555;
            font-size: 20px;
            margin-bottom: 20px;
        }

        .description {
            font-size: 16px;
            color: #666;
            line-height: 1.7;
            max-width: 900px;
            margin: 0 auto 50px auto;
        }

        /* ROLES FULL WIDTH */
        .roles {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 40px;
            width: 100%;
            max-width: 1100px;
            margin: 0 auto;
        }

        .role-card {
            text-decoration: none;
            color: white;
            padding: 40px 20px;
            border-radius: 18px;
            transition: transform 0.25s, box-shadow 0.25s;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 180px;
        }

        .role-card i {
            font-size: 55px;
            margin-bottom: 12px;
        }

        .role-card span {
            font-size: 20px;
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
            transform: translateY(-8px);
            box-shadow: 0 15px 30px rgba(0,0,0,0.25);
        }

        footer {
            margin-top: 60px;
            font-size: 13px;
            color: #777;
        }

        /* MOBILE RESPONSIVE */
        @media (max-width: 900px) {
            .roles {
                grid-template-columns: 1fr;
            }
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
        <a href="{{ url('/staff/login') }}" class="role-card staff">
            <i class='bx bx-user'></i>
            <span>Staff</span>
        </a>

        <a href="{{ url('/appraiser/login') }}" class="role-card appraiser">
            <i class='bx bx-check-shield'></i>
            <span>Appraiser</span>
        </a>

        <a href="{{ url('/admin/login') }}" class="role-card admin">
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
