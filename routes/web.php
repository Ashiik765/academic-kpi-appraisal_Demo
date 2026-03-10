
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
use App\Http\Controllers\StaffResultController;





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
        'staff_type' => $user->staff_type
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

    $submission = \App\Models\KpiSubmission::where('user_id', session('user_id'))
        ->latest()
        ->first();

    $reviewed = $submission && $submission->status === 'reviewed';

    return view('staff.dashboard', compact('reviewed'));

});

Route::get('/staff/dashboard', [StaffKpiController::class, 'dashboard'])->name('staff.dashboard');

/*
|--------------------------------------------------------------------------
| STAFF KPI ROUTES
|--------------------------------------------------------------------------
*/



Route::get('/staff/profile', function () {
    abort_if(session('role') !== 'staff', 403);
    return view('staff.profile');
});

Route::get('/staff/kpi/result', [StaffResultController::class,'index'])
    ->name('staff.kpi.result');

Route::get('/staff/kpi/result/print', [StaffResultController::class,'print'])
    ->name('staff.kpi.print');


Route::get('/staff/kpi/{category}', [StaffKpiController::class, 'category']);
Route::post('/staff/kpi/save', [StaffKpiController::class, 'save']);
Route::post('/staff/kpi/submit/{id}', [StaffKpiController::class, 'submit']);

/*
|--------------------------------------------------------------------------
| APPRAISER ROUTES
|--------------------------------------------------------------------------
*/



Route::get('/appraiser/home', function () {
    abort_if(session('role') !== 'appraiser', 403);
    return view('appraiser.appraiser_home');
})->name('appraiser.home');



Route::get('/appraiser/profile', function () {
    abort_if(session('role') !== 'appraiser', 403);
    return view('appraiser.profile');
});


// APPRAISER KPI LIST
Route::get('/appraiser/kpi', [AppraiserKpiController::class, 'index'])
    ->name('appraiser.kpi');

// VIEW ONE SUBMISSION
Route::get('/appraiser/kpi/{id}', [AppraiserKpiController::class, 'show'])
    ->name('appraiser.kpi.show');

// SUBMIT REVIEW
Route::post('/appraiser/kpi/review/{id}', [AppraiserKpiController::class, 'submitReview'])
    ->name('appraiser.kpi.submitReview');


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
        'staff_type' => 'required_if:role,staff',
        'intake_month' => 'required_if:role,staff',
        'intake_year' => 'required_if:role,staff|numeric'

    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password), // ⭐ VERY IMPORTANT
        'role' => $request->role,
        'staff_type' => $request->staff_type,
        'intake_month' => $request->intake_month,
        'intake_year' => $request->intake_year

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

Route::prefix('admin/kpi')->group(function () {

    Route::get('/{staff_type}/{category}', 
        [AdminKpiController::class, 'category']
    )->where([
        'staff_type' => 'academic|non-academic',
        'category' => 'teaching|research|internal|learning'
    ]);

    Route::post('/storeAll', [AdminKpiController::class, 'storeAll']);

    Route::get('/delete/{id}', [AdminKpiController::class, 'delete']);

});

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
        'staff_type' => 'nullable|required_if:role,staff',
        'intake_month' => 'nullable|required_if:role,staff',
        'intake_year' => 'nullable|required_if:role,staff|numeric'
    ]);


    User::create([
        'name'     => $request->name,
        'email'    => $request->email,
        'password' => Hash::make($request->password),
        'role'     => 'admin',
        'staff_type' => $request->staff_type,
        'intake_month' => $request->intake_month,
        'intake_year' => $request->intake_year

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
