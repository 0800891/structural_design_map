<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Company;

class MapController extends Controller
{
    public function index(){
        $projects = Project::with('company')->get(); // Fetch projects
        // $companies = Company::all();
        // $projectIndexes = $projects->pluck('id','name','address','completion')->toArray(); // Get the indexes or any required data
    
        $combinedData = $projects->map(function($project){
            return [
                'id'=> $project->id,
                'name'=> $project->name,
                'address'=>$project->address,
                'completion'=>$project->completion,
                'design_story'=>$project->design_story,
                'picture_01_link'=>$project->picture_01_link,
                'picture_02_link'=>$project->picture_02_link,
                'picture_03_link'=>$project->picture_03_link,
                'created_at'=>$project->created_at,
                'updated_at'=>$project->updated_at,
                'company'=>[
                    'id'=>$project->company->id,
                    'name'=>$project->company->name,
                ],
            ];
        });
        // $json_project = json_encode($projects, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE); 
        // $json_company = json_encode($companies, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
         // Encode combined data as JSON
         $jsonData = json_encode($combinedData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        // Return the JSON response
        // return response()->json($combinedData);
        return view('maps.index', compact('projects','jsonData')); // Pass to Blade view
    }

}
