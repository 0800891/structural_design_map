<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Project;
use App\Models\Company;
use Illuminate\Http\Request;
// use OpenAI\Laravel\Facades\OpenAI;
use GuzzleHttp\Client;
// use OpenAI;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $company_id = $request->input('company_id', 1); // Default to 'All Company' (id=1)

    // Fetch all companies for the dropdown
    $companies = Company::all();

     // Sort companies alphabetically using a collator for locale-aware sorting
     $collator = new \Collator('ja_JP'); // Set locale to Japanese
     $sortedCompanies = $companies->sort(function($a, $b) use ($collator) {
         return $collator->compare($a->name, $b->name);
     });

    // If "All Company" is selected, show all projects; otherwise, filter by company
    if ($company_id == 1) {
        $projects = Project::with(['company', 'liked'])->latest()->get();
    } else {
        $projects = Project::with(['company', 'liked'])
            ->where('company_id', $company_id)
            ->latest()
            ->get();
    }

    // Sort the projects alphabetically as well
    $sortedProjects = $projects->sort(function($a, $b) use ($collator) {
        return $collator->compare($a->name, $b->name);
    });

    return view('projects.index', ['projects' => $sortedProjects, 'companies' => $sortedCompanies, 'selectedCompanyId' => $company_id]);
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
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'completion' => 'required|integer',
            'company_id' => 'required|integer',
            'design_story' => 'required',
            // 'picture_01_link' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'picture_01_link' => 'required|file|mimes:jpeg,png,jpg,gif',
            // 'picture_02_link' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'picture_02_link' => 'required|file|mimes:jpeg,png,jpg,gif',
            // 'picture_03_link' => 'required|file|mimes:jpeg,png,jpg,gif|max:2048',
            'picture_03_link' => 'required|file|mimes:jpeg,png,jpg,gif',
        ]);
        try {
        $dir='img';

        
    if ($request->hasFile('picture_01_link')) {
        $file_01 = $request->file('picture_01_link');
        $file_name_01 = time().'_'.$file_01->getClientOriginalName();
        $file_01->storeAs('public/' . $dir, $file_name_01);
    } else {
        $file_name_01 = null;
    }

    // Handle the second image upload
    if ($request->hasFile('picture_02_link')) {
        $file_02 = $request->file('picture_02_link');
        $file_name_02 = time().'_'.$file_02->getClientOriginalName();
        $file_02->storeAs('public/' . $dir, $file_name_02);
    } else {
        $file_name_02 = null;
    }

    // Handle the third image upload
    if ($request->hasFile('picture_03_link')) {
        $file_03 = $request->file('picture_03_link');
        $file_name_03 = time().'_'.$file_03->getClientOriginalName();
        $file_03->storeAs('public/' . $dir, $file_name_03);
    } else {
        $file_name_03 = null;
    }

        $project = Project::create([
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'completion'=>$request->completion,
            'company_id'=>$request->company_id,
            'design_story'=>$request->design_story,
            'picture_01_link' => $file_name_01 ? '/storage/' . $dir . '/' . $file_name_01 : null,
            'picture_02_link' => $file_name_02 ? '/storage/' . $dir . '/' . $file_name_02 : null,
            'picture_03_link' => $file_name_03 ? '/storage/' . $dir . '/' . $file_name_03 : null,
                    ]);   

                session()->flash('success', 'Project registered successfully!');
                } catch (\Exception $e) {
                session()->flash('error', 'Failed to register project. Please try again.');
                }
               
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
        // Check if the method is reached
       
        $request->validate([
            'name' => 'required|max:255',
            'address' => 'required|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'completion' => 'required|integer',
            'company_id' => 'required|integer',
            'design_story' => 'required',
        ]);


    try{

        $dir='img';
        $updateData = [
            'name' => $request->name,
            'address' => $request->address,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'completion' => $request->completion,
            'design_story' => $request->design_story,
        ];
    
        if ($request->hasFile('picture_01_link')) {
            $file_01 = $request->file('picture_01_link');
            $file_name_01 = time().'_'.$file_01->getClientOriginalName();
            $file_01->storeAs('public/' . $dir, $file_name_01);
            $updateData['picture_01_link'] = '/storage/' . $dir . '/' . $file_name_01;
        }
    
        if ($request->hasFile('picture_02_link')) {
            $file_02 = $request->file('picture_02_link');
            $file_name_02 = time().'_'.$file_02->getClientOriginalName();
            $file_02->storeAs('public/' . $dir, $file_name_02);
            $updateData['picture_02_link'] = '/storage/' . $dir . '/' . $file_name_02;
        }
    
        if ($request->hasFile('picture_03_link')) {
            $file_03 = $request->file('picture_03_link');
            $file_name_03 = time().'_'.$file_03->getClientOriginalName();
            $file_03->storeAs('public/' . $dir, $file_name_03);
            $updateData['picture_03_link'] = '/storage/' . $dir . '/' . $file_name_03;
        }
    
        $project->update($updateData);
        session()->flash('success', 'Project updated successfully!');
    } catch (\Exception $e) {
        session()->flash('error', 'Failed to update project. Please try again.');
    }
    
        return redirect()->route('projects.show', $project);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index');
    }

    public function dashboard()
{
    // Get the logged-in user
    $user = auth()->user();

    // Fetch the projects liked by the user
    $likedProjects = $user->likes()->with('company')->orderBy('name', 'asc')->get();

    // Pass the liked projects to the dashboard view
    return view('dashboard', compact('likedProjects'));
}

    /**
     * OpenAI Search for projects based on user input.
     */
    public function openai_search(Request $request)
    {
        \Log::info('OpenAI Search initiated');
    
        // Explicitly retrieve the API key from the .env file
        $apiKey = env('OPENAI_API_KEY');
        if (empty($apiKey)) {
            \Log::error('OpenAI API key is missing or not set.');
            return back()->withErrors(['message' => 'API key is missing.']);
        }
    
        // Validate the search query
        $request->validate([
            'search_query' => 'required|string|max:255',
        ]);
    
        // Fetch all projects with related company information
        $projects = Project::with('company')->get();
    
        // Prepare the data (including name, company name, design story, address, and completion year)
        $projectDetails = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'company' => $project->company->name,
                'design_story' => $project->design_story,
                'address' => $project->address,
                'completion' => $project->completion,
            ];
        });
    
        // Prepare the prompt for OpenAI to include all relevant fields
        $prompt = "Find all related projects based on the following description and list them in order of relevance: \n\n"
            . $request->search_query . "\n\n"
            . "Here are the available projects with their names, companies, design stories, addresses, and completion years:\n\n";
    
        foreach ($projectDetails as $detail) {
            $prompt .= "Project: " . $detail['name'] . " by " . $detail['company'] . "\n";
            $prompt .= "Design Story: " . $detail['design_story'] . "\n";
            $prompt .= "Address: " . $detail['address'] . "\n";
            $prompt .= "Completion Year: " . $detail['completion'] . "\n\n";
        }
    
        try {
            // Use the OpenAI API
            $client = new Client();
            $response = $client->post('https://api.openai.com/v1/chat/completions', [
                'headers' => [
                    'Authorization' => 'Bearer ' . $apiKey,
                    'Content-Type' => 'application/json',
                ],
                'json' => [
                    'model' => 'gpt-4o-mini',  // Use a valid model like gpt-3.5-turbo
                    'messages' => [
                        ['role' => 'system', 'content' => 'You are a helpful assistant.'],
                        ['role' => 'user', 'content' => $prompt],
                    ],
                    'max_tokens' => 1000,
                    'temperature' => 0.5,
                ],
            ]);
    
            $body = json_decode($response->getBody(), true);
    
            if (isset($body['choices'][0]['message']['content'])) {
                $gptResponse = $body['choices'][0]['message']['content'];
                \Log::info('GPT Response Text:', [$gptResponse]);
    
                // Split the response text into lines and remove any unwanted characters
                $results = array_filter(array_map('trim', explode("\n", $gptResponse)));
    
                \Log::info('Processed Results:', $results);
    
                // Flexible matching of project fields
                $relatedProjects = $projects->filter(function ($project) use ($results) {
                    // Check if any result line contains the project name, company name, design story, address, or completion year
                    foreach ($results as $result) {
                        if (
                            str_contains($result, $project->name) ||
                            str_contains($result, $project->company->name) ||
                            str_contains($result, $project->design_story) ||
                            str_contains($result, $project->address) ||
                            str_contains($result, $project->completion)
                        ) {
                            return true;
                        }
                    }
                    return false;
                });
    
                // Return the filtered projects to the view (no limit applied)
                return view('projects.search', ['projects' => $relatedProjects]);
    
            } else {
                \Log::error('OpenAI response missing message content');
                return back()->withErrors(['message' => 'Error in OpenAI response.']);
            }
    
        } catch (\Exception $e) {
            \Log::error('OpenAI API error: ' . $e->getMessage());
            return back()->withErrors(['message' => 'Error occurred during OpenAI request.']);
        }
    }
    
}