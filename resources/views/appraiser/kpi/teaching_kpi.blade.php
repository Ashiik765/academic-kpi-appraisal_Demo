@extends('appraiser.appraiser_home')

@section('content')

<style>
    .page-header { margin-bottom: 25px; }
    .page-header h2 { font-weight: 600; color: #2c3e50; }

    .kpi-card {
        background: #ffffff;
        padding: 20px;
        border-radius: 14px;
        box-shadow: 0 4px 14px rgba(0,0,0,0.08);
        overflow-x: auto;
    }

    .kpi-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 14px;
    }

    .kpi-table thead { background: #f6f8fb; }

    .kpi-table th {
        padding: 12px;
        text-align: left;
        font-weight: 600;
        color: #34495e;
        border-bottom: 2px solid #e5e7eb;
    }

    .kpi-table td {
        padding: 12px;
        border-bottom: 1px solid #ececec;
        vertical-align: middle;
    }

    .kpi-table tbody tr:hover {
        background: #f9fbff;
        transition: 0.2s;
    }

    .badge {
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        display: inline-block;
    }

    .badge-role {
        background: #e3f2fd;
        color: #1565c0;
    }

    .badge-dimension {
        background: #e8f5e9;
        color: #2e7d32;
    }

    .btn {
        border: none;
        padding: 7px 14px;
        border-radius: 6px;
        font-size: 13px;
        cursor: pointer;
        transition: 0.2s;
    }

    .btn-view {
        background: #607d8b;
        color: white;
        text-decoration: none;
    }

    .btn-view:hover { background: #455a64; }

    .btn-approve {
        background: #2ecc71;
        color: white;
    }

    .btn-approve:hover { background: #27ae60; }

    .score-input {
        width: 70px;
        padding: 6px;
        border-radius: 6px;
        border: 1px solid #dcdcdc;
        text-align: center;
    }

    .empty {
        text-align: center;
        padding: 40px;
        color: #888;
        font-style: italic;
    }

    .submission-header {
        background: #f1f5f9;
        font-weight: 600;
    }
</style>


<div class="page-header">
    <h2>📊 KPI Review Panel</h2>
</div>


<div class="kpi-card">

<table class="kpi-table">

    <thead>
        <tr>
            <th>Staff</th>
            <th>Email</th>
            <th>Role</th>
            <th>Position</th>
            <th>Dimension</th>
            <th>KPI Title</th>
            <th>Evidence</th>
            <th>Rating</th>
            <th>Score</th>
            <th>Action</th>
        </tr>
    </thead>

    <tbody>

    @forelse($submissions as $submission)

        @foreach($submission->items as $item)

        <tr>

            {{-- Staff --}}
            <td><strong>{{ $submission->user->name ?? '-' }}</strong></td>

            {{-- Email --}}
            <td>{{ $submission->user->email ?? '-' }}</td>

            {{-- Role --}}
            <td>
                <span class="badge badge-role">
                    {{ $submission->user->role ?? '-' }}
                </span>
            </td>

            {{-- Position --}}
            <td>{{ $submission->user->position ?? '-' }}</td>

            {{-- Dimension --}}
            <td>
                <span class="badge badge-dimension">
                    {{ $item->kpi->category ?? '-' }}
                </span>
            </td>

            {{-- KPI Title --}}
            <td>{{ $item->kpi->criteria ?? '-' }}</td>

            {{-- Evidence --}}
            <td>
                @if($item->evidence)
                    <a href="{{ asset('storage/'.$item->evidence) }}"
                       target="_blank"
                       class="btn btn-view">
                        View
                    </a>
                @else
                    <span style="color:#999;">No file</span>
                @endif
            </td>

            {{-- Rating --}}
            <td>{{ $item->rating ?? 0 }}</td>

            {{-- Score --}}
            <td>{{ $item->score ?? 0 }}</td>

        </tr>

        <td colspan="2">
            <form method="POST" action="{{ route('appraiser.review', $submission->id) }}">
                @csrf
                <input type="hidden" name="status" value="approved">
                <input type="hidden" name="score" value="{{ $submission->total_score }}">
                <button type="submit" class="btn btn-approve">
                    Approve
                </button>
            </form>
        </td>
        @endforeach

        {{-- Total Row --}}
        <tr class="submission-header">
            <td colspan="8">Total Score ({{ $submission->year }})</td>
            <td colspan="2">
                {{ $submission->total_score }}
            </td>
        </tr>

    @empty

        <tr>
            <td colspan="10" class="empty">
                No submissions found
            </td>
        </tr>

    @endforelse

    </tbody>
</table>

</div>

@endsection
