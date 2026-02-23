<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Kpi;
use App\Models\KpiSubmission;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffKpiController;
use App\Http\Controllers\AppraiserKpiController;
use App\Http\Controllers\AdminKpiController;





Route::post('/profile/request-change', [ProfileController::class, 'requestChange']);



/*
|--------------------------------------------------------------------------
| LANDING PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', fn() => view('welcome'));

/*
|--------------------------------------------------------------------------
| LOGIN PAGES
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', fn() => view('admin.admin_login'));
Route::get('/staff/login', fn() => view('staff.staff_login'));
Route::get('/appraiser/login', fn() => view('appraiser.appraiser_login'));

/*
|--------------------------------------------------------------------------
| LOGIN PROCESS
|--------------------------------------------------------------------------
*/
Route::post('/login', function (Request $request) {

    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
        'role'     => 'required'
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || !Hash::check($request->password, $user->password)) {
        return back()->with('error', 'Invalid login credentials');
    }

    if ($user->role !== $request->role) {
        return back()->with('error', 'Role mismatch');
    }

    session()->put([
        'user_id'  => $user->id,
        'name'     => $user->name,
        'email'    => $user->email,
        'role'     => $user->role,
        'position' => $user->position
    ]);

    return redirect('/' . $user->role . '/home');
});

/*
|--------------------------------------------------------------------------
| STAFF ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/staff/home', function () {
    abort_if(session('role') !== 'staff', 403);
    return view('staff.dashboard');
});

/*
|--------------------------------------------------------------------------
| STAFF KPI ROUTES
|--------------------------------------------------------------------------
*/



Route::get('/staff/profile', function () {
    abort_if(session('role') !== 'staff', 403);
    return view('staff.profile');
});


Route::get('/staff/kpi/{category}', [StaffKpiController::class, 'category']);
Route::post('/staff/kpi/save', [StaffKpiController::class, 'save']);
Route::post('/staff/kpi/submit/{id}', [StaffKpiController::class, 'submit']);

/*
|--------------------------------------------------------------------------
| APPRAISER ROUTES
|--------------------------------------------------------------------------
*/

Route::get('/appraiser/home', 
    [AppraiserKpiController::class, 'index']
)->name('appraiser.home');

Route::post('/appraiser/kpi/review/{id}', 
    [AppraiserKpiController::class, 'review']
)->name('appraiser.review');

Route::get('/appraiser/profile', function () {
    abort_if(session('role') !== 'appraiser', 403);
    return view('appraiser.profile');
});

Route::get('/appraiser/kpi/teaching_kpi', 
    [AppraiserKpiController::class, 'index']
)->name('appraiser.kpi.teaching_kpi');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::get('/admin/home', function () {
    abort_if(session('role') !== 'admin', 403);

    return view('admin.admin_home', [
        'users'          => User::all(),
        'staffCount'     => User::where('role', 'staff')->count(),
        'appraiserCount' => User::where('role', 'appraiser')->count(),
        'adminCount'     => User::where('role', 'admin')->count(),
    ]);
});



Route::post('/admin/users/store', function (Request $request) {
    abort_if(session('role') !== 'admin', 403);

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'role' => 'required|in:staff,appraiser,admin',
        'password' => 'required|min:6|confirmed',
        'position' => 'required_if:role,staff'

    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // ⭐ VERY IMPORTANT
        'role' => $request->role,
        'position' => $request->position
    ]);

    return redirect('/admin/home')->with('success', 'User added successfully');
  // CHANGED: Return JSON
});

Route::get('/admin/profile', function () {
    abort_if(session('role') !== 'admin', 403);
    return view('admin.profile');
});


/*
|--------------------------------------------------------------------------
| ADMIN – KPI MANAGEMENT
|--------------------------------------------------------------------------
*/
Route::middleware([])->group(function () {

    Route::get('/admin/kpi/{category}', function ($category) {

        abort_if(session('role') !== 'admin', 403);

        return app(\App\Http\Controllers\AdminKpiController::class)
            ->category($category);
    });

    Route::post('/admin/kpi/store', function (Request $request) {

        abort_if(session('role') !== 'admin', 403);

        return app(\App\Http\Controllers\AdminKpiController::class)
            ->store($request);
    });

    Route::get('/admin/kpi/delete/{id}', function ($id) {

        abort_if(session('role') !== 'admin', 403);

        return app(\App\Http\Controllers\AdminKpiController::class)
            ->delete($id);
    });

});

Route::post('/admin/kpi/storeAll', [AdminKpiController::class, 'storeAll']);

/*
|--------------------------------------------------------------------------
| ADMIN – USER MANAGEMENT
|--------------------------------------------------------------------------
*/
Route::get('/admin/users', function () {
    abort_if(session('role') !== 'admin', 403);
    return view('admin.users.index', ['users' => User::all()]);
});

Route::get('/admin/users/add', function () {
    abort_if(session('role') !== 'admin', 403);
    return view('admin.users.add');
});


Route::delete('/admin/users/delete/{id}', function ($id) {
    abort_if(session('role') !== 'admin', 403);

    User::findOrFail($id)->delete();

    return response()->json(['success' => true]);
});


/*
|--------------------------------------------------------------------------
| ADMIN REGISTER
|--------------------------------------------------------------------------
*/
Route::get('/admin/register', fn() => view('admin.admin_register'));

Route::post('/admin/register', function (Request $request) {

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:6|confirmed',
        'role' => 'required|in:staff,appraiser,admin',
        'position' => 'nullable|required_if:role,staff'
    ]);


    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'admin',
        'position' =>$request->position
    ]);

    return redirect('/admin/login')->with('success', 'Admin registered successfully');
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
