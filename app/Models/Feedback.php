<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'user_id',
        'search_query',
        'feedback',
        'comment',
    ];

    public function user(){
        return $this -> belongsTo(User::class);
    }

    public function project(){
        return $this -> belongsTo(Project::class);
    }

}
