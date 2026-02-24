<h2>KPI Management</h2>

@php
$categories = ['teaching','research','internal','learning'];
@endphp

@foreach($categories as $cat)

<h3 onclick="toggle('{{ $cat }}')" style="cursor:pointer; background:#f0f0f0; padding:10px; margin:5px 0;">
    {{ ucfirst($cat) }}
</h3>

<div id="{{ $cat }}" style="display:none; padding:15px; border:1px solid #ddd; margin-bottom:15px;">

    <table border="1" width="100%" style="border-collapse:collapse;">
        <tr style="background:#2c3e50; color:white;">
            <th style="padding:10px; width:50px;">ID</th>
            <th style="padding:10px;">Criteria</th>
            <th style="padding:10px;">Weightage</th>
        </tr>

        @if(isset($kpis[$cat]) && count($kpis[$cat]) > 0)
            @foreach($kpis[$cat] as $index => $kpi)
            <tr>
                <td style="padding:10px; text-align:center;">{{ $index + 1 }}</td>
                <td style="padding:10px;">{{ $kpi->criteria }}</td>
                <td style="padding:10px;">{{ $kpi->weightage }}</td>
            </tr>
            @endforeach
        @else
            <tr>
                <td colspan="3" style="text-align:center; padding:15px;">
                    No KPI added yet for {{ $cat }}
                </td>
            </tr>
        @endif

    </table>

    <h4 style="margin-top:20px;">Add New KPI for {{ ucfirst($cat) }}</h4>

    <form method="POST" action="/admin/kpi/store" style="background:#f9f9f9; padding:15px;">


        @csrf
        <input type="hidden" name="category" value="{{ $cat }}">
        
        <div style="margin-bottom:10px;">
            <label style="display:block; margin-bottom:5px;">KPI Criteria:</label>
            <input type="text" name="criteria" placeholder="Enter KPI criteria" required 
                   style="width:100%; padding:8px; border:1px solid #ddd;">
        </div>
        
        <div style="margin-bottom:10px;">
            <label style="display:block; margin-bottom:5px;">Weightage:</label>
            <input type="number" name="weightage" placeholder="Enter weightage" required 
                   style="width:100%; padding:8px; border:1px solid #ddd;">
        </div>
        
        <button type="submit" 
                style="background:#27ae60; color:white; border:none; padding:10px 20px; cursor:pointer;">
            Turn In
        </button>
    </form>

</div>

@endforeach

<script>
function toggle(id){
    let el = document.getElementById(id);
    if(el.style.display === "none" || el.style.display === "") {
        el.style.display = "block";
    } else {
        el.style.display = "none";
    }
    
}
</script>

<style>
table {
    border-collapse: collapse;
    width: 100%;
}
th, td {
    border: 1px solid #ddd;
}
tr:hover {
    background-color: #f5f5f5;
}
</style>