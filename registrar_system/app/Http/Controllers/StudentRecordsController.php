<?php

namespace App\Http\Controllers;

use App\Models\Enrollment;
use App\Models\Program;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudentRecordsController extends Controller
{
    public function index(Request $request)
    {
        $studentsQuery = DB::table('students as s')
            ->join('enrollments as e', 's.student_id', '=', 'e.student_id')
            ->leftJoin('programs as p', 'e.program_id', '=', 'p.program_id') 
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

        $searchTerm = $request->query('query');
        if ($searchTerm) {
            $studentsQuery->where(function ($query) use ($searchTerm) {
                $query->where('s.first_name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('s.last_name', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('s.student_number', 'LIKE', "%{$searchTerm}%")
                      ->orWhere('p.program_code', 'LIKE', "%{$searchTerm}%");
            });
        }

        $studentRecords = $studentsQuery->paginate(10)->withQueryString();

        return view('admin.student-records', [
            'students' => $studentRecords,
            'searchTerm' => $searchTerm,
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

    public function store(Request $request)
    {
        $validated = $request->validate([
           'first_name' => 'required',
           'last_name' => 'required',
           'personal_email' => 'required|unique:students,personal_email',
        ]);

        $new_student = new Student($validated);
        $new_student->first_name = $request->first_name;
        $new_student->middle_name = $request->middle_name;
        $new_student->last_name = $request->last_name;
        $new_student->suffix = $request->suffix;
        $new_student->sex = $new_student->sex;
        $new_student->birthdate = $new_student->birthdate;
        $new_student->birthplace = $new_student->birthplace;
        $new_student->civil_status = $new_student->civil_status;
        $new_student->nationality = $new_student->nationality;
        $new_student->religion = $new_student->religion;
        $new_student->phone_number = $new_student->phone_number;
        $new_student->personal_email = $new_student->personal_email;
        $new_student->school_email = $new_student->school_email;
        $new_student->house_num = $new_student->house_num;
        $new_student->street = $new_student->street;
        $new_student->brgy = $new_student->brgy;
        $new_student->city_municipality = $new_student->city_municipality;
        $new_student->province = $new_student->province;
        $new_student->zipcode = $new_student->zipcode;
        $new_student->guardian_name = $new_student->guardian_name;
        $new_student->guardian_contact = $new_student->guardian_contact;
        $new_student->elementary = $new_student->elementary;
        $new_student->elem_yr_grad = $new_student->elem_yr_grad;
        $new_student->highschool = $new_student->highschool;
        $new_student->hs_yr_grad = $new_student->hs_yr_grad;
        $new_student->college = $new_student->college;
        $new_student->college_year_ended = $new_student->college_year_ended;
        $new_student->is_transferee = $new_student->is_transferee;
        $new_student->is_irregular = $new_student->is_irregular;
        $new_student->save();

        return redirect()->back()->with('success', 'Student added successfully!');
    }
}