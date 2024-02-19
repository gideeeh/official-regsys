<?php

namespace App\Http\Controllers;

use App\Models\Program_Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ProgramSubjectController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'program_id' => 'required|exists:programs,program_id',
            'year' => 'required',
            'term' => 'required',
            'subject_ids' => 'required|array',
            'subject_ids.*' => 'exists:subjects,subject_id' // Ensure each subject ID exists
        ]);
        
        $programId = $request->program_id;
        $year = $request->year;
        $term = $request->term;
        
        foreach ($request->subject_ids as $subjectId) {
            Program_Subject::create([
                'program_id' => $programId,
                'subject_id' => $subjectId,
                'year' => $year,
                'term' => $term,
            ]);
        }
        
        Log::info('Request data:', $request->all());
        return back()->with('success', 'Subjects updated successfully.');
    }
}
