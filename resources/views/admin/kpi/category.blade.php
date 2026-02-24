<div class="card">

    <h3 style="text-transform:capitalize;">
        {{ $category }} KPI Management
    </h3>

    @if(session('success'))
    <div id="successPopup" class="success-popup">
        <div class="success-box">
            <span class="success-icon">✔</span>
            <span>KPI Added Successfully</span>
        </div>
    </div>
    @endif

    <form method="POST" action="/admin/kpi/storeAll">
        @csrf

        <input type="hidden" name="category" value="{{ $category }}">

        <table style="width:100%; margin-top:20px; border-collapse:collapse;" id="kpiTable">
            <tr style="background:#2c3e50; color:white;">
                
                <th style="padding:10px;">Criteria</th>
                <th>Weightage</th>
                <th>Action</th>
            </tr>

            <!-- Dynamic Rows Here -->

        </table>

        <button type="button"
                onclick="addRow()"
                style="margin-top:15px; padding:8px 15px; background:#3498db; color:white; border:none;">
            + Add KPI
        </button>

        <button type="submit"
                style="margin-top:15px; padding:8px 15px; background:#27ae60; color:white; border:none;">
            Turn In
        </button>

    </form>
</div>

<div class="card" style="margin-top:25px;">
    <h3>Saved KPI List</h3>

    <table style="width:100%; border-collapse:collapse;">
        <tr style="background:#27ae60; color:white;">
            <th style="padding:10px; width:50px;">ID</th>
            <th style="padding:10px;">Criteria</th>
            <th>Weightage</th>
            <th>Action</th>
        </tr>

        @forelse($kpis as $index => $kpi)
        <tr>
            <td style="padding:10px; text-align:center;">{{ $index + 1 }}</td>
            <td style="padding:10px;">{{ $kpi->criteria }}</td>
            <td>{{ $kpi->weightage }}</td>
            <td>
                <a href="/admin/kpi/delete/{{ $kpi->id }}"
                   onclick="return confirm('Delete this KPI?')"
                   style="color:red;">Delete</a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="4" style="text-align:center; padding:15px;">
                No KPI added yet
            </td>
        </tr>
        @endforelse
    </table>
</div>

<script>
function addRow() {
    let table = document.getElementById('kpiTable');
    let rowCount = table.rows.length;
    
    // Calculate new ID (rowCount because header is row 0)
    let newId = rowCount;
    
    let row = table.insertRow(-1);

    row.innerHTML = `
        <td style="padding:10px; text-align:center; font-weight:bold;">${newId}</td>
        <td>
            <input type="text" name="criteria[]" required style="width:100%; padding:5px;">
        </td>
        <td>
            <input type="number" name="weightage[]" required style="width:100%; padding:5px;">
        </td>
        <td>
            <button type="button" onclick="this.closest('tr').remove()"
                    style="background:red; color:white; border:none; padding:51px 10px;">
                X
            </button>
        </td>
    `;
}
</script>