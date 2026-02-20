@extends('staff.staff_home')

@section('content')

<div class="container">

    <h3>My KPI Result ({{ now()->year }})</h3>

    @if($result)

        <table class="table table-bordered">
            <tr>
                <th>Teaching</th>
                <td>{{ $result->teaching_total }}</td>
            </tr>

            <tr>
                <th>Research</th>
                <td>{{ $result->research_total }}</td>
            </tr>

            <tr>
                <th>Service</th>
                <td>{{ $result->service_total }}</td>
            </tr>

            <tr>
                <th>Learning</th>
                <td>{{ $result->learning_total }}</td>
            </tr>

            <tr class="table-success">
                <th>Total</th>
                <td>{{ $result->overall_total }}</td>
            </tr>

            <tr class="table-info">
                <th>Percentage</th>
                <td>{{ number_format($result->percentage,2) }} %</td>
            </tr>
        </table>

    @else
        <p>No result yet.</p>
    @endif

</div>

@endsection
