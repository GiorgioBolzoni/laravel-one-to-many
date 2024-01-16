<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Type;
use App\Http\Requests\StoreTypeRequest;
use App\Http\Requests\UpdateTypeRequest;
use Illuminate\Support\Str;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Type::all();
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTypeRequest $request)
    {
        $formData = $request->validated();
        //CREATE SLUG
        $slug = Str::of($formData['name'])->slug('-');
        //add slug to formData
        $formData['slug'] = $slug;
        $type = Type::create($formData);
        return redirect()->route('admin.categories.show', $type->slug);
    }

    /**
     * Display the specified resource.
     */
    public function show(Type $type)
    {
        return view('admin.categories.show', compact('type'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        return view('admin.categories.edit', compact('type'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $formData = $request->validated();
        $formData['slug'] = $type->slug;

        if ($type->name !== $formData['name']) {
            //CREATE SLUG
            $slug = Str::of($formData['name'])->slug('-');
            $formData['slug'] = $slug;
        }
        $type->update($formData);
        return redirect()->route('admin.categories.show', $type->slug);

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Type $type)
    {
        $type->delete();
        return to_route('admin.categories.index')->with('message', "$type->name eliminato con successo");
    }
}
