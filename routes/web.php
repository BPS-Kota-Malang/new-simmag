<?php

use App\Http\Controllers\ActivityController;
use App\Mail\RegistrationMail;
use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\SocialiteAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\DivisionController;
use App\Http\Controllers\FacultyController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\UniversityController;
use App\Models\Division;
use Illuminate\Support\Facades\Mail;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/send-test-email', function () {
    $user= Auth::user();

    // Send email notification
    Mail::to($user->email)->send(new RegistrationMail($user->intern));

    return 'Email sent!';
});

Route::get('/', function () {
    // Check if the user is logged in
    if (Auth::check()) {
        // Redirect the user to a specific route (e.g., dashboard)
        return redirect()->route('dashboard');
    }
    // If not logged in, show the welcome view
    return view('welcome');
});

Route::get('/privacy-policy', function () {
    return view('privacy');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/sentRegistrationEmail/{intern}', [InternController::class, 'sentRegistrationEmail'])->name('admin.sentRegistrationEmail');
    Route::resource('interns', InternController::class);
    Route::get('/api/interns/active', [InternController::class, 'getActiveInterns'])->name('api.intern.active');
    Route::get('/api/division', [DivisionController::class, 'getDivision'])->name('api.division');
    Route::post('/intern/updatephoto', [InternController::class, 'updatePhotoProfile'])->name('update_photo');
    Route::patch('/apply/{apply}', [ApplyController::class, 'update'])->name('apply.update');
    Route::resource('apply', ApplyController::class);
    Route::resource('logbooks', LogbookController::class);
    Route::get('/logbookslist', [LogbookController::class, 'getLogbookList'])->name('logbooks.list');
    Route::get('/InternAttendanceData', [AttendanceController::class, 'getInternAttendanceData'])->name('attendance.getdata');
    Route::post('/reportAttendance', [AttendanceController::class, 'reportAttendancePage'])->name('attendance.report');
    Route::post('/exportAttendance', [AttendanceController::class, 'exportAttendance'])->name('attendance.export');
    Route::resource('attendance', AttendanceController::class);
    Route::resource('university', UniversityController::class);
    Route::resource('faculty', FacultyController::class);
    Route::resource('department', DepartmentController::class);
    Route::resource('activity', ActivityController::class);
    Route::get('/searchActivity', [ActivityController::class, 'search'])->name('activity.search');
    Route::get('/searchUniversity', [UniversityController::class, 'search'])->name('university.search');
    Route::get('/searchFaculty', [FacultyController::class, 'search'])->name('faculty.search');
    Route::get('/searchDepartment', [DepartmentController::class, 'search'])->name('department.search');
    Route::resource('/admin/attendance', AdminAttendanceController::class,['as' => 'admin']);
    Route::get('/admin/getAttendance', [AdminAttendanceController::class, 'getData'])->name('admin.attendance.getData');
    Route::get('/admin/getApplies', [ApplyController::class, 'getData'])->name('admin.apply.getData');
    Route::get('/admin/getApplies', [ApplyController::class, 'getData'])->name('admin.apply.getData');
    Route::get('/admin/bulk-set-work-location', [AdminAttendanceController::class, 'showBulkSetWorkLocationForm'])->name('admin.bulkSetWorkLocationForm');
    Route::post('/admin/bulk-set-work-location', [AdminAttendanceController::class, 'bulkSetWorkLocation'])->name('admin.bulkSetWorkLocation');
    Route::post('/markattendance', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('/apply/accepted/{id}', [ApplyController::class, 'accepted'])->name('apply.accepted');
    Route::get('/apply/rejected/{id}', [ApplyController::class, 'rejected'])->name('apply.rejected');


    
    Route::post('/logout', function () {
        Auth::logout();
        return redirect('/login'); // Redirect to the login page or any other page
    })->name('logout');
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    // Route::get('/intern/apply', [InternController::class, 'apply'])->name('intern.apply');
    // Route::post('/intern/store', [InternController::class, 'store'])->name('intern.store');
});

Route::get('/auth/{provider}/redirect', [SocialiteAuthController::class, 'redirect']);
 
Route::get('/auth/{provider}/callback', [SocialiteAuthController::class, 'callback']);

require __DIR__.'/auth.php';
