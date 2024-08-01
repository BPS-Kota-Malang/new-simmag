<?php

use App\Http\Controllers\AdminAttendanceController;
use App\Http\Controllers\ApplyController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SocialiteAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InternController;
use App\Http\Controllers\AttendanceController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('interns', InternController::class);
    Route::resource('apply', ApplyController::class);
    Route::resource('attendance', AttendanceController::class);
    Route::resource('/admin/attendance', AdminAttendanceController::class,['as' => 'admin']);
    Route::get('/admin/getAttendance', [AdminAttendanceController::class, 'getData'])->name('admin.attendance.getData');
    Route::get('/admin/bulk-set-work-location', [AdminAttendanceController::class, 'showBulkSetWorkLocationForm'])->name('admin.bulkSetWorkLocationForm');
    Route::post('/admin/bulk-set-work-location', [AdminAttendanceController::class, 'bulkSetWorkLocation'])->name('admin.bulkSetWorkLocation');
    Route::post('/markattendance', [AttendanceController::class, 'markAttendance'])->name('attendance.mark');
    Route::get('/apply/accepted/{id}', [ApplyController::class, 'accepted'])->name('apply.accepted');
    Route::get('/apply/rejected/{id}', [ApplyController::class, 'rejected'])->name('apply.rejected');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/intern/apply', [InternController::class, 'apply'])->name('intern.apply');
    // Route::post('/intern/store', [InternController::class, 'store'])->name('intern.store');
});

Route::get('/auth/{provider}/redirect', [SocialiteAuthController::class, 'redirect']);
 
Route::get('/auth/{provider}/callback', [SocialiteAuthController::class, 'callback']);

require __DIR__.'/auth.php';
