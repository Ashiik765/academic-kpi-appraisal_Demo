<h2>KPI Management</h2>

@php
$categories = ['teaching','research','internal','learning'];
@endphp

@foreach($categories as $cat)

<h3 onclick="toggle('{{ $cat }}')" style="cursor:pointer;">
{{ ucfirst($cat) }}
</h3>

<div id="{{ $cat }}" style="display:none;">

<table border="1" width="100%">
<tr>
    <th>Item</th>
    <th>Max Marks</th>
</tr>

@if(isset($kpis[$cat]))
@foreach($kpis[$cat] as $kpi)
<tr>
    <td>{{ $kpi->item }}</td>
    <td>{{ $kpi->max_marks }}</td>
</tr>
@endforeach
@endif

</table>

<h4>Add KPI</h4>

<form method="POST" action="/admin/kpi/store">
@csrf

<input type="hidden" name="category" value="{{ $cat }}">

<input type="text" name="item" placeholder="KPI Item" required>
<input type="number" name="max_marks" placeholder="Max Marks" required>

<button type="submit">Turn In</button>

</form>

</div>



@endforeach

<script>
function toggle(id){
    let el = document.getElementById(id);
    el.style.display = el.style.display === "none" ? "block" : "none";
}
</script>