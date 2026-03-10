<h2>KPI Result</h2>

<table border="1" cellpadding="10">

<tr>
<th>Category</th>
<th>Criteria</th>
<th>Weight</th>
<th>Appraiser Score</th>
<th>Final Score</th>
</tr>

@php
$total = 0;
@endphp

@foreach($items as $item)

@php
$weight = $item->kpi->weightage;
$score = $item->appraiser_score ?? 0;
$final = $weight * $score;
$total += $final;
@endphp

<tr>

<td>{{ $item->kpi->category }}</td>
<td>{{ $item->kpi->criteria }}</td>
<td>{{ $weight }}</td>
<td>{{ $score }}</td>
<td>{{ $final }}</td>

</tr>

@endforeach

</table>

<h3>Total KPI Score : {{ $total }}</h3>

<script>
window.print();
</script>