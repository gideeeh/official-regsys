<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $table = 'students';
    protected $primaryKey = 'student_id';
    protected $fillable = [
        'student_number',
        'user_id',
        'first_name',
        'middle_name',
        'last_name',
        'suffix',
        'sex',
        'birthdate',
        'birthplace',
        'civil_status',
        'nationality',
        'religion',
        'phone_number',
        'personal_email',
        'school_email',
        'house_num',
        'street',
        'brgy',
        'city_municipality',
        'province',
        'zipcode',
        'guardian_name',
        'guardian_contact',
        'elementary',
        'elem_yr_grad',
        'highschool',
        'hs_yr_grad',
        'college',
        'collge_year_ended',
        'is_transferee',
        'is_irregular',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'student_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function latestEnrollment()
    {
        return $this->hasOne(Enrollment::class, 'student_id')->latest();
    }

    public function notes()
    {
        return $this->hasMany(StudentNote::class, 'student_id')->orderByDesc('created_at');
    }
}
