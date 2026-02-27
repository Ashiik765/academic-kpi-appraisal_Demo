@extends('appraiser.appraiser_home')

@section('content')

<h2>📊 KPI Review</h2>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

@if($items->count() == 0)
    <p>No KPI submissions found.</p>
@else

<table border="1" width="100%" cellpadding="8">
    <thead>
        <tr>
            <th>ID</th>
            <th>Criteria</th>
            <th>Weightage</th>
            <th>Self Score</th>
            <th>Evidence</th>
            <th>Staff Score</th>
            <th>Appraiser Score</th>
            <th>Appraiser Final Score</th>
            <th>Final Score</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        @foreach($items as $item)
            <tr>
                <td>{{ $loop->iteration }}</td>

                <td>{{ $item->kpi->criteria ?? '-' }}</td>

                <td>{{ $item->kpi->weightage ?? 0 }}</td>

                <td>{{ $item->self_score }}</td>

                <td>
                    @if($item->evidence)
                        <a href="{{ asset('storage/'.$item->evidence) }}" target="_blank">
                            View
                        </a>
                    @else
                        -
                    @endif
                </td>

                <td>
                    {{ ($item->kpi->weightage ?? 0) * $item->self_score }}
                </td>

                <form method="POST" action="{{ route('appraiser.kpi.update', $item->id) }}">
                    @csrf

                    <td>
                        <input type="number"
                            name="appraiser_score"
                            value="{{ $item->appraiser_score }}"
                            required
                            style="width:70px;">
                    </td>

                    <td>
                        {{ ($item->kpi->weightage ?? 0) * ($item->appraiser_score ?? 0) }}
                    </td>

                    <td>
                        {{ $item->final_score ?? 0 }}
                    </td>

                    <td>
                        <button type="submit">Save</button>
                    </td>
                </form>

            </tr>
        @endforeach

    </tbody>
</table>

@endif

@endsection