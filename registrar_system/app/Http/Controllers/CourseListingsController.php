<?php

namespace App\Http\Controllers;

use App\Models\Program;
use Illuminate\Http\Request;

class CourseListingsController extends Controller
{
    public function index(Request $request)
    {
        $query = Program::query()
            ->select('programs.program_id','programs.program_code','programs.program_name', 'programs.degree_type', 'departments.dept_name', 'programs.total_units','programs.status')
            ->join('departments', 'programs.dept_id', '=', 'departments.dept_id');
    
        $searchTerm = $request->query('query');
        if ($searchTerm) {
            $query->where(function ($query) use ($searchTerm) {
                $query->where('programs.program_code', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('programs.program_name', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('programs.degree_type', 'LIKE', "%{$searchTerm}%")
                    ->orWhere('departments.dept_name', 'LIKE', "%{$searchTerm}%");
            });
        }
    
        $courseListings = $query->paginate(10)->withQueryString(); 
    
        return view('admin.course-listings', [
            'courses' => $courseListings,
            'searchTerm' => $searchTerm 
        ]);
    }
}
