@extends('appraiser.appraiser_home')

@section('content')

<h2>📘 Teaching KPI Review</h2>

@if($kpis->count() == 0)
    <p>No Teaching KPI records found.</p>
@else

<table border="1" width="100%" cellpadding="8">
    <thead>
        <tr>
            <th>#</th>
            <th>KPI Item</th>
            <th>Description</th>
            <th>Weight</th>
            <th>Max Marks</th>
        </tr>
    </thead>
    <tbody>
        @foreach($kpis as $index => $kpi)
        <tr>
            <td>{{ $index + 1 }}</td>
            <td>{{ $kpi->item }}</td>
            <td>{{ $kpi->description }}</td>
            <td>{{ $kpi->weight }}</td>
            <td>{{ $kpi->max_marks }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

@endif

@endsection