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
    public function index()
    {
        // $projects = Project::with('company')->latest()->get();
        // $projects = Project::with('company')->orderBy('name', 'asc')->get();
        // return view('projects.index', compact('projects'));

        // Fetch all projects with their company relationships
    $projects = Project::with(['company','liked'])->latest()->get();
    
    // Create a collator for locale-based comparison (set locale to Japanese)
    $collator = new \Collator('ja_JP');

    // Sort the collection using the collator
    $sortedProjects = $projects->sort(function($a, $b) use ($collator) {
        // First compare project names (alphabetically or in Japanese)
        return $collator->compare($a->name, $b->name);
    });

    return view('projects.index', ['projects' => $sortedProjects]);
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
            'completion'=>$request->completion,
            'company_id'=>$request->company_id,
            'design_story'=>$request->design_story,
            'picture_01_link' => $file_name_01 ? '/storage/' . $dir . '/' . $file_name_01 : null,
            'picture_02_link' => $file_name_02 ? '/storage/' . $dir . '/' . $file_name_02 : null,
            'picture_03_link' => $file_name_03 ? '/storage/' . $dir . '/' . $file_name_03 : null,
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
            'address' => 'required|max:255',
            'completion' => 'required|integer',
            'company_id' => 'required|integer',
            'design_story' => 'required',
        ]);
    
        $dir='img';
        $updateData = [
            'name' => $request->name,
            'address' => $request->address,
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
    
        // Fetch all projects' design stories
        $projects = Project::with('company')->get();
    
        // Prepare the design stories for the search
        $designStories = $projects->map(function ($project) {
            return [
                'id' => $project->id,
                'name' => $project->name,
                'company' => $project->company->name,
                'design_story' => $project->design_story,
            ];
        });
    
        // Prepare the prompt for OpenAI to include project name, company name, and design story
        $prompt = "Find all related projects based on the following description and list them in order of relevance: \n\n"
            . $request->search_query . "\n\n"
            . "Here are the available projects with their names, companies, and design stories:\n\n";
    
        foreach ($designStories as $story) {
            $prompt .= "Project: " . $story['name'] . " by " . $story['company'] . "\n";
            $prompt .= "Design Story: " . $story['design_story'] . "\n\n";
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
    
                // **Flexible Matching of Project Names, Companies, or Design Stories**
                $relatedProjects = $projects->filter(function ($project) use ($results) {
                    // Check if any result line contains the project name, company name, or design story
                    foreach ($results as $result) {
                        if (
                            str_contains($result, $project->name) ||
                            str_contains($result, $project->company->name) ||
                            str_contains($result, $project->design_story)
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