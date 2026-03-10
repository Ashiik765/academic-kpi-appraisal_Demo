<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submitted KPI List</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .header {
            margin-bottom: 2rem;
            text-align: center;
        }

        .header h1 {
            color: white;
            font-size: 2.5rem;
            font-weight: 600;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 0.5rem;
        }

        .header p {
            color: rgba(255, 255, 255, 0.9);
            font-size: 1.1rem;
        }

        .table-container {
            background: white;
            border-radius: 15px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            animation: slideIn 0.5s ease-out;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }

        th {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.85rem;
            letter-spacing: 0.5px;
            padding: 1.2rem 1rem;
            border: none;
        }

        td {
            padding: 1.2rem 1rem;
            border-bottom: 1px solid #eef2f6;
            color: #2d3748;
            font-size: 0.95rem;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background: #f7fafc;
            transition: background 0.3s ease;
        }

        .staff-name {
            font-weight: 600;
            color: #2d3748;
        }

        .staff-type {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 500;
        }

        .staff-type.perm {
            background: #c6f6d5;
            color: #22543d;
        }

        .staff-type.contract {
            background: #feebc8;
            color: #744210;
        }

        .staff-type.probation {
            background: #e9d8fd;
            color: #44337a;
        }

        .intake-info {
            background: #edf2f7;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            display: inline-block;
            font-size: 0.85rem;
            font-weight: 500;
            color: #4a5568;
        }

        .year {
            font-weight: 600;
            color: #4a5568;
        }

        .review-btn {
            display: inline-flex;
            align-items: center;
            padding: 0.6rem 1.2rem;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            box-shadow: 0 4px 6px rgba(102, 126, 234, 0.3);
        }

        .review-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 12px rgba(102, 126, 234, 0.4);
            background: linear-gradient(135deg, #5a6fd6 0%, #6a41a0 100%);
        }

        .review-btn i {
            margin-right: 0.5rem;
            font-style: normal;
            font-size: 1.1rem;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            background: white;
            border-radius: 15px;
        }

        .empty-state p {
            color: #718096;
            font-size: 1.1rem;
            margin-bottom: 1rem;
        }

        .empty-icon {
            font-size: 4rem;
            margin-bottom: 1rem;
            opacity: 0.5;
        }

        @media (max-width: 768px) {
            .table-container {
                overflow-x: auto;
            }
            
            table {
                min-width: 600px;
            }
            
            .header h1 {
                font-size: 2rem;
            }
        }

        /* Loading animation for table rows */
        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Badge for staff type */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📋 Submitted KPI List</h1>
            <p>Review and evaluate staff performance submissions</p>
        </div>

        @if($submissions->count() > 0)
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Staff Name</th>
                            <th>Staff Type</th>
                            <th>Intake</th>
                            <th>Year</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($submissions as $index => $submission)
                            <tr class="fade-in" style="animation-delay: {{ $index * 0.1 }}s">
                                <td>
                                    <span class="staff-name">{{ $submission->user->name }}</span>
                                </td>
                                <td>
                                    @php
                                        $staffType = strtolower($submission->user->staff_type ?? '');
                                        $badgeClass = match(true) {
                                            str_contains($staffType, 'permanent') => 'perm',
                                            str_contains($staffType, 'contract') => 'contract',
                                            str_contains($staffType, 'probation') => 'probation',
                                            default => 'perm'
                                        };
                                    @endphp
                                    <span class="badge staff-type {{ $badgeClass }}">
                                        {{ $submission->user->staff_type ?? 'Not Specified' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="intake-info">
                                        {{ $submission->user->intake_month ?? 'N/A' }} {{ $submission->user->intake_year ?? '' }}
                                    </span>
                                </td>
                                <td>
                                    <span class="year">{{ $submission->year }}</span>
                                </td>
                                <td>
                                    <a href="{{ route('appraiser.kpi.show', $submission->id) }}" class="review-btn">
                                        <i>👁️</i>
                                        Review
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class='table-summary' style="margin-top: 1.5rem; text-align: right; color: white;">
                <span style="background: rgba(255, 255, 255, 0.2); padding: 0.5rem 1rem; border-radius: 50px;">
                    Total Submissions: {{ $submissions->count() }}
                </span>
            
            <!-- Optional: Add summary/statistics -->
            </div>
            
        @else
            <div class="empty-state">
                <div class="empty-icon">📭</div>
                <p>No KPI submissions found</p>
                <p style="font-size: 0.9rem; color: #a0aec0;">Submissions will appear here once staff members submit their KPIs</p>
            </div>
        @endif

        
    </div>
</body>
</html>