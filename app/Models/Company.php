<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'homepage',  // Add this line to make homepage fillable
    ];

    public function user(){
        return $this -> hasMany(User::class);
    }

    public function project(){
        return $this -> hasMany(Project::class);
    }
}
