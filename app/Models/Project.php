<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'completion',
        'company_id',
        'design_story',
        'company_id',
        'picture_01_link',
        'picture_02_link',
        'picture_03_link',
    ];

    public function company(){
        return $this -> belongsTo(Company::class);
    }
}
