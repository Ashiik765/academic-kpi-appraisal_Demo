<!DOCTYPE html>
<html>
<head>
    <title>Teaching & Outreach</title>

    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            margin: 0;
            background: #f4f6f9;
        }

        /* TOP BAR */
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

        .back-btn {
            background: none;
            color: white;
            border: none;
            font-size: 22px;
            cursor: pointer;
        }

        /* CONTENT */
        .container {
            padding: 30px;
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            color: #1f2937;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 14px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }

        .section-title {
            font-size: 18px;
            color: #1e3a8a;
            margin-bottom: 15px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 16px;
        }

        label {
            font-size: 14px;
            color: #374151;
            margin-bottom: 6px;
            display: block;
        }

        input, select, textarea {
            width: 100%;
            padding: 8px 10px;
            border-radius: 6px;
            border: 1px solid #d1d5db;
            font-size: 14px;
        }

        textarea {
            resize: vertical;
        }

        /* BUTTONS */
        .actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 20px;
        }

        .btn {
            background: #2563eb;
            color: white;
            padding: 8px 18px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }

        .btn-secondary {
            background: #6b7280;
        }

        .btn:hover {
            opacity: 0.9;
        }

        /* INFO BOX */
        .info {
            background: #eff6ff;
            border-left: 4px solid #2563eb;
            padding: 14px;
            font-size: 14px;
            color: #1e3a8a;
            margin-bottom: 25px;
            border-radius: 6px;
        }
    </style>
</head>
<body>

<!-- TOP BAR -->
<div class="topbar">
    <div class="top-left">
        <button class="back-btn" onclick="window.location.href='/staff/home'">←</button>
        <h3>Teaching & Outreach</h3>
    </div>

    <div>
        {{ ucfirst(trim(session('name'))) }} <br>
        <span style="font-size:13px;opacity:0.85;">{{ session('position') }}</span>
    </div>
</div>

<!-- CONTENT -->
<div class="container">

    <div class="info">
        Please complete all teaching activities for the current appraisal year.
        Upload relevant evidence before submission.
    </div>

    <form method="POST" action="/staff/teaching/store" enctype="multipart/form-data">
        @csrf

        <!-- SECTION 1: TEACHING INFO -->
        <div class="card">
            <div class="section-title">Teaching Information</div>

            <div class="form-grid">
                <div>
                    <label>Academic Year</label>
                    <select name="academic_year">
                        <option>2026</option>
                        <option>2025</option>
                    </select>
                </div>

                <div>
                    <label>Semester</label>
                    <select name="semester">
                        <option>Semester 1</option>
                        <option>Semester 2</option>
                    </select>
                </div>

                <div>
                    <label>Course Code</label>
                    <input type="text" name="course_code">
                </div>

                <div>
                    <label>Course Name</label>
                    <input type="text" name="course_name">
                </div>

                <div>
                    <label>Programme Level</label>
                    <select name="level">
                        <option>Diploma</option>
                        <option>Degree</option>
                        <option>Postgraduate</option>
                    </select>
                </div>

                <div>
                    <label>Credit Hours</label>
                    <input type="number" name="credit_hours">
                </div>

                <div>
                    <label>Number of Students</label>
                    <input type="number" name="students">
                </div>

                <div>
                    <label>Teaching Mode</label>
                    <select name="mode">
                        <option>Lecture</option>
                        <option>Tutorial</option>
                        <option>Laboratory</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- SECTION 2: TEACHING LOAD -->
        <div class="card">
            <div class="section-title">Teaching Load / Outreach</div>

            <div class="form-grid">
                <div>
                    <label>Role</label>
                    <select name="role">
                        <option>Lecturer</option>
                        <option>Course Coordinator</option>
                        <option>Supervisor</option>
                    </select>
                </div>

                <div>
                    <label>Total Teaching Hours</label>
                    <input type="number" name="hours">
                </div>

                <div style="grid-column: 1 / -1;">
                    <label>Remarks (Optional)</label>
                    <textarea name="remarks" rows="3"></textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 3: EVIDENCE -->
        <div class="card">
            <div class="section-title">Supporting Evidence</div>

            <div class="form-grid">
                <div>
                    <label>Upload Evidence (PDF/Image)</label>
                    <input type="file" name="evidence">
                </div>

                <div>
                    <label>Evidence Description</label>
                    <input type="text" name="evidence_desc">
                </div>
            </div>
        </div>

        <!-- ACTIONS -->
        <div class="actions">
            <button type="submit" name="action" value="draft" class="btn btn-secondary">
                Save Draft
            </button>
            <button type="submit" name="action" value="submit" class="btn">
                Submit
            </button>
        </div>

    </form>

</div>

</body>
</html>
