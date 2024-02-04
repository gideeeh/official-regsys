<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentRecordsController extends Controller
{
    public function index()
    {
        $studentRecords = Student::query()
            ->select('students.student_id', 'students.student_number', 'students.first_name', 'students.last_name', 'programs.program_code', 'enrollments.year_level')
            ->join('enrollments', 'students.student_id', '=', 'enrollments.student_id')
            ->join('programs', 'enrollments.program_id', '=', 'programs.program_id')
            ->paginate(10);

        return view('admin.student-records', ['students' => $studentRecords]);
    }

    public function show($student_id)
    {
        $studentRecord = Student::findOrFail($student_id);

        return view('admin.indiv-student-record', ['student' => $studentRecord]);
    }

    
}
