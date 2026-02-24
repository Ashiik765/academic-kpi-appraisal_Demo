@extends('staff.staff_home')

@section('content')

<style>
.kpi-container {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 40px rgba(0,0,0,0.1);
    margin: 20px 0;
}

.kpi-header {
    background: white;
    padding: 25px;
    border-radius: 15px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
}

.kpi-header h2 {
    margin: 0;
    color: #333;
    font-size: 24px;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 10px;
}

.kpi-header h2:before {
    content: '📊';
    font-size: 28px;
}

.table-container {
    background: white;
    border-radius: 15px;
    padding: 20px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.08);
    overflow-x: auto;
}

.kpi-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0 8px;
}

.kpi-table th {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 15px;
    font-size: 14px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    border-radius: 10px 10px 0 0;
}

.kpi-table td {
    padding: 15px;
    background: #f8f9fa;
    border-radius: 10px;
    font-size: 14px;
    transition: all 0.3s ease;
}

.kpi-table tr:hover td {
    background: #f0f2f5;
    transform: translateY(-2px);
    box-shadow: 0 5px 10px rgba(0,0,0,0.05);
}

.kpi-table input[type="number"],
.kpi-table input[type="file"] {
    width: 100%;
    padding: 10px 12px;
    border-radius: 8px;
    border: 2px solid #e0e0e0;
    font-size: 14px;
    transition: all 0.3s ease;
    background: white;
}

.kpi-table input[type="number"]:focus,
.kpi-table input[type="file"]:focus {
    border-color: #667eea;
    outline: none;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.kpi-table input[type="number"] {
    max-width: 100px;
}

.kpi-table input.error {
    border-color: #dc3545;
    background-color: #fff5f5;
    animation: shake 0.5s;
}

@keyframes shake {
    0%, 100% { transform: translateX(0); }
    10%, 30%, 50%, 70%, 90% { transform: translateX(-2px); }
    20%, 40%, 60%, 80% { transform: translateX(2px); }
}

.badge {
    padding: 6px 12px;
    border-radius: 30px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    animation: fadeIn 0.3s ease;
}

@keyframes fadeIn {
    from { opacity: 0; transform: scale(0.9); }
    to { opacity: 1; transform: scale(1); }
}

.badge-approved { 
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    color: #1e7e34; 
    box-shadow: 0 2px 5px rgba(132, 250, 176, 0.3);
}

.badge-rejected { 
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
    color: #dc3545; 
    box-shadow: 0 2px 5px rgba(240, 147, 251, 0.3);
}

.badge-pending { 
    background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
    color: #d97706; 
    box-shadow: 0 2px 5px rgba(246, 211, 101, 0.3);
}

.badge-draft { 
    background: linear-gradient(135deg, #e0e0e0 0%, #bdbdbd 100%);
    color: #6b7280; 
    box-shadow: 0 2px 5px rgba(176, 176, 176, 0.3);
}

.btn-submit {
    margin-top: 25px;
    padding: 14px 28px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    border: none;
    border-radius: 50px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 0.5px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-submit:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(102, 126, 234, 0.5);
}

.btn-submit:before {
    content: '📤';
    font-size: 18px;
}

/* Modal Styles */
.modal-overlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: rgba(0, 0, 0, 0.5);
    backdrop-filter: blur(5px);
    z-index: 1000;
    animation: fadeInOverlay 0.3s ease;
}

@keyframes fadeInOverlay {
    from { opacity: 0; }
    to { opacity: 1; }
}

.modal-content {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 30px;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.3);
    z-index: 1001;
    min-width: 350px;
    max-width: 450px;
    animation: slideIn 0.3s ease;
}

@keyframes slideIn {
    from { transform: translate(-50%, -40%); opacity: 0; }
    to { transform: translate(-50%, -50%); opacity: 1; }
}

.modal-header {
    display: flex;
    align-items: center;
    gap: 15px;
    margin-bottom: 20px;
}

.modal-icon {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
}

.modal-icon.error {
    background: #fee2e2;
    color: #dc2626;
}

.modal-icon.warning {
    background: #fef3c7;
    color: #d97706;
}

