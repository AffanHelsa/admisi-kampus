<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    protected $fillable = [
        'full_name',
        'email',
        'phone',
        'birth_date',
        'gpa',
        'university_name',
        'university_domain',
        'status'
    ];
}
