<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Models\ServiceCategory;
use App\Models\ServiceType;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Project::with('serviceCategory')->latest()->get();

        return view('project.index', compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $serviceType = ServiceType::all();
        $serviceCategory = ServiceCategory::all();
        return view('project.create', compact('serviceCategory', 'serviceType'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreProjectRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $file = $request->file('image');
        $ext = $file->extension();
        $imagePath = $file->storeAs('/project_images', now()->timestamp . '.' . $ext, ['disk' => 'public_uploads']);

        Project::create([
            'service_category_id' => $request->service_category_id,
            'title' => $request->title,
            'description' => $request->description,
            'image' => $imagePath,
            'clientName' => $request->clientName,
            'location' => $request->location,
            'duration' => $request->duration,
            'sln' => $request->sln,
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('project.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        $serviceType = ServiceType::all();
        $serviceCategory = ServiceCategory::all();

        return view('project.edit', compact('project', 'serviceType', 'serviceCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateProjectRequest $request
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $imagePath = $project->image;

        if ($request->image) {
            $file = $request->file('image');
            $ext = $file->extension();
            $imagePath = $file->storeAs('/project_images', now()->timestamp . '.' . $ext, ['disk' => 'public_uploads']);
        }

        $updateArray['service_category_id'] = $request->service_category_id;
        $updateArray['title'] = $request->title;
        $updateArray['description'] = $request->description;
        $updateArray['image'] = $imagePath;
        $updateArray['clientName'] = $request->clientName;
        $updateArray['location'] = $request->location;
        $updateArray['duration'] = $request->duration;
        $updateArray['sln'] = $request->sln;

        $project->update($updateArray);

        return redirect()->route('projects.index')
            ->with('success', 'Project updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
    }

    public function projectList()
    {
        $projects = Project::with('serviceCategory', 'serviceCategory.serviceType')
            ->orderBy('projects.sln')
            ->get();

        return response()->json([
            "success" => true,
            "message" => "project List",
            "data" => $projects
        ]);
    }

    public function projectDetails($id)
    {
        $project = Project::with('serviceCategory', 'serviceCategory.serviceType')
            ->where('id', $id)
            ->first();

        return response()->json([
            "success" => true,
            "message" => "project Details",
            "data" => $project
        ]);
    }

    public function categoryWiseProject($id)
    {
        $project = Project::where('service_category_id', $id)->get();

        return response()->json([
            "success" => true,
            "message" => "projects",
            "data" => $project
        ]);
    }
}
