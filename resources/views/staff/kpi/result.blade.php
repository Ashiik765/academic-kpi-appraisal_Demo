@extends('staff.staff_home')

@section('content')

<div class="kpi-container">
    <div class="kpi-header">
        <h2 class="kpi-title">KPI Evaluation Result</h2>
        <a href="{{ route('staff.kpi.print') }}" target="_blank" class="print-btn">
            <span class="btn-icon">🖨️</span>
            Print Result
        </a>
    </div>

    <div class="table-responsive">
        <table class="kpi-table">
            <thead>
                <tr>
                    <th>Category</th>
                    <th>Criteria</th>
                    <th>Weight</th>
                    <th>Self Score</th>
                    <th>Appraiser Score</th>
                    <th>Final Score</th>
                    <th>Comment</th>
                </tr>
            </thead>
            <tbody>
                @php
                $total = 0;
                @endphp

                @foreach($items as $item)
                @php
                $weight = $item->kpi->weightage;
                $score = $item->appraiser_score ?? 0;
                $final = $weight * $score;
                $total += $final;
                
                // Determine score status class
                $statusClass = '';
                if ($score >= 4) {
                    $statusClass = 'score-excellent';
                } elseif ($score >= 3) {
                    $statusClass = 'score-good';
                } elseif ($score >= 2) {
                    $statusClass = 'score-average';
                } else {
                    $statusClass = 'score-needs-improvement';
                }
                @endphp

                <tr>
                    <td class="category-cell">{{ $item->kpi->category }}</td>
                    <td class="criteria-cell">{{ $item->kpi->criteria }}</td>
                    <td class="weight-cell">{{ number_format($weight, 2) }}</td>
                    <td class="self-score-cell">{{ $item->self_score }}</td>
                    <td class="appraiser-score-cell">
                        <span class="{{ $statusClass }}">{{ $score }}</span>
                    </td>
                    <td class="final-score-cell">{{ number_format($final, 2) }}</td>
                    <td class="comment-cell">{{ $item->comment ?? '—' }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="5" class="total-label">Total KPI Score</td>
                    <td class="total-value">{{ number_format($total, 2) }}</td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<style>
.kpi-container {
    width: 100%;
    margin: 0;
    padding: 20px;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, sans-serif;
    background-color: #f5f7fa;
    min-height: 100vh;
}

.kpi-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 25px;
    padding: 0 5px;
    max-width: 100%;
}

.kpi-title {
    color: #2c3e50;
    font-size: 1.8em;
    font-weight: 600;
    margin: 0;
    position: relative;
    padding-bottom: 10px;
}

.kpi-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 60px;
    height: 3px;
    background: linear-gradient(90deg, #3498db, #2ecc71);
    border-radius: 2px;
}

.print-btn {
    display: inline-flex;
    align-items: center;
    padding: 10px 20px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    border-radius: 50px;
    text-decoration: none;
    font-weight: 500;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    border: none;
    cursor: pointer;
}

.print-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    background: linear-gradient(135deg, #2980b9, #2573a7);
}

.btn-icon {
    margin-right: 8px;
    font-size: 1.1em;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    background-color: white;
}

.kpi-table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    font-size: 0.95em;
    table-layout: auto;
}

/* Column width distributions */
.kpi-table th:nth-child(1) { width: 12%; }  /* Category */
.kpi-table th:nth-child(2) { width: 25%; }  /* Criteria */
.kpi-table th:nth-child(3) { width: 8%; }   /* Weight */
.kpi-table th:nth-child(4) { width: 10%; }  /* Self Score */
.kpi-table th:nth-child(5) { width: 12%; }  /* Appraiser Score */
.kpi-table th:nth-child(6) { width: 10%; }  /* Final Score */
.kpi-table th:nth-child(7) { width: 23%; }  /* Comment */

.kpi-table thead tr {
    background: linear-gradient(135deg, #667eea, #764ba2);
    color: white;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-size: 0.9em;
}

.kpi-table th {
    padding: 15px 12px;
    text-align: left;
    font-weight: 600;
    white-space: nowrap;
}

.kpi-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #eef2f7;
    vertical-align: middle;
}

