<?php

use App\Http\Controllers\AcademicCalendarController;
use App\Http\Controllers\AcademicYearController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\CourseListingsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EnrollmentsController;
use App\Http\Controllers\FacultyRecordsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProgramSubjectController;
use App\Http\Controllers\RegistrarFunctionsController;
use App\Http\Controllers\StudentNoteController;
use App\Http\Controllers\StudentRecordsController;
use App\Http\Controllers\SubjectCatalogController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\UserDashboardController;
use App\Livewire\ProgramAndCourseManagement;
use App\Models\Student;
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

/* Admin Middleware */
Route::middleware(['auth','isAdminUser'])->group(function() {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
/* Student Records */
    Route::get('/admin/student-records', [StudentRecordsController::class, 'index'])->name('student-records');
    Route::get('/admin/student-records/{student}', [StudentRecordsController::class, 'show'])->name('student-records.show');
    Route::get('/student/student-records/add_student', function () {
        return view('admin.add-student');
    })->name('student.add');
    Route::post('/student/student-records/add_student', [StudentRecordsController::class, 'store'])->name('student.store');
    Route::post('/student/{student_id}/notes', [StudentNoteController::class, 'store'])->name('student-notes.store');
/* Faculty Records */
    Route::get('/admin/faculty-records', [FacultyRecordsController::class, 'index'])->name('faculty-records');
    Route::get('/admin/faculty-records/{faculty}', [FacultyRecordsController::class, 'show'])->name('faculty-records.show');
/* Subject Profile */
    Route::get('/admin/course-listings', [CourseListingsController::class, 'index'])->name('course-listings');
    Route::get('/admin/course-listings/{course}', [CourseListingsController::class, 'show'])->name('course-listings.show');
/* Enrollments */
    Route::get('/admin/enrollment-records', [EnrollmentsController::class, 'index'])->name('enrollment-records');
    Route::get('/admin/enrollment-records/{enrollment_id}', [EnrollmentsController::class, 'show'])->name('enrollment-records.show');
/* Program Management */
    Route::get('/admin/functions/program-course-management/program_list', [ProgramController::class, 'index'])->name('program-list');
    /* Sub - Program Profile */
    Route::get('/admin/functions/program-course-management/program_list/{program_id}', [ProgramController::class, 'show'])->name('program-list.show');
    Route::get('/admin/functions/program-course-management/program_list/{program_id}/assign_subject', [SubjectController::class, 'search'])->name('program-lists-subjects.search');
    Route::get('/admin/functions/get-subjects', [SubjectController::class, 'search'])->name('gimme-subjects');
    Route::get('/program/{program_id}/subjects/{year}/{term}', [ProgramSubjectController::class, 'fetchSubjects'])->name('fetch.subjects');
    Route::post('/admin/functions/program-course-management/program_list/save-program', [ProgramController::class, 'store'])->name('program-lists-new-program');    
    Route::post('/admin/functions/program-course-management/program_list/{program_id}/save-assign_subject', [ProgramSubjectController::class, 'store'])->name('program-subject.save');
    Route::delete('/admin/functions/program-course-management/program_list/delete-program/{program_id}', [ProgramController::class, 'destroy'])->name('program-lists-delete-program');
    Route::patch('/admin/functions/program-course-management/program_list/update-program/{id}', [ProgramController::class, 'update'])->name('program-lists-update-program');
/* Subject Catalog */
    Route::get('/admin/functions/program-course-management/subject_catalog', [SubjectCatalogController::class, 'index'])->name('subject-catalog');
    Route::post('/admin/functions/program-course-management/subject_catalog/save-subject', [SubjectCatalogController::class, 'store'])->name('subject-catalog-new-subject');
/* Academic Calendar */
    Route::get('/admin/functions/program-course-management/academic_calendar', [AcademicCalendarController::class, 'index'])->name('academic-calendar');
    Route::post('/admin/functions/program-course-management/academic_calendar/add-event', [AcademicCalendarController::class, 'store'])->name('academic-calendar-add-event');
    Route::post('admin/functions/program-course-management/academic_calendar/set-acad-year',[AcademicYearController::class, 'store'])->name('acad-year-set');

});

require __DIR__.'/auth.php';
