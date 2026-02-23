@extends('staff.staff_home')

@section('content')

<style>
.kpi-container {
    background: #ffffff;
    padding: 25px;
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.05);
}

.kpi-header {
    margin-bottom: 20px;
}

.kpi-table {
    width: 100%;
    border-collapse: collapse;
}

.kpi-table th {
    background: #2563eb;
    color: white;
    padding: 12px;
    font-size: 14px;
    text-align: left;
}

.kpi-table td {
    padding: 12px;
    border-bottom: 1px solid #f1f1f1;
    font-size: 14px;
}

.kpi-table input[type="number"],
.kpi-table input[type="file"] {
    width: 100%;
    padding: 6px 8px;
    border-radius: 6px;
    border: 1px solid #d1d5db;
    font-size: 13px;
}

.badge {
    padding: 4px 10px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
}

.badge-approved { background: #dcfce7; color: #16a34a; }
.badge-rejected { background: #fee2e2; color: #dc2626; }
.badge-pending  { background: #fef3c7; color: #d97706; }
.badge-draft    { background: #e5e7eb; color: #6b7280; }

.btn-submit {
    margin-top: 20px;
    padding: 10px 18px;
    background: #2563eb;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

.btn-submit:hover {
    background: #1e40af;
}
</style>

<div class="kpi-container">

    <div class="kpi-header">
        <h2>KPI Entry - {{ ucfirst($category) }}</h2>
    </div>

    @if(session('success'))
        <div style="color:green; margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="/staff/kpi/save" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="submission_id" value="{{ $submission->id }}">
        <input type="hidden" name="category" value="{{ $category }}">
        <!-- action will be set by JavaScript when user clicks submit button -->
        <input type="hidden" name="action" id="formAction" value="save">

        <table class="kpi-table">
            <tr>
                <th>ID</th>
                <th>Item</th>
                <th>Max</th>
                <th>Self Score</th>
                <th>Evidence</th>
                <th>Status</th>
            </tr>

            @foreach($kpis as $kpi)
            @php
                $item = $submissionItems[$kpi->id] ?? null;
                $status = $item->status ?? 'draft';
            @endphp

            <tr>
                <td>{{ $kpi->id }}</td>
                <td>{{ $kpi->item }}</td>
                <td>{{ $kpi->max_marks }}</td>

                <td>
                    <input type="number"
                           name="self_score[{{ $kpi->id }}]"
                           max="{{ $kpi->max_marks }}"
                           value="{{ $item->self_score ?? '' }}"
                           {{ $status == 'approved' ? 'readonly' : '' }}>
                </td>

                <td>
                    @if($status == 'approved')
                        Uploaded
                    @else
                        <input type="file" name="evidence[{{ $kpi->id }}]">
                    @endif
                </td>

                <td>
                    @if($status == 'approved')
                        <span class="badge badge-approved">Approved</span>
                    @elseif($status == 'submitted')
                        <span class="badge badge-pending">Pending</span>
                    @elseif($status == 'rejected')
                        <span class="badge badge-rejected">Rejected</span>
                    @else
                        <span class="badge badge-draft">Draft</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </table>

        <!-- button submits as 'submit' action; we update hidden field accordingly -->
        <button type="submit" class="btn-submit" onclick="document.getElementById('formAction').value='submit';">
            Turn In Dimension
        </button>

    </form>

</div>

@endsection