.kpi-table tbody tr {
    transition: background-color 0.2s ease;
}

.kpi-table tbody tr:hover {
    background-color: #f8fafc;
}

.kpi-table tbody tr:last-child td {
    border-bottom: none;
}

.category-cell {
    font-weight: 500;
    color: #34495e;
    background-color: #fafbfc;
    white-space: nowrap;
}

.criteria-cell {
    color: #2c3e50;
    font-weight: 500;
}

.weight-cell {
    font-weight: 600;
    color: #7f8c8d;
    text-align: center;
    background-color: #f8f9fa;
}

.self-score-cell {
    text-align: center;
    font-weight: 600;
    color: #3498db;
    background-color: #ebf5ff;
    border-radius: 4px;
}

.appraiser-score-cell {
    text-align: center;
    font-weight: 600;
}

.appraiser-score-cell span {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 20px;
    min-width: 45px;
    text-align: center;
    font-weight: 600;
    font-size: 0.95em;
}

.final-score-cell {
    text-align: center;
    font-weight: 600;
    color: #27ae60;
    background-color: #f0fff4;
}

.comment-cell {
    color: #4a5568;
    max-width: 300px;
    white-space: normal;
    word-wrap: break-word;
    line-height: 1.4;
}

.score-excellent {
    background-color: #27ae60;
    color: white;
}

.score-good {
    background-color: #f39c12;
    color: white;
}

.score-average {
    background-color: #e67e22;
    color: white;
}

.score-needs-improvement {
    background-color: #e74c3c;
    color: white;
}

.total-row {
    background: linear-gradient(135deg, #f8fafc, #f1f5f9);
    border-top: 2px solid #e2e8f0;
    font-weight: 600;
}

.total-label {
    text-align: right;
    font-size: 1.1em;
    color: #1e293b;
    padding: 16px 12px;
    font-weight: 600;
}

.total-value {
    text-align: center;
    font-size: 1.2em;
    color: #059669;
    font-weight: 700;
    background: linear-gradient(135deg, #d1fae5, #a7f3d0);
    border-radius: 6px;
    padding: 12px !important;
}

/* Responsive adjustments */
@media (max-width: 1024px) {
    .kpi-table th:nth-child(1) { width: 10%; }
    .kpi-table th:nth-child(2) { width: 20%; }
    .kpi-table th:nth-child(3) { width: 8%; }
    .kpi-table th:nth-child(4) { width: 10%; }
    .kpi-table th:nth-child(5) { width: 12%; }
    .kpi-table th:nth-child(6) { width: 10%; }
    .kpi-table th:nth-child(7) { width: 30%; }
}

@media (max-width: 768px) {
    .kpi-container {
        padding: 10px;
    }
    
    .kpi-header {
        flex-direction: column;
        gap: 15px;
        text-align: center;
    }
    
    .kpi-title::after {
        left: 50%;
        transform: translateX(-50%);
    }
    
    .kpi-table {
        font-size: 0.85em;
    }
    
    .kpi-table td, .kpi-table th {
        padding: 12px 8px;
    }
    
    .appraiser-score-cell span {
        padding: 4px 8px;
        min-width: 35px;
        font-size: 0.85em;
    }
}

/* Remove animations for cleaner look */
.kpi-table tbody tr {
    animation: none;
}

/* Better visual hierarchy */
.kpi-table th {
    position: sticky;
    top: 0;
    z-index: 10;
}

/* Subtle zebra striping */
.kpi-table tbody tr:nth-child(even) {
    background-color: #fafbfc;
}

.kpi-table tbody tr:nth-child(even):hover {
    background-color: #f1f5f9;
}

/* Better empty state */
.comment-cell:empty::before,
.comment-cell:contains("")::before {
    content: '—';
    color: #94a3b8;
    font-style: normal;
}
</style>

@endsection