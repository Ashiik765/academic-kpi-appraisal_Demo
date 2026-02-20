@extends('staff.staff_home')

@section('content')

@php use Illuminate\Support\Str; @endphp

<style>
body { 
    font-family: 'Segoe UI', sans-serif; 
    background: #f1f5f9;
}

/* ===== HEADER SECTION ===== */
.page-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.page-title {
    font-size: 22px;
    font-weight: 600;
}

/* ===== STATUS BADGE ===== */
.status-badge {
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 13px;
    font-weight: 600;
    text-transform: uppercase;
}

.status-draft { background: #dcfce7; color: #166534; }
.status-submitted { background: #fee2e2; color: #991b1b; }
.status-approved { background: #dbeafe; color: #1e40af; }

/* ===== ACTION BUTTONS ===== */
.action-buttons {
    display: flex;
    gap: 10px;
}

.save-btn, .submit-btn {
    padding: 10px 18px;
    border: none;
    border-radius: 8px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s ease;
}

.save-btn {
    background: linear-gradient(135deg, #22c55e, #16a34a);
    color: white;
}

.save-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.submit-btn {
    background: linear-gradient(135deg, #ef4444, #dc2626);
    color: white;
}

.submit-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

/* ===== DIMENSION SECTION ===== */
.dimension-header {
    background: linear-gradient(135deg, #6366f1, #0f766e);
    color: white;
    padding: 15px 20px;
    border-radius: 10px;
    cursor: pointer;
    margin-bottom: 8px;
    font-size: 16px;
    font-weight: 600;
    display: flex;
    justify-content: space-between;
    transition: 0.3s;
}

.dimension-header:hover {
    opacity: 0.9;
}

.dimension-content {
    display: none;
    background: white;
    padding: 20px;
    border-radius: 12px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    animation: fadeIn 0.3s ease-in-out;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(-5px); }
    to { opacity: 1; transform: translateY(0); }
}

/* ===== TABLE ===== */
table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th {
    background: #0f172a;
    color: white;
    padding: 12px;
    font-size: 14px;
}

td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    font-size: 14px;
}

input[type="number"],
input[type="text"],
input[type="file"] {
    padding: 6px;
    border-radius: 6px;
    border: 1px solid #cbd5e1;
    width: 100%;
}

/* ===== SUCCESS POPUP ===== */
.popup {
    position: fixed;
    top: 20px;
    right: 20px;
    background: #16a34a;
    color: white;
    padding: 15px 25px;
    border-radius: 10px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.2);
}
</style>


<!-- ===== HEADER ===== -->
<div class="page-header">
    <div>
        <div class="page-title">
            📘 Staff KPI Panel ({{ $submission->year }})
        </div>
        <br>
        Status:
        <span class="status-badge status-{{ $submission->status }}">
            {{ ucfirst($submission->status) }}
        </span>
    </div>

    @if($submission->status == 'draft')
    <div class="action-buttons">
        <button type="submit" form="saveForm" class="save-btn">
            💾 Save Draft
        </button>

        <button type="submit" form="submitForm" class="submit-btn">
            📤 Turn In
        </button>
    </div>
    @endif

    
</div>


@if(session('success'))
<div class="popup" id="popup">
    {{ session('success') }}
</div>
<script>
setTimeout(() => {
    document.getElementById('popup').style.display = 'none';
}, 3000);
</script>
@endif


<!-- ===== SAVE FORM ===== -->
<form id="saveForm" method="POST" action="/staff/kpi/save" enctype="multipart/form-data">
@csrf
<input type="hidden" name="submission_id" value="{{ $submission->id }}">

@php
$categories = $kpis->pluck('category')->unique();
@endphp

@foreach($categories as $category)

<div>
    <div class="dimension-header"
         onclick="toggleSection('{{ Str::slug($category) }}')">
        <span>{{ strtoupper($category) }}</span>
        <span>▶</span>
    </div>

    <div class="dimension-content"
         id="section-{{ Str::slug($category) }}">

        <table>
            <tr>
                <th>#</th>
                <th>KPI Item</th>
                <th>Weight</th>
                <th>Self Score</th>
                <th>Evidence</th>
                <th>Comment</th>
            </tr>

            @foreach($kpis->where('category', $category) as $kpi)

            @php
            $item = $submissionItems[$kpi->id] ?? null;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $kpi->item }}</td>
                <td>{{ $kpi->weight }}</td>

                <td>
                    <input type="number"
                           name="self_score[{{ $kpi->id }}]"
                           min="0"
                           max="{{ $kpi->max_marks }}"
                           value="{{ $item->self_score ?? '' }}"
                           {{ $submission->status != 'draft' ? 'disabled' : '' }}>
                </td>

                <td>
                    <input type="file"
                           name="evidence[{{ $kpi->id }}]"
                           {{ $submission->status != 'draft' ? 'disabled' : '' }}>

                    @if($item && $item->evidence)
                        <br>
                        <a href="{{ asset('storage/'.$item->evidence) }}"
                           target="_blank">View</a>
                    @endif
                </td>

                <td>
                    <input type="text"
                           name="comment[{{ $kpi->id }}]"
                           value="{{ $item->comment ?? '' }}"
                           {{ $submission->status != 'draft' ? 'disabled' : '' }}>
                </td>
            </tr>

            @endforeach
        </table>

    </div>
</div>

@endforeach
</form>


<!-- ===== SUBMIT FORM ===== -->
@if($submission->status == 'draft')
<form id="submitForm"
      method="POST"
      action="/staff/kpi/submit/{{ $submission->id }}">
    @csrf
</form>
@endif


<script>
function toggleSection(id) {
    let section = document.getElementById('section-' + id);
    section.style.display =
        section.style.display === "block" ? "none" : "block";
}
</script>

@endsection