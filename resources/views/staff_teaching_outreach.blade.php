<!DOCTYPE html>
<html>
<head>
    <title>Teaching & Outreach - Staff</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background: #f4f6f9;
            margin: 0;
        }
        .container {
            max-width: 700px;
            margin: 40px auto;
            background: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }
        h2 {
            color: #2980b9;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 15px;
        }
        select, textarea, input[type="file"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border-radius: 6px;
            border: 1px solid #ccc;
        }
        textarea {
            resize: vertical;
        }
        button {
            margin-top: 20px;
            padding: 12px;
            background: #2980b9;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Teaching & Outreach – KPI Entry</h2>

    <form method="POST" action="#">
        <!-- KPI ITEM -->
        <label>KPI Item</label>
        <select required>
            <option value="">-- Select KPI --</option>
            <option>Course Taught</option>
            <option>Student Evaluation (TEVAL)</option>
            <option>Workshop / Seminar</option>
            <option>Community Outreach</option>
        </select>

        <!-- DESCRIPTION -->
        <label>Activity Description</label>
        <textarea rows="4" placeholder="Describe your activity" required></textarea>

        <!-- EVIDENCE -->
        <label>Upload Evidence</label>
        <input type="file" required>

        <!-- SUBMIT -->
        <button type="submit">Submit KPI</button>
    </form>
</div>

</body>
</html>
