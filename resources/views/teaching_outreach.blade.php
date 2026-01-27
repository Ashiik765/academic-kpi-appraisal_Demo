<!DOCTYPE html>
<html>
<head>
    <title>Teaching & Outreach - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: #f4f6f9;
        }

        .navbar {
            background: #27ae60;
            color: white;
            padding: 15px 25px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .container { padding: 25px; }

        .page-title {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .section {
            background: white;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
        }

        .section h3 {
            margin-top: 0;
            color: #27ae60;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            font-size: 14px;
        }

        th {
            background: #27ae60;
            color: white;
        }

        .btn {
            padding: 6px 12px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            color: white;
            font-size: 13px;
        }

        .btn-view { background: #3498db; }
        .btn-comment { background: #8e44ad; }
        .btn-add { background: #27ae60; }
        .btn-edit { background: #f39c12; }
        .btn-delete { background: #e74c3c; }

        textarea {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }

        .back-btn {
            text-decoration: none;
            color: white;
            background: #2ecc71;
            padding: 8px 14px;
            border-radius: 6px;
            font-size: 14px;
        }

    </style>
    
</head>
<body>

<div class="navbar">

    <a href="{{ url()->previous() }}" class="back-btn">
        ⬅ Back
    </a>



    <h2>Admin Panel</h2>
    <p>Teaching & Outreach</p>
</div>

<div class="container">

    <div class="page-title">Teaching & Outreach – Admin Control</div>

    <!-- ✅ SECTION 1: STAFF SUBMISSIONS -->
    <div class="section">
        <h3>Staff Teaching Submissions</h3>

        <table>
            <tr>
                <th>Staff Name</th>
                <th>Academic Year</th>
                <th>Semester</th>
                <th>Courses</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>

            <tr>
                <td>Dr. Ali</td>
                <td>2026</td>
                <td>Semester 1</td>
                <td>3</td>
                <td>Approved by Appraiser</td>
                <td>
                    <button class="btn btn-view">View</button>
                    <button class="btn btn-comment">Comment</button>
                </td>
            </tr>
        </table>

        <br>

        <label><strong>Admin Comment (Optional)</strong></label>
        <textarea rows="3" placeholder="Admin notes / audit comments..."></textarea>
    </div>

    <!-- ✅ SECTION 2: TEACHING KPI CONFIG -->
    <div class="section">
        <h3>Teaching KPI Criteria</h3>

        <table>
            <tr>
                <th>Teaching Item</th>
                <th>Description</th>
                <th>Max Marks</th>
                <th>Evidence Required</th>
                <th>Actions</th>
            </tr>

            <tr>
                <td>Course Taught</td>
                <td>Assigned courses per semester</td>
                <td>20</td>
                <td>Yes</td>
                <td>
                    <button class="btn btn-edit">Edit</button>
                    <button class="btn btn-delete">Delete</button>
                </td>
            </tr>
        </table>
    </div>

    <!-- ✅ SECTION 3: OUTREACH KPI CONFIG -->
    <div class="section">
        <h3>Outreach KPI Criteria</h3>

        <table>
            <tr>
                <th>Outreach Activity</th>
                <th>Description</th>
                <th>Max Marks</th>
                <th>Evidence Required</th>
                <th>Actions</th>
            </tr>

            <tr>
                <td>Workshop / Seminar</td>
                <td>Academic workshop conducted</td>
                <td>5</td>
                <td>Yes</td>
                <td>
                    <button class="btn btn-edit">Edit</button>
                    <button class="btn btn-delete">Delete</button>
                </td>
            </tr>
        </table>
    </div>


        <!-- STAFF KPI SUBMISSIONS -->
    <div class="section">
        <h3>
            Staff Teaching & Outreach Submissions
        </h3>

        <table>
            <tr>
                <th>Staff Name</th>
                <th>KPI Item</th>
                <th>Activity Description</th>
                <th>Evidence</th>
                <th>Appraiser Score</th>
                <th>Appraiser Comment</th>
                <th>Admin Comment</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <tr>
                <td>John Doe</td>
                <td>Course Taught</td>
                <td>Taught Web Development – Semester 1</td>
                <td><a href="#">View File</a></td>
                <td>18 / 20</td>
                <td>Good teaching performance</td>
                <td>
                    <textarea placeholder="Admin comment"></textarea>
                </td>
                <td>Pending</td>
                <td>
                    <button class="btn btn-add">Approve</button>
                    <button class="btn btn-delete">Reject</button>
                </td>
            </tr>
        </table>
    </div>


</div>

</body>
</html>
