<?php

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Welcome Page
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Login Pages
|--------------------------------------------------------------------------
*/
Route::get('/staff/login', fn() => view('staff_login'));
Route::get('/appraiser/login', fn() => view('appraiser_login'));
Route::get('/admin/login', fn() => view('admin_login'));

/*
|--------------------------------------------------------------------------
| LOGIN PROCESS (SESSION BASED)
|--------------------------------------------------------------------------
*/
Route::post('/login', function (Request $request) {

    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
        'role'     => 'required'
    ]);

    $user = User::where('email', $request->email)
                ->where('role', $request->role)
                ->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Invalid login credentials.');
    }

    session()->put([
        'user_id'  => $user->id,
        'name'     => $user->name,
        'role'     => $user->role,
        'position' => $user->position
    ]);

    return match ($user->role) {
        'admin'     => redirect('/admin/home'),
        'staff'     => redirect('/staff/home'),
        'appraiser' => redirect('/appraiser/home'),
        default     => redirect('/')
    };
});

/*
|--------------------------------------------------------------------------
| STAFF HOME
|--------------------------------------------------------------------------
*/
Route::get('/staff/home', function () {

    if (session('role') !== 'staff') {
        abort(403);
    }

    return view('staff_home');
});


Route::get('/staff/teaching-outreach', function () {

    if (session('role') !== 'staff') {
        abort(403);
    }

    return view('staff_teaching_outreach');
});


Route::get('/appraiser/teaching-outreach', function () {

    if (session('role') !== 'appraiser') {
        abort(403);
    }

    return view('appraiser_teaching');
});


Route::get('/admin/kpi/teaching-outreach', function () {

    if (session('role') !== 'admin') {
        abort(403);
    }

    return view('teaching_outreach');
});


/*
|--------------------------------------------------------------------------
| APPRAISER HOME
|--------------------------------------------------------------------------
*/
Route::get('/appraiser/home', function () {

    if (session('role') !== 'appraiser') {
        abort(403);
    }

    return view('appraiser_home');
});

/*
|--------------------------------------------------------------------------
| ADMIN HOME
|--------------------------------------------------------------------------
*/
Route::get('/admin/home', function () {

    if (session('role') !== 'admin') {
        abort(403);
    }

    return view('admin_home', [
        'users'          => User::all(),
        'staffCount'     => User::where('role', 'staff')->count(),
        'appraiserCount' => User::where('role', 'appraiser')->count(),
        'adminCount'     => User::where('role', 'admin')->count()
    ]);
});


Route::get('/admin/kpi/teaching-outreach', function () {

    if (session('role') !== 'admin') {
        abort(403);
    }

    return view('teaching_outreach');
});


/*
|--------------------------------------------------------------------------
| ADMIN ADD USER
|--------------------------------------------------------------------------
*/
Route::get('/admin/add-user', function () {

    if (session('role') !== 'admin') {
        abort(403);
    }

    return view('admin_add_user');
});

Route::post('/admin/add-user', function (Request $request) {

    if (session('role') !== 'admin') {
        abort(403);
    }

    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6',
        'role'     => 'required',
        'position' => 'nullable'
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => $request->role,
        'position' => $request->role === 'staff' ? $request->position : null
    ]);

    return back()->with('success', 'User added successfully!');
});

/*
|--------------------------------------------------------------------------
| ADMIN REGISTER (FIRST TIME)
|--------------------------------------------------------------------------
*/
Route::get('/admin/register', fn() => view('admin_register'));

Route::post('/admin/register', function (Request $request) {

    $request->validate([
        'name'     => 'required',
        'email'    => 'required|email|unique:users',
        'password' => 'required|min:6'
    ]);

    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'admin',
        'position' => null
    ]);

    return redirect('/admin/login')->with('success', 'Admin registered!');
});





/*
|--------------------------------------------------------------------------
| LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/logout', function () {
    session()->flush();
    return redirect('/');
});
