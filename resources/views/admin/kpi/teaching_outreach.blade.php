<div class="card">
    <h3>Teaching & Outreach KPI</h3>
    <p>Admin defines KPI rules, marks & weightage</p>

    @if(session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form method="POST" action="/admin/kpi/store" style="margin-top:15px;">
        @csrf

        <div style="margin-bottom:10px;">
            <input type="text" name="item" placeholder="KPI Item"
                   style="width:100%; padding:10px;" required>
        </div>

        <div style="margin-bottom:10px;">
            <textarea name="description" placeholder="Description"
                      style="width:100%; padding:10px;"></textarea>
        </div>

        <div style="margin-bottom:10px;">
            <input type="number" name="max_marks" placeholder="Max Marks"
                   style="width:100%; padding:10px;" required>
        </div>

        <button style="padding:10px 20px; background:#27ae60; color:white; border:none;">
            + Add KPI
        </button>
    </form>
</div>

<div class="card">
    <h3>KPI List</h3>

    <table style="width:100%; margin-top:15px; border-collapse:collapse;">
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
