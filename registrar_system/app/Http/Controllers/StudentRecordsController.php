<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentRecordsController extends Controller
{
    public function index(Request $request)
    {
        // Define the base query with joins and aggregation
        $studentsQuery = DB::table('students as s')
            ->join('enrollments as e', 's.student_id', '=', 'e.student_id')
            ->join('programs as p', 'e.program_id', '=', 'p.program_id')
            ->select(
                's.student_id',
                's.student_number',
                's.first_name',
                's.middle_name',
                's.last_name',
                's.suffix',
                'p.program_code',
                DB::raw('MAX(e.year_level) as year_level')
            )
            ->groupBy('s.student_id', 's.student_number', 's.first_name', 's.middle_name', 's.last_name', 's.suffix', 'p.program_code');

        // Apply search filter if provided
        $searchTerm = $request->query('query');
        if ($searchTerm) {
            $studentsQuery->where(function ($query) use ($searchTerm) {
                $query->where('s.first_name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('s.last_name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('s.student_number', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('p.program_code', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Paginate the query results
        $studentRecords = $studentsQuery->paginate(10)->withQueryString();

        // Return the view with the paginated student records and search term
        return view('admin.student-records', [
            'students' => $studentRecords,
            'searchTerm' => $searchTerm
        ]);
    }
    

    public function show($student_id)
    {
        $latestEnrollment = Student::with(['latestEnrollment', 'latestEnrollment.program', 'notes'])->findOrFail($student_id);
        $student = Student::findOrFail($student_id);
        // $latestYearLevel = $student->enrollments()->orderByDesc('year_level')->first()->year_level ?? null;
        $enrollmentDetails = DB::table('enrollments as e')
        ->join('students as s', 'e.student_id', '=', 's.student_id')
        ->join('enrolled_subjects as esj', 'e.enrollment_id', '=', 'esj.enrollment_id')
        ->join('subjects as sj', 'esj.subject_id', '=', 'sj.subject_id')
        ->leftJoin('subjects as pr1', 'sj.prerequisite_1', '=', 'pr1.subject_id')
        ->leftJoin('subjects as pr2', 'sj.prerequisite_2', '=', 'pr2.subject_id')
        ->select(
            's.student_id',
            's.student_number',
            'sj.subject_code',
            'sj.subject_name',
            'pr1.subject_name as Prerequisite_Name_1',
            'pr2.subject_name as Prerequisite_Name_2',
            'e.year_level',
            'e.term',
            'sj.units_lec',
            'sj.units_lab',
            DB::raw('(sj.units_lec + sj.units_lab) AS TOTAL'),
            'esj.final_grade'
        )
        ->where('s.student_id', $student_id)
        ->orderByDesc('e.year_level')
        ->orderByDesc('e.term')
        ->orderBy('sj.subject_name')
        ->get();
    
        return view('admin.indiv-student-record', [
            'student' => $student,
            'latestEnrollment' => $latestEnrollment,
            'enrollmentDetails' => $enrollmentDetails
        ]);
    }

    
}