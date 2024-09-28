<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Company;

class MapController extends Controller
{
    public function index(Request $request){
    // Default to 'All Company' (id=1)
        $company_id = $request->input('company_id', 1);

        $companies = Company::all();
    // Sort companies alphabetically using a collator for locale-aware sorting (Japanese support)
        $collator = new \Collator('ja_JP'); 
        $sortedCompanies = $companies->sort(function($a, $b) use ($collator) {
        return $collator->compare($a->name, $b->name);
        });

        // Fetch projects with their related companies
    if ($company_id == 1) {
        // If "ALL Company" is selected, get all projects
        $projects = Project::with('company')->get();
    } else {
        // Otherwise, filter by the selected company
        $projects = Project::with('company')
            ->where('company_id', $company_id)
            ->get();
    }

    // Combine the data for JSON
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
                'latitude'=>$project->latitude,
                'longitude'=>$project->longitude,
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

         $projectId = $request->query('project_id'); // Get the project ID from the query parameters
         if ($projectId) {
             session()->flash('projectId', $projectId); // Flash project ID to the session

              // Redirect to the same route but without the project_id query parameter
            return redirect()->route('maps.index'); // This will remove the query string
         }
    
        return view('maps.index', [
            'projects' => $projects,
            'jsonData' => $jsonData,
            'companies' => $sortedCompanies, // Sorted companies
            'selectedCompanyId' => $company_id // Pass the selected company ID to the view
        ]); // Pass to Blade view
    }

}
