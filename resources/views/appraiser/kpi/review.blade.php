@extends('appraiser.appraiser_home')

@section('content')
<div class="review-container">
    <!-- Header Section -->
    <div class="page-header">
        <div class="header-top">
            <h2 class="page-title">
                <span class="title-icon">📋</span>
                Review KPI Submission
            </h2>
            <span class="status-badge">Pending Review</span>
        </div>
        
        <div class="staff-profile-card">
            <div class="profile-avatar">
                {{ substr($submission->user->name, 0, 1) }}
            </div>
            <div class="profile-info">
                <h3>{{ $submission->user->name }}</h3>
                <div class="info-badges">
                    <span class="badge staff-type">{{ $submission->user->staff_type }}</span>
                    <span class="badge year-badge">Year {{ $submission->year }}</span>
                </div>
            </div>
            <div class="profile-stats">
                <div class="stat-item">
                    <span class="stat-label">Intake</span>
                    <span class="stat-value">{{ $submission->user->intake_month ?? 'N/A' }} {{ $submission->user->intake_year ?? '' }}</span>
                </div>
                <div class="stat-item">
                    <span class="stat-label">Total KPIs</span>
                    <span class="stat-value">{{ count($items) }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Stats -->
    @php
        $totalWeight = $items->sum('weightage');
        $avgSelfScore = $items->count() > 0 ? round($items->sum('self_score') / $items->count(), 1) : 0;
        $scored = $items->whereNotNull('appraiser_score')->count();
        $progress = $items->count() > 0 ? round(($scored / $items->count()) * 100) : 0;
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">⚖️</div>
            <div class="stat-content">
                <span class="stat-name">Total Weightage</span>
                <span class="stat-number">{{ $totalWeight }}%</span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ min(100, $totalWeight) }}%"></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <span class="stat-name">Average Self Score</span>
                <span class="stat-number">{{ $avgSelfScore }}/10</span>
                <div class="mini-chart">
                    <div class="chart-bar" style="height: {{ $avgSelfScore * 10 }}%"></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-content">
                <span class="stat-name">Review Progress</span>
                <span class="stat-number">{{ $scored }}/{{ count($items) }}</span>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $progress }}%"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- Review Form -->
    <div class="review-form">
        <form method="POST" action="{{ route('appraiser.kpi.submitReview', $submission->id) }}">
            @csrf
            
            <div class="table-wrapper">
                <table class="review-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>Criteria</th>
                            <th class="text-center">Weight</th>
                            <th class="text-center">Self Score</th>
                            <th class="text-center">Evidence</th>
                            <th class="text-center">Appraiser Score</th>
                            <th>Comment</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $index => $item)
                        <tr class="review-item">
                            <td>
                                <span class="category-tag">{{ $item->kpi->category }}</span>
                            </td>
                            <td>
                                <div class="criteria-text">{{ $item->kpi->criteria }}</div>
                            </td>
                            <td class="text-center">
                                <span class="weight-badge">{{ $item->kpi->weightage }}%</span>
                            </td>
                            <td class="text-center">
                                <span class="score self-score">{{ $item->self_score }}</span>
                            </td>
                            {{-- <td class="text-center">
                                <span class="score staff-total">{{ $item->staff_total }}</span>
                            </td> --}}
                            <td class="text-center">
                                @if($item->evidence)
                                    <a href="{{ asset('storage/'.$item->evidence) }}" 
                                       target="_blank" 
                                       class="evidence-link">
                                        <span class="link-icon">📎</span>
                                        View
                                    </a>
                                @else
                                    <span class="no-evidence">—</span>
                                @endif
                            </td>
                            <td>
                                <input type="number"
                                       name="appraiser_score[{{ $item->id }}]"
                                       value="{{ old('appraiser_score.'.$item->id, $item->appraiser_score) }}"
                                       min="0"
                                       max="5"
                                       step="0.5"
                                       class="score-input"
                                       placeholder="0-5"
                                       required>
                            </td>
                            <td>
                                <input type="text"
                                       name="comment[{{ $item->id }}]"
                                       value="{{ old('comment.'.$item->id, $item->comment) }}"
                                       class="comment-input"
                                       placeholder="Add feedback...">
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Form Actions -->
            <div class="form-footer">
                <div class="footer-left">
                    <span class="items-info">
                        <span class="info-dot"></span>
                        {{ count($items) }} KPI items to review
                    </span>
                </div>
                <div class="footer-right">
                    
                    <button type="submit" class="btn btn-primary">
                        <span class="btn-icon">✓</span>
                        Submit Review
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Main Container */
.review-container {
    padding: 1.5rem;
    max-width: 1400px;
    margin: 0 auto;
}

