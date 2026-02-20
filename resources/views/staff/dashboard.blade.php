@extends('staff.staff_home')

@section('content')

<h2>Staff KPI Dashboard</h2>
<p>Current appraisal cycle status overview</p>

<div class="cards">
    <div class="card">
        <h3>Appraisal Status</h3>
        <p class="status">Active</p>
        <small>Submission window open</small>
    </div>

    <div class="card">
        <h3>KPI Progress</h3>
        <p>Teaching, Research, Internal & Learning</p>
        <small>Complete all sections before deadline</small>
    </div>

    <div class="card">
        <h3>Quick Action</h3>
        <a class="btn" href="/staff/kpi">Start KPI Entry</a>
    </div>
</div>

@endsection
