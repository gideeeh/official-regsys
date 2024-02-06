<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CourseListingsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnrollmentsController;
use App\Http\Controllers\FacultyRecordsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudentRecordsController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserDashboardController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect('/admin/dashboard'); // Redirect admins to the admin dashboard
        } else {
            return redirect('/user/dashboard'); // Redirect regular users to the user dashboard
        }
    } else {
        return redirect()->route('login'); // Redirect guests to the login page
    }
});

Route::get('/departments', [DepartmentController::class, 'index']);
Route::get('/subjects', [SubjectController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->name('user.dashboard');
});

Route::middleware(['auth','isAdminUser'])->group(function() {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/student-records', [StudentRecordsController::class, 'index'])->name('student-records');
    Route::get('/admin/student-records/{student}', [StudentRecordsController::class, 'show'])->name('student-records.show');

    Route::get('/admin/faculty-records', [FacultyRecordsController::class, 'index'])->name('faculty-records');
    Route::get('/admin/faculty-records/{faculty}', [FacultyRecordsController::class, 'show'])->name('faculty-records.show');
    
    Route::get('/admin/course-listings', [CourseListingsController::class, 'index'])->name('course-listings');
    Route::get('/admin/course-listings/{course}', [CourseListingsController::class, 'show'])->name('course-listings.show');

    Route::get('/admin/enrollment-records', [EnrollmentsController::class, 'index'])->name('enrollment-records');
    Route::get('/admin/enrollment-records/{enrollment_id}', [EnrollmentsController::class, 'show'])->name('enrollment-records.show');
});

require __DIR__.'/auth.php';
