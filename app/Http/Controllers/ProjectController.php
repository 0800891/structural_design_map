<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Company;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('company')->latest()->get();
        return view('projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $request ->validate([
        //     'tweet' => 'required|max:255',
        //     ]);
        $project = Project::create([
            'name' => $request->name,
            'address' => $request->address,
            'completion'=>$request->completion,
            'company_id'=>$request->company_id,
            'design_story'=>$request->design_story,
            'picture_01_link'=>$request->picture_01_link,
            'picture_02_link'=>$request->picture_02_link,
            'picture_03_link'=>$request->picture_03_link
                    ]);   
                    
        // return redirect() -> route('projects.index');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        // $projects = Project::all();
        // $companies = Company::all();
        // return view('projects.show', compact('projects','companies'));
        $company = $project->company; // Retrieve the related company

        return view('projects.show', compact('project', 'company'));
    }
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'name' => 'required|max:255',
            'address'=>'required|max:255',
            'completion'=>'required|integer',
            'company_id'=>'required|integer',
            'design_story'=>'required',
            ]);
    
            // $project->update($request->only('name'));
            $project->update($request->only(['name','address','completion','company_id','design_story','picture_01_link','picture_02_link','picture_03_link']));
    
            return redirect()->route('projects.show', $project);
        }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
       //
    }
}
