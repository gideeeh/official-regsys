<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index() {
        $subjects = Subject::with(['prerequisite1', 'prerequisite2', 'prerequisite3'])
            ->get();
            
        return view('subjects', ['subjects' => $subjects]);
    }
}
