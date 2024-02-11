<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function store(Request $request)
    {
        $program = new Program();
        $program->program_code = $request->program_code;
        $program->program_name = $request->program_name;
        $program->program_desc = $request->program_description;
        $program->degree_type = $request->degree_type;
        $program->dept_id = $request->department;
        $program->program_coordinator = $request->program_coordinator;
        $program->total_units = $request->total_units;
        $program->save();
    
        return redirect()->back()->with('success', 'Program added successfully!');
    }

    public function index()
    {
        $departments = Department::all();
        $programs = Program::all(); 
    
        return view('admin.program-list', [
            'departments' => $departments,
            'programs' => $programs
        ]);
    }
    
    public function destroy($program_id)
    {
        $program = Program::find($program_id);
        if ($program) {
            $program->delete();
            return redirect()->back()->with('success', 'Program deleted successfully!');
        } else {
            return redirect()->back()->with('error', 'Program not found!');
        }
    }

    public function update(Request $request, $id)
    {
        $program = Program::find($id);
        if ($program) {
            $program->program_code = $request->program_code;
            $program->program_name = $request->program_name;
            $program->program_desc = $request->program_desc;
            $program->degree_type = $request->degree_type;
            $program->dept_id = $request->department;
            $program->program_coordinator = $request->program_coordinator;
            $program->total_units = $request->total_units;
            $program->save();
    
            return redirect()->back()->with('success', 'Program updated successfully!');
        } else {
            return redirect()->back()->with('error', 'Program not found!');
        }
    }
}