/* Page Header */
.page-header {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    margin-bottom: 1.5rem;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
    border: 1px solid #edf2f7;
}

.header-top {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
}

.page-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #1e293b;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0;
}

.title-icon {
    font-size: 1.8rem;
}

.status-badge {
    background: #fef3c7;
    color: #92400e;
    padding: 0.4rem 1rem;
    border-radius: 50px;
    font-size: 0.85rem;
    font-weight: 600;
    letter-spacing: 0.3px;
}

/* Staff Profile Card */
.staff-profile-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
    background: #f8fafc;
    padding: 1.2rem 1.5rem;
    border-radius: 16px;
}

.profile-avatar {
    width: 60px;
    height: 60px;
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.8rem;
    font-weight: 600;
    color: white;
    text-transform: uppercase;
}

.profile-info {
    flex: 1;
}

.profile-info h3 {
    font-size: 1.2rem;
    font-weight: 600;
    color: #1e293b;
    margin: 0 0 0.5rem 0;
}

.info-badges {
    display: flex;
    gap: 0.5rem;
}

.badge {
    padding: 0.3rem 0.8rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
}

.badge.staff-type {
    background: #dbeafe;
    color: #1e40af;
}

.badge.year-badge {
    background: #e0e7ff;
    color: #3730a3;
}

.profile-stats {
    display: flex;
    gap: 1.5rem;
}

.stat-item {
    text-align: right;
}

.stat-label {
    display: block;
    font-size: 0.7rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
}

.stat-value {
    font-size: 1rem;
    font-weight: 600;
    color: #1e293b;
}

/* Stats Grid */
.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1rem;
    margin-bottom: 1.5rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 1.2rem;
    display: flex;
    align-items: center;
    gap: 1rem;
    border: 1px solid #edf2f7;
    transition: all 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(0, 0, 0, 0.05);
    border-color: #cbd5e1;
}

.stat-icon {
    width: 48px;
    height: 48px;
    background: #f1f5f9;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
}

.stat-content {
    flex: 1;
}

.stat-name {
    display: block;
    font-size: 0.75rem;
    color: #64748b;
    text-transform: uppercase;
    letter-spacing: 0.3px;
    margin-bottom: 0.2rem;
}

.stat-number {
    display: block;
    font-size: 1.3rem;
    font-weight: 700;
    color: #1e293b;
    line-height: 1.2;
}

.progress-bar {
    width: 100%;
    height: 6px;
    background: #e2e8f0;
    border-radius: 3px;
    margin-top: 0.5rem;
    overflow: hidden;
}

.progress-fill {
    height: 100%;
    background: linear-gradient(90deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 3px;
    transition: width 0.3s ease;
}

.mini-chart {
    width: 100%;
    height: 30px;
    display: flex;
    align-items: flex-end;
    margin-top: 0.3rem;
}

.chart-bar {
    width: 100%;
    background: linear-gradient(180deg, #3b82f6 0%, #8b5cf6 100%);
    border-radius: 4px 4px 0 0;
    transition: height 0.3s ease;
}

/* Review Form */
.review-form {
    background: white;
    border-radius: 20px;
    padding: 1.5rem;
    border: 1px solid #edf2f7;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
}

/* Table Wrapper */
.table-wrapper {
    overflow-x: auto;
    border-radius: 14px;
    border: 1px solid #edf2f7;
    margin-bottom: 1.5rem;
}

/* Review Table */
.review-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 1000px;
}

.review-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
    font-size: 0.75rem;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 1rem 0.8rem;
    border-bottom: 2px solid #e2e8f0;
    white-space: nowrap;
}

.review-table td {
    padding: 1rem 0.8rem;
    border-bottom: 1px solid #edf2f7;
    color: #334155;
    font-size: 0.9rem;
    vertical-align: middle;
}

.review-table tr:last-child td {
    border-bottom: none;
}

