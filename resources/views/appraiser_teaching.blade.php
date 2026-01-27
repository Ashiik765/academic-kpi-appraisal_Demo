<!DOCTYPE html>
<html>
<head>
    <title>Teaching & Outreach Review</title>

    <link href="https://cdn.jsdelivr.net/npm/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Roboto', sans-serif;
            margin: 0;
            background: #f4f6f9;
        }

        /* NAVBAR */
        .navbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #2980b9;
            color: white;
            padding: 16px 25px;
        }



        .navbar h2 {
            margin: 0;
            color: white;
        }

        

        .back-btn {
            font-size: 30px;
            cursor: pointer;
        }

        .container {
            padding: 25px;
            max-width: 1100px;
            margin: auto;
        }

        h2 {
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            color: #2980b9;
            margin-bottom: 15px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 14px;
        }

        .field label {
            font-size: 13px;
            color: #555;
        }

        .field div {
            font-size: 14px;
            margin-top: 4px;
            color: #111;
        }

        textarea, select, input[type="file"] {
            width: 100%;
            padding: 8px;
            border-radius: 6px;
            border: 1px solid #ccc;
            font-size: 14px;
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 15px;
        }

        .btn {
            padding: 8px 18px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-approve {
            background: #27ae60;
            color: white;
        }

        .btn-return {
            background: #e67e22;
            color: white;
        }

        .download {
            color: #2980b9;
            text-decoration: none;
            font-size: 14px;
        }

        .info {
            background: #eaf2f8;
            border-left: 4px solid #2980b9;
            padding: 14px;
            border-radius: 6px;
            margin-bottom: 20px;
            font-size: 14px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<div class="navbar">
    <i class='bx bx-arrow-back back-btn' onclick="window.location.href='/appraiser/home'"></i>
    <h2>Teaching & Outreach Review</h2>
    <div style="font-size: 18px; font-weight: 600;">
        {{ ucfirst(session('name')) }}
    </div>
</div>

<div class="container">

    <div class="info">
        Review staff teaching submissions and provide appraisal comments based on KPI guidelines.
    </div>

    <!-- STAFF TEACHING DETAILS -->
    <div class="card">
        <div class="section-title">Staff Teaching Details</div>

        <div class="grid">
            <div class="field">
                <label>Staff Name</label>
                <div>{{ $record->staff_name ?? 'Staff Name' }}</div>
            </div>

            <div class="field">
                <label>Academic Year</label>
                <div>{{ $record->academic_year ?? '2026' }}</div>
            </div>

            <div class="field">
                <label>Semester</label>
                <div>{{ $record->semester ?? 'Semester 1' }}</div>
            </div>

            <div class="field">
                <label>Course Code</label>
                <div>{{ $record->course_code ?? 'CS101' }}</div>
            </div>

            <div class="field">
                <label>Course Name</label>
                <div>{{ $record->course_name ?? 'Course Name' }}</div>
            </div>

            <div class="field">
                <label>Programme Level</label>
                <div>{{ $record->level ?? 'Degree' }}</div>
            </div>

            <div class="field">
                <label>Credit Hours</label>
                <div>{{ $record->credit_hours ?? '3' }}</div>
            </div>

            <div class="field">
                <label>Students</label>
                <div>{{ $record->students ?? '40' }}</div>
            </div>

            <div class="field">
                <label>Teaching Mode</label>
                <div>{{ $record->mode ?? 'Lecture' }}</div>
            </div>

            <div class="field">
                <label>Teaching Role</label>
                <div>{{ $record->role ?? 'Lecturer' }}</div>
            </div>

            <div class="field">
                <label>Total Hours</label>
                <div>{{ $record->hours ?? '45' }}</div>
            </div>

            <div class="field">
                <label>Staff Remarks</label>
                <div>{{ $record->remarks ?? '-' }}</div>
            </div>

            <div class="field">
                <label>Staff Evidence</label>
                <div>
                    <a href="/storage/{{ $record->evidence ?? '#' }}" class="download" target="_blank">
                        Download Evidence
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- APPRAISER INPUT -->
    <form method="POST" action="/appraiser/teaching/review" enctype="multipart/form-data">
        @csrf

        <div class="card">
            <div class="section-title">Appraiser Review</div>

            <div class="grid">
                <div style="grid-column: 1 / -1;">
                    <label>Appraiser Comments</label>
                    <textarea name="comment" rows="4"></textarea>
                </div>

                <div>
                    <label>Recommendation</label>
                    <select name="recommendation">
                        <option>Meets Expectation</option>
                        <option>Exceeds Expectation</option>
                        <option>Needs Improvement</option>
                    </select>
                </div>

                <div>
                    <label>Upload Appraiser Evidence (Optional)</label>
                    <input type="file" name="appraiser_file">
                </div>
            </div>

            <div class="actions">
                <button type="submit" name="status" value="returned" class="btn btn-return">
                    Return for Correction
                </button>
                <button type="submit" name="status" value="approved" class="btn btn-approve">
                    Approve Submission
                </button>
            </div>
        </div>

    </form>

</div>

</body>
</html>
