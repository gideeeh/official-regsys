<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Program_Semester_Subject extends Model
{
    use HasFactory;

    protected $table = 'program_semester_subjects';
    protected $primaryKey = 'id';
    protected $fillable = [
        'program_id',
        'term',
        'subject_id',
        'year_created',
        'version',
    ];

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }

    public function program()
    {
        return $this->belongsTo(Program::class, 'program_id');
    }
}
