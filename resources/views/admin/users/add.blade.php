<!-- PAGE TITLE -->
<div class="card">
    <h3>Add New User</h3>
    <p>Fill in the details to add a new user to the system.</p>
</div>


<!-- ADD USER FORM -->
<div class="card"
     style="max-width: 600px; margin: 0 auto; box-shadow: 0 8px 20px rgba(0,0,0,0.1); border-radius: 15px; padding: 30px;">

    <h3 style="text-align: center; margin-bottom: 20px; color: #27ae60;">User Details</h3>

    <form method="POST" action="/admin/users/store">
        @csrf

        <!-- NAME -->
        <div style="margin-bottom: 15px;">
            <label>Name</label>
            <input type="text" name="name" required class="input">
        </div>

        <!-- EMAIL -->
        <div style="margin-bottom: 15px;">
            <label>Email</label>
            <input type="email" name="email" required class="input">
        </div>

        <!-- ROLE -->
        <div style="margin-bottom: 15px;">
            <label>Role</label>
            <select name="role" id="roleSelect" required class="input" onchange="document.getElementById('positionField').style.display = this.value === 'staff' ? 'block' : 'none';">
                <option value="">Select Role</option>
                <option value="staff">Staff</option>
                <option value="appraiser">Appraiser</option>
                <option value="admin">Admin</option>
            </select>
        </div>

        <!-- POSITION (STAFF ONLY) -->
        <div id="positionField" style="margin-bottom: 15px; display:none;">
            <label>Position</label>
            <select name="position" class="input">
                <option value="">Select Position</option>
                <option value="lecture">Lecture</option>
                <option value="seniorlecture">Senior Lecture</option>
                <option value="lecture1">Lecture 1</option>
                <option value="lecture2">Lecture 2</option>
                <option value="lecture3">Lecture 3</option>
                <option value="lecture4">Lecture 4</option>
            </select>
        </div>


        <!-- PASSWORD -->
        <div style="margin-bottom: 15px;">
            <label>Password</label>
            <div style="position:relative;">
                <input type="password" name="password" id="password" required class="input">
                <span onclick="togglePass('password')" class="eye">👁</span>
            </div>
        </div>


        <!-- CONFIRM PASSWORD -->
        <div style="margin-bottom: 15px;">
            <label>Confirm Password</label>
            <div style="position:relative;">
                <input type="password" name="password_confirmation" id="confirmPassword" required class="input">
                <span onclick="togglePass('confirmPassword')" class="eye">👁</span>
            </div>
        </div>


        <!-- BUTTONS -->
        <div style="text-align:center; margin-top: 20px;">
            <button type="submit" class="btn-save">Save User</button>

            <button type="button"
                onclick="loadPage('/admin/users')"
                class="btn-cancel">
                Cancel
            </button>
        </div>

    </form>
</div>



<!-- STYLE -->
<style>
.input{
    width:100%;
    padding:10px;
    border:1px solid #ddd;
    border-radius:8px;
    font-size:15px;
}

.btn-save{
    background:#27ae60;
    color:white;
    padding:12px 24px;
    border:none;
    border-radius:8px;
    cursor:pointer;
    margin-right:10px;
}

.btn-cancel{
    background:#e74c3c;
    color:white;
    padding:12px 24px;
    border:none;
    border-radius:8px;
    cursor:pointer;
}

.eye{
    position:absolute;
    right:10px;
    top:9px;
    cursor:pointer;
}

label{
    font-weight:bold;
    margin-bottom:5px;
    display:block;
}
</style>



<!-- SCRIPT -->
<script>
// Attach role -> position toggle immediately and robustly.
function attachRoleToggle() {
    const roleSelect = document.getElementById('roleSelect');
    const positionField = document.getElementById('positionField');

    if (!roleSelect || !positionField) return;

    // Ensure correct visibility on load
    positionField.style.display = roleSelect.value === 'staff' ? 'block' : 'none';

    // Add change listener (idempotent)
    roleSelect.removeEventListener && roleSelect.removeEventListener('change', roleSelect._roleChangeHandler);
    roleSelect._roleChangeHandler = function () {
        positionField.style.display = this.value === 'staff' ? 'block' : 'none';
    };
    roleSelect.addEventListener('change', roleSelect._roleChangeHandler);
}

// Run immediately (works when HTML is injected) and on DOMContentLoaded as fallback
attachRoleToggle();
document.addEventListener && document.addEventListener('DOMContentLoaded', attachRoleToggle);

function togglePass(id){
    let input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
}
</script>