.modal-icon.success {
    background: #dcfce7;
    color: #16a34a;
}

.modal-title {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin: 0;
}

.modal-body {
    margin-bottom: 25px;
    color: #666;
    line-height: 1.6;
}

.modal-body ul {
    margin: 10px 0;
    padding-left: 25px;
}

.modal-body li {
    margin: 5px 0;
    color: #dc2626;
}

.modal-footer {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
}

.modal-btn {
    padding: 10px 20px;
    border-radius: 8px;
    border: none;
    cursor: pointer;
    font-weight: 600;
    transition: all 0.3s ease;
}

.modal-btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
}

.modal-btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
}

.modal-btn-secondary {
    background: #e5e7eb;
    color: #4b5563;
}

.modal-btn-secondary:hover {
    background: #d1d5db;
}

/* Score hint */
.score-hint {
    font-size: 11px;
    color: #6b7280;
    margin-top: 4px;
}

/* Success message */
.success-message {
    background: linear-gradient(135deg, #84fab0 0%, #8fd3f4 100%);
    color: #1e7e34;
    padding: 15px 20px;
    border-radius: 10px;
    margin-bottom: 20px;
    display: flex;
    align-items: center;
    gap: 10px;
    animation: slideDown 0.3s ease;
}

@keyframes slideDown {
    from { transform: translateY(-20px); opacity: 0; }
    to { transform: translateY(0); opacity: 1; }
}

.success-message:before {
    content: '✅';
    font-size: 18px;
}

/* Weightage info */
.weightage-info {
    background: #f0f2f5;
    padding: 15px;
    border-radius: 10px;
    margin-top: 20px;
    font-size: 13px;
    color: #666;
    display: flex;
    align-items: center;
    gap: 10px;
}

.weightage-info:before {
    content: 'ℹ️';
    font-size: 16px;
}

/* Responsive */
@media (max-width: 768px) {
    .kpi-container {
        padding: 15px;
    }
    
    .kpi-table td, .kpi-table th {
        padding: 10px;
    }
    
    .modal-content {
        min-width: 300px;
        margin: 0 15px;
    }
}
</style>

<div class="kpi-container">

    <div class="kpi-header">
        <h2>{{ ucfirst($category) }} Dimension Entry</h2>
    </div>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="table-container">
        <form method="POST" action="/staff/kpi/save" enctype="multipart/form-data" id="kpiForm">
            @csrf

            <input type="hidden" name="submission_id" value="{{ $submission->id }}">
            <input type="hidden" name="category" value="{{ $category }}">
            <input type="hidden" name="action" id="formAction" value="save">

            <table class="kpi-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Criteria</th>
                        <th>Weightage</th>
                        <th>Self Score (0-5)</th>
                        <th>Evidence</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($kpis as $kpi)
                    @php
                        $item = $submissionItems[$kpi->id] ?? null;
                        $status = $item->status ?? 'draft';
                        $hasScore = isset($item->self_score) && $item->self_score !== '' && $item->self_score !== null;
                        $hasEvidence = isset($item->evidence_path) && !empty($item->evidence_path);
                    @endphp

                    <tr data-kpi-id="{{ $kpi->id }}" data-status="{{ $status }}">
                        <td><strong>#{{ $loop->iteration }}</strong></td>
                        <td>{{ $kpi->criteria }}</td>
                        <td><strong>{{ $kpi->weightage }}</strong></td>

                        <td class="score-cell">
                            @if($status == 'approved' || $status == 'submitted')
                                <span class="badge badge-{{ $status }}">{{ $item->self_score ?? 'Not set' }}</span>
                            @else
                                <input type="number"
                                       class="self-score-input"
                                       name="self_score[{{ $kpi->id }}]"
                                       min="0"
                                       max="5"
                                       step="0.5"
                                       value="{{ $item->self_score ?? '' }}"
                                       data-kpi-id="{{ $kpi->id }}"
                                       data-required="true"
                                       placeholder="0-5"
                                       onchange="validateField(this)">
                                <div class="score-hint">Min: 0, Max: 5 (in 0.5 steps)</div>
                            @endif
                        </td>

                        <td class="evidence-cell">
                            @if($status == 'approved')
                                <span class="badge badge-approved">✓ Evidence Uploaded</span>
                            @elseif($status == 'submitted')
                                <span class="badge badge-pending">⏳ Pending Review</span>
                            @else
                                <input type="file" 
                                       class="evidence-input" 
                                       name="evidence[{{ $kpi->id }}]"
                                       data-kpi-id="{{ $kpi->id }}"
                                       data-required="true"
                                       onchange="validateField(this)"
                                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.xls,.xlsx,.ppt,.pptx">
                                @if(isset($item->evidence_path) && !empty($item->evidence_path))
                                    <div style="font-size: 12px; margin-top: 5px; color: #059669;">
                                        <small>📎 Current: {{ basename($item->evidence_path) }}</small>
                                    </div>
                                @endif
                            @endif
                        </td>

                        <td>
                            @if($status == 'approved')
                                <span class="badge badge-approved">✅ Approved</span>
                            @elseif($status == 'submitted')
                                <span class="badge badge-pending">⏳ Pending</span>
                            @elseif($status == 'rejected')
                                <span class="badge badge-rejected">❌ Rejected</span>
                            @else
                                <span class="badge badge-draft">📝 Draft</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="weightage-info">
                <strong>Note:</strong> Self score must be between 0 and 5 (in increments of 0.5). The weightage shown is for calculation purposes only.
            </div>

            <button type="button" class="btn-submit" onclick="validateAndSubmit()">
                Submit Dimension for Review
            </button>

        </form>
    </div>
</div>

<!-- Modal Overlay -->
<div id="modalOverlay" class="modal-overlay"></div>

<!-- Error Modal -->
<div id="errorModal" class="modal-content" style="display: none;">
    <div class="modal-header">
        <div class="modal-icon error">⚠️</div>
        <h3 class="modal-title">Validation Error</h3>
    </div>
    <div class="modal-body" id="errorModalBody">
        Please fix the following issues:
        <ul id="errorList"></ul>
    </div>
    <div class="modal-footer">
        <button class="modal-btn modal-btn-primary" onclick="closeErrorModal()">Got It</button>
    </div>
</div>

<!-- Success Modal -->
<div id="successModal" class="modal-content" style="display: none;">
    <div class="modal-header">
        <div class="modal-icon success">✅</div>
        <h3 class="modal-title">Success!</h3>
    </div>
    <div class="modal-body" id="successModalBody">
        Your dimension has been submitted successfully for review.
    </div>
    <div class="modal-footer">
        <button class="modal-btn modal-btn-primary" onclick="proceedAfterSuccess()">Continue</button>
    </div>
</div>

<!-- Confirmation Modal -->
<div id="confirmModal" class="modal-content" style="display: none;">
    <div class="modal-header">
        <div class="modal-icon warning">📤</div>
        <h3 class="modal-title">Confirm Submission</h3>
    </div>
    <div class="modal-body">
        Are you sure you want to submit this dimension? You won't be able to make changes after submission.
    </div>
    <div class="modal-footer">
        <button class="modal-btn modal-btn-secondary" onclick="closeConfirmModal()">Cancel</button>
        <button class="modal-btn modal-btn-primary" onclick="proceedWithSubmission()">Yes, Submit</button>
    </div>
</div>

<script>
let isValidForSubmission = false;

function validateField(field) {
    field.classList.remove('error');
    if (field.classList.contains('self-score-input')) {
        let value = parseFloat(field.value);
        if (value < 0 || value > 5 || value % 0.5 !== 0) {
            field.classList.add('error');
        }
    }
}

function validateAndSubmit() {
    let errors = [];
    let hasErrors = false;
    
    // Clear all previous error styling
    document.querySelectorAll('.self-score-input, .evidence-input').forEach(field => {
        field.classList.remove('error');
    });
    
    // Get all rows
    const rows = document.querySelectorAll('tr[data-kpi-id]');
    
    rows.forEach(row => {
        const status = row.getAttribute('data-status');
        
        // Skip validation if already approved, pending, or rejected
        if (status === 'approved' || status === 'submitted' || status === 'rejected') {
            return;
        }
        
        const kpiId = row.getAttribute('data-kpi-id');
        const criteriaText = row.querySelector('td:nth-child(2)').textContent.trim();
        const scoreInput = row.querySelector('.self-score-input');
        const evidenceInput = row.querySelector('.evidence-input');
        const hasExistingEvidence = row.querySelector('.evidence-cell small') !== null;
        
        // Check self score
        if (!scoreInput || !scoreInput.value || scoreInput.value === '') {
            errors.push(`Self score missing for: "${criteriaText.substring(0, 50)}..."`);
            if (scoreInput) scoreInput.classList.add('error');
            hasErrors = true;
        } else {
            let score = parseFloat(scoreInput.value);
            if (isNaN(score) || score < 0 || score > 5) {
                errors.push(`Self score must be between 0 and 5 for: "${criteriaText.substring(0, 50)}..."`);
                scoreInput.classList.add('error');
                hasErrors = true;
            } else if (score % 0.5 !== 0) {
                errors.push(`Self score must be in increments of 0.5 for: "${criteriaText.substring(0, 50)}..."`);
                scoreInput.classList.add('error');
                hasErrors = true;
            }
        }
        
        // Check evidence (only if no existing evidence)
        if (!hasExistingEvidence && (!evidenceInput || !evidenceInput.files || evidenceInput.files.length === 0)) {
            errors.push(`Evidence file missing for: "${criteriaText.substring(0, 50)}..."`);
            if (evidenceInput) {
                evidenceInput.classList.add('error');
                hasErrors = true;
            }
        }
    });
    
    if (hasErrors) {
        // Show error modal with list of errors
        const errorList = document.getElementById('errorList');
        errorList.innerHTML = '';
        errors.forEach(error => {
            const li = document.createElement('li');
            li.textContent = error;
            errorList.appendChild(li);
        });
        
        document.getElementById('errorModal').style.display = 'block';
        document.getElementById('modalOverlay').style.display = 'block';
        return false;
    }
    
    // Show confirmation modal
    document.getElementById('confirmModal').style.display = 'block';
    document.getElementById('modalOverlay').style.display = 'block';
}

function closeErrorModal() {
    document.getElementById('errorModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
}

function closeConfirmModal() {
    document.getElementById('confirmModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
}

function proceedWithSubmission() {
    closeConfirmModal();
    
    // Set form action to submit
    document.getElementById('formAction').value = 'submit';
    
    // Show loading state
    const submitBtn = document.querySelector('.btn-submit');
    const originalText = submitBtn.innerHTML;
    submitBtn.innerHTML = '⏳ Submitting...';
    submitBtn.disabled = true;
    
    // Submit the form
    document.getElementById('kpiForm').submit();
}

function proceedAfterSuccess() {
    document.getElementById('successModal').style.display = 'none';
    document.getElementById('modalOverlay').style.display = 'none';
    window.location.reload();
}

// Close modal when clicking overlay
document.getElementById('modalOverlay').addEventListener('click', function() {
    document.getElementById('errorModal').style.display = 'none';
    document.getElementById('successModal').style.display = 'none';
    document.getElementById('confirmModal').style.display = 'none';
    this.style.display = 'none';
});

// Real-time validation on input change
document.querySelectorAll('.self-score-input').forEach(input => {
    input.addEventListener('input', function() {
        let value = parseFloat(this.value);
        if (!isNaN(value) && value >= 0 && value <= 5 && value % 0.5 === 0) {
            this.classList.remove('error');
        }
    });
});

document.querySelectorAll('.evidence-input').forEach(input => {
    input.addEventListener('change', function() {
        if (this.files && this.files.length > 0) {
            this.classList.remove('error');
        }
    });
});

// Prevent form submission on enter key
document.getElementById('kpiForm').addEventListener('keypress', function(e) {
    if (e.key === 'Enter') {
        e.preventDefault();
        return false;
    }
});

// Show success modal if just submitted
@if(session('success'))
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('successModalBody').textContent = "{{ session('success') }}";
        document.getElementById('successModal').style.display = 'block';
        document.getElementById('modalOverlay').style.display = 'block';
    });
@endif
</script>

@endsection