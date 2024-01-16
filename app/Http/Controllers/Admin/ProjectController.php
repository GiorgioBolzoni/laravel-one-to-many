<?php

namespace App\Http\Controllers\Admin;

use App\Models\Project;
use App\Models\Type;

use Illuminate\Http\Request;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;



class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {


        if (!empty($request->query('search'))) {
            $search = $request->query('search');
            $projects = Project::where('title', 'like', $search . '%')->get();

        } else {
            $projects = Project::all();

        }


        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $types = Type::all();
        return view('admin.projects.create', compact('types'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProjectRequest $request)
    {
        $form_data = $request->validated();

        // Aggiungere la chiave 'type_id' alle regole di validazione se non è già presente
        $request->merge(['type_id' => $request->input('type_id', null)]);

        // Generare lo slug e l'ID utente
        $slug = Project::getSlug($form_data['title']);
        $userId = auth()->id();

        // Aggiungere lo slug e l'ID utente ai dati del modulo
        $form_data['slug'] = $slug;
        $form_data['user_id'] = $userId;

        // Gestire l'upload dell'immagine
        if ($request->hasFile('image')) {
            $name = Str::slug($form_data['title'], '-') . '.jpg';
            $img_path = Storage::putFileAs('images', $form_data['image'], $name);
            $form_data['image'] = $img_path;
        }

        // Ottenere l'ID della tipologia dal modulo
        $type_id = $request->input('type_id');

        // Salvataggio dell'associazione progetto-tipologia
        $type = Type::find($type_id);

        if ($type) {
            $newProject = Project::create($form_data);
            $newProject->type()->associate($type);
            $newProject->save();

            return redirect()->route('admin.projects.index')->with('success', 'Project created successfully');
        } else {
            return redirect()->back()->with('error', 'Invalid type selected');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {

        $types = Type::all();

        return view('admin.projects.edit', compact('project', 'types'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProjectRequest $request, Project $project)
    {
        $form_data = $request->validated();

        if ($project->title !== $form_data['title']) {
            $slug = Project::getSlug($form_data['title']);
            $form_data['slug'] = $slug;

        }


        $form_data['user_id'] = $project->user_id;

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::delete($project->image);
            }
            $name = Str::slug($form_data['title'], '-') . '.jpg';
            $img_path = Storage::putFileAs('images', $form_data['image'], $name);

            $form_data['image'] = $img_path;
        }

        $project->update($form_data);

        return redirect()->route('admin.projects.show', $project->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        $project->delete();
        if ($project->image) {
            Storage::delete($project->image);
        }
        return redirect()->route('admin.projects.index')->with('message', "The project '$project->title' has been deleted");
    }
}
