<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Academic_Year extends Model
{
    use HasFactory;

    protected $table = 'academic_years';

    protected $primaryKey = 'id';

    protected $fillable = [ 
        'acad_year', 
        'acad_year_start', 
        'acad_year_end', 
    ];

    public function terms()
    {
        return $this->hasMany(Term::class, 'acad_year_id');
    }
}
