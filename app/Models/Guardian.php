<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;

class Guardian extends Model
{
    use HasFactory, HasApiTokens;

    protected $guarded = ['id'];

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}
