<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Project;
use App\Models\User;



class CompanyController extends Controller
{
     /**
     * Display a listing of the resource.
     */
    public function index()
    {
       
        // $companies = Company::all();
        // return view('companies.index', compact('companies'));
        $companies = Company::where('id', '!=', 1)->orderBy('name', 'asc')->get();

        return view('companies.index', compact('companies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('companies.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $company = Company::create([
            'name' => $request->name,
                    ]);   
                    
        // return redirect() -> route('projects.index');
        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Company $company)
    {
        // $company -> load('companies');
        // $company = Company::all();
        $users = User::all();
        $projects = Project::all();
        return view('companies.show', compact('company','projects','users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|max:255',
            ]);
    
            $company->update($request->only('name'));
    
            return redirect()->route('companies.show', $company);
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index');
    }
}
