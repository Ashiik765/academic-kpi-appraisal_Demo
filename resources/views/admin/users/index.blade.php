<div class="card">

    <!-- HEADER -->
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:18px;">

        <!-- TITLE -->
        <div>
            <h3 style="margin:0;">User Management</h3>
            <small style="color:#777;">Manage system users easily</small>
        </div>

        <!-- RIGHT SIDE (Add + Filter) -->
        <div style="display:flex; gap:10px; align-items:center;">

            <!-- ✅ ADD USER BUTTON -->
            <button
                onclick="loadPage('/admin/users/add')"
                style="
                    background:#27ae60;
                    color:white;
                    border:none;
                    padding:8px 14px;
                    border-radius:8px;
                    cursor:pointer;
                    font-weight:500;
                    display:flex;
                    align-items:center;
                    gap:6px;
                    box-shadow:0 4px 10px rgba(0,0,0,0.1);">
                <i class='bx bx-plus'></i>
                Add User
            </button>

            <!-- FILTER -->
            <select id="roleFilter"
                style="
                    padding:8px 10px;
                    border-radius:8px;
                    border:1px solid #ddd;
                    background:white;">
                <option value="all">All Roles</option>
                <option value="admin">Admin</option>
                <option value="staff">Staff</option>
                <option value="appraiser">Appraiser</option>
            </select>

        </div>
    </div>


    <!-- SUCCESS MESSAGE -->
    @if(session('success'))
        <div style="
            background:#d4edda;
            color:#155724;
            padding:10px;
            border-radius:6px;
            margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif


    <!-- TABLE -->
    <table id="usersTable" style="width:100%; border-collapse:collapse;">

        <thead>
            <tr style="background:#27ae60; color:white;">
                <th style="padding:12px;">Name</th>
                <th>Email</th>
                <th>Role</th>
                <th width="140" style="text-align:center;">Action</th>
            </tr>
        </thead>

        <tbody>
        @forelse($users as $user)

            <tr data-role="{{ $user->role }}" style="border-bottom:1px solid #eee;">

                <td style="padding:10px;">{{ ucfirst($user->name) }}</td>

                <td>{{ $user->email }}</td>

                <td>
                    <span style="
                        padding:4px 10px;
                        border-radius:20px;
                        background:#ecf0f1;
                        font-size:13px;">
                        {{ ucfirst($user->role) }}
                    </span>
                </td>

                <td style="text-align:center;">

                    @if($user->role !== 'admin')

                        <button
                            onclick="deleteUser({{ $user->id }})"
                            style="
                                background:#e74c3c;
                                color:white;
                                border:none;
                                padding:6px 10px;
                                border-radius:6px;
                                cursor:pointer;">
                            Delete
                        </button>

                    @else
                        <span style="color:gray;">Protected</span>
                    @endif

                </td>

            </tr>

        @empty
            <tr>
                <td colspan="4" style="text-align:center; padding:20px;">
                    No users found
                </td>
            </tr>
        @endforelse
        </tbody>

    </table>

</div>
