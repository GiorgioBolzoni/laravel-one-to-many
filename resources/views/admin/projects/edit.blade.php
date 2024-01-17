@extends('layouts.app')

@section('content')
    <section class="container">
        <h1>Edit {{ $project->title }}</h1>

        <div id="create-projects">

            <div class="container">
                <div class="py-5">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="card p-2">
                        <form action="{{ route('admin.projects.update', $project->slug) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ $project->title }}" required maxlength="255"
                                    minlength="3">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Aggiungi il campo della tipologia -->
                            <div class="mb-3">
                                <label for="type_id">Tipologia</label>
                                <select name="type_id" id="type_id" class="form-control">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}"
                                            {{ $type->id == $project->type_id ? 'selected' : '' }}>
                                            {{ $type->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="body">Body</label>
                                <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" cols="30"
                                    rows="10">{{ old('body', $project->body) }}
                                </textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="d-flex">
                                <div class="media me-4">
                                    <img class="shadow" width="150" src="{{ asset('storage/' . $project->image) }}"
                                        alt="{{ $project->title }}">
                                </div>
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" value="{{ old('image', $project->image) }}">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="link" class="form-label">Project Link Url</label>

                                <input type="text" id="link" name="link" value="{{ $project->link }}"
                                    class="form-control @error('link') is-invalid @enderror">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mt-3">
                                <button type="submit" class="btn btn-success">Save</button>
                                <button type="reset" class="btn btn-primary">Reset</button>
                            </div>

                        </form>
    </section>
@endsection
