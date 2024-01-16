@extends('layouts.app')

@section('content')
    <section class="container">
        <h1>Add a project</h1>
        <main>
            <div id="create-projects" class="container">
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
                        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="mb-3">
                                <label for="title" class="form-label">Title</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                    id="title" name="title" value="{{ old('title') }}" required maxlength="255"
                                    minlength="3">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="body">Body</label>
                                <textarea class="form-control @error('body') is-invalid @enderror" name="body" id="body" cols="30"
                                    rows="10">{{ old('body') }}</textarea>
                                @error('body')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex">
                                <div class="me-3">
                                    <img id="uploadPreview" width="100" src="https://via.placeholder.com/300x200">
                                </div>
                                <div class="mb-3">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                                        name="image" id="image" value="{{ old('image') }}">
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="link" class="form-label">Project Link Url</label>
                                <input type="text" id="link" name="link" value="{{ old('link') }}"
                                    class="form-control @error('link') is-invalid @enderror">
                                @error('link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="type_id" class="form-label">Select Type</label>
                                <select name="type_id" id="type_id" class="form-control">
                                    @foreach ($types as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>
                                    @endforeach
                                </select>
                                @error('type_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-success">Submit</button>
                            <button type="reset" class="btn btn-danger">Reset</button>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </section>
@endsection
