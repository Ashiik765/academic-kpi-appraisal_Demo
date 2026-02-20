@extends('staff.staff_home')

@section('content')

<style>
/* ===== Reset default gap from parent ===== */
section.content, .content-wrapper {
    padding: 0 !important;
    margin: 0 !important;
}

/* ===== Full Screen Wrapper ===== */
.profile-wrapper {
    height: 100vh; /* Full viewport height */
    width: 100%;
    padding: 40px 20px; /* Some inner padding */
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    display: flex;
    flex-direction: column;
    box-sizing: border-box;
}

/* ===== Header ===== */
.profile-header {
    display: flex;
    align-items: center;
    gap: 20px;
    color: white;
    margin-bottom: 40px;
}

.profile-header i {
    font-size: 80px;
}

.profile-header h2 {
    margin: 0;
    font-size: 32px;
    font-weight: 600;
}

.profile-header p {
    margin: 5px 0 0;
    opacity: 0.9;
}

/* ===== Grid Layout ===== */
.profile-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 30px;
    flex: 1;
}

/* ===== Cards ===== */
.profile-card {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    border-radius: 20px;
    padding: 30px;
    color: white;
    box-shadow: 0 8px 25px rgba(0,0,0,0.2);
    transition: 0.3s ease;
}

.profile-card:hover {
    transform: translateY(-5px);
}

/* ===== Card Titles ===== */
.profile-card h3 {
    margin-bottom: 25px;
    font-weight: 600;
    border-bottom: 1px solid rgba(255,255,255,0.3);
    padding-bottom: 10px;
}

/* ===== Info Rows ===== */
.info-row {
    display: flex;
    justify-content: space-between;
    padding: 12px 0;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.info-row span {
    opacity: 0.8;
}

.info-row strong {
    font-weight: 500;
}

/* ===== Button ===== */
.btn {
    width: 100%;
    padding: 12px;
    border-radius: 10px;
    border: none;
    background: white;
    color: #4e73df;
    font-weight: 600;
    cursor: pointer;
    transition: 0.3s;
}

.btn:hover {
    background: #f8f9fc;
    transform: scale(1.02);
}

/* ===== Responsive ===== */
@media(max-width: 900px) {
    .profile-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<div class="profile-wrapper">

    <!-- Header -->
    <div class="profile-header">
        <i class='bx bx-user-circle'></i>
        <div>
            <h2>{{ ucfirst(session('name')) }}</h2>
            <p>{{ ucfirst(session('role')) }}</p>
        </div>
    </div>

    <!-- Profile Cards -->
    <div class="profile-grid">

        <!-- Personal Information -->
        <div class="profile-card">
            <h3><i class='bx bx-id-card'></i> Personal Information</h3>

            <div class="info-row">
                <span>Name</span>
                <strong>{{ session('name') }}</strong>
            </div>

            <div class="info-row">
                <span>Email</span>
                <strong>{{ session('email') }}</strong>
            </div>

            <div class="info-row">
                <span>User ID</span>
                <strong>{{ session('user_id') }}</strong>
            </div>

            <div class="info-row">
                <span>Role</span>
                <strong>{{ ucfirst(session('role')) }}</strong>
            </div>

            @if(session('role') == 'staff')
            <div class="info-row">
                <span>Position</span>
                <strong>{{ session('position') }}</strong>
            </div>
            @endif
        </div>

        <!-- Account Settings -->
        <div class="profile-card">
            <h3><i class='bx bx-cog'></i> Account Settings</h3>

            <form method="POST" action="/profile/request-change">
                @csrf
                <button class="btn" type="submit">
                    Request Profile Change
                </button>
            </form>

            @if(session('success'))
                <p style="color:#d4edda; margin-top:15px;">
                    {{ session('success') }}
                </p>
            @endif
        </div>

    </div>
</div>

@endsection
