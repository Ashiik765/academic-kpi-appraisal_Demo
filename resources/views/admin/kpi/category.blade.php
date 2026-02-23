
<div class="card">

    <h3 style="text-transform:capitalize;">
        {{ $category }} KPI Management
    </h3>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/admin/kpi/storeAll">
        @csrf

        <input type="hidden" name="category" value="{{ $category }}">

        <table style="width:100%; margin-top:20px; border-collapse:collapse;" id="kpiTable">
            <tr style="background:#2c3e50; color:white;">
                <th style="padding:10px;">Item</th>
                <th>Description</th>
                <th>Max Marks</th>
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
            <th style="padding:10px;">Item</th>
            <th>Description</th>
            <th>Max Marks</th>
            <th>Action</th>
        </tr>

        @forelse($kpis as $kpi)
        <tr>
            <td style="padding:10px;">{{ $kpi->item }}</td>
            <td>{{ $kpi->description }}</td>
            <td>{{ $kpi->max_marks }}</td>
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



{{-- <script>
function addRow() {
    let table = document.getElementById('kpiTable');

    let row = table.insertRow(-1);

    row.innerHTML = `
        <td>
            <input type="text" name="item[]" required style="width:100%; padding:5px;">
        </td>
        <td>
            <input type="text" name="description[]" style="width:100%; padding:5px;">
        </td>
        <td>
            <input type="number" name="max_marks[]" required style="width:100%; padding:5px;">
        </td>
        <td>
            <button type="button" onclick="this.closest('tr').remove()"
                    style="background:red; color:white; border:none;">
                X
            </button>
        </td>
    `;
}
</script> --}}

