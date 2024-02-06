<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentRecordsController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query()
            ->select('students.student_id', 'students.student_number', 'students.first_name', 'students.last_name', 'programs.program_code', 'enrollments.year_level')
            ->join('enrollments', 'students.student_id', '=', 'enrollments.student_id')
            ->join('programs', 'enrollments.program_id', '=', 'programs.program_id');
    
        $searchTerm = $request->query('query');
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('students.first_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('students.last_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('students.student_number', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('programs.program_code', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        $studentRecords = $query->paginate(10)->withQueryString(); 
    
        return view('admin.student-records', [
            'students' => $studentRecords,
            'searchTerm' => $searchTerm 
        ]);
    }
    
    public function show($student_id)
    {
        $studentRecord = Student::with(['latestEnrollment', 'latestEnrollment.program'])->findOrFail($student_id);
        return view('admin.indiv-student-record', ['student' => $studentRecord]);
    }
}