.review-table tr:hover td {
    background: #fafbfc;
}

/* Category Tag */
.category-tag {
    background: #f1f5f9;
    color: #475569;
    padding: 0.3rem 0.8rem;
    border-radius: 50px;
    font-size: 0.8rem;
    font-weight: 500;
    display: inline-block;
    white-space: nowrap;
}

/* Criteria Text */
.criteria-text {
    max-width: 250px;
    line-height: 1.4;
    font-size: 0.9rem;
}

/* Weight Badge */
.weight-badge {
    background: #f1f5f9;
    color: #475569;
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 600;
    white-space: nowrap;
}

/* Score Styles */
.score {
    display: inline-block;
    padding: 0.3rem 0.6rem;
    border-radius: 6px;
    font-weight: 600;
    min-width: 45px;
    text-align: center;
}

.score.self-score {
    background: #dbeafe;
    color: #1e40af;
}

.score.staff-total {
    background: #dcfce7;
    color: #166534;
}

/* Evidence Link */
.evidence-link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    padding: 0.4rem 0.8rem;
    background: #f1f5f9;
    color: #475569;
    text-decoration: none;
    border-radius: 6px;
    font-size: 0.8rem;
    font-weight: 500;
    transition: all 0.2s ease;
}

.evidence-link:hover {
    background: #e2e8f0;
    color: #1e293b;
}

.link-icon {
    font-style: normal;
    line-height: 1;
}

.no-evidence {
    color: #94a3b8;
    font-size: 0.9rem;
}

/* Input Fields */
.score-input {
    width: 80px;
    padding: 0.5rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    font-weight: 500;
    text-align: center;
    transition: all 0.2s ease;
}

.score-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

.comment-input {
    width: 200px;
    padding: 0.5rem 0.8rem;
    border: 2px solid #e2e8f0;
    border-radius: 8px;
    font-size: 0.9rem;
    transition: all 0.2s ease;
}

.comment-input:focus {
    outline: none;
    border-color: #3b82f6;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
}

/* Form Footer */
.form-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding-top: 1.5rem;
    border-top: 2px solid #edf2f7;
}

.footer-left {
    color: #64748b;
    font-size: 0.9rem;
}

.items-info {
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.info-dot {
    width: 8px;
    height: 8px;
    background: #3b82f6;
    border-radius: 50%;
    display: inline-block;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.footer-right {
    display: flex;
    gap: 0.8rem;
}

/* Buttons */
.btn {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.7rem 1.4rem;
    border-radius: 10px;
    font-size: 0.95rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s ease;
    border: none;
    text-decoration: none;
}

.btn-primary {
    background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%);
    color: white;
    box-shadow: 0 4px 6px rgba(59, 130, 246, 0.2);
}

.btn-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 6px 10px rgba(59, 130, 246, 0.3);
}

.btn-secondary {
    background: white;
    color: #475569;
    border: 2px solid #e2e8f0;
}

.btn-secondary:hover {
    background: #f8fafc;
    border-color: #cbd5e1;
}

.btn-icon {
    font-style: normal;
    line-height: 1;
}

/* Text alignment */
.text-center {
    text-align: center;
}

/* Responsive */
@media (max-width: 768px) {
    .review-container {
        padding: 1rem;
    }
    
    .header-top {
        flex-direction: column;
        gap: 1rem;
        align-items: start;
    }
    
    .staff-profile-card {
        flex-direction: column;
        align-items: start;
    }
    
    .profile-stats {
        width: 100%;
        justify-content: space-between;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .form-footer {
        flex-direction: column;
        gap: 1rem;
        align-items: stretch;
    }
    
    .footer-right {
        flex-direction: column;
    }
    
    .btn {
        justify-content: center;
    }
}
</style>

<!-- Optional: Add JavaScript for auto-calculation -->
@push('scripts')
<script>
    // Calculate running total (optional)
    document.addEventListener('DOMContentLoaded', function() {
        const scoreInputs = document.querySelectorAll('.score-input');
        
        scoreInputs.forEach(input => {
            input.addEventListener('input', function() {
                // Add any real-time validation or calculation here
                if (this.value > 10) this.value = 10;
                if (this.value < 0) this.value = 0;
            });
        });
    });
</script>
@endpush
@endsection