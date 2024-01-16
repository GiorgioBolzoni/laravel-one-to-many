@extends('layouts.app')
@section('content')
    <section class="container my-3" id="item-project">
        <div class="d-flex justify-content-between align-items-center">
            <h1>{{ $project->title }}</h1>
            <p><a href="{{ $project->link }}">{{ $project->link }}</a></p>

            <a href="{{ route('admin.projects.edit', $project->slug) }}" class="btn btn-success px-3">Edit</a>
        </div>
        <div>
            <p>{!! $project->body !!}</p>
            @if ($project->type)
                <div class="mb-3">
                    <h4>Type</h4>
                    <a class="badge text-bg-primary"
                        href="{{ route('admin.types.show', $project->type->slug) }}">{{ $project->type->name }}</a>
                </div>
                <img src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
        </div>
        @endif
    </section>
@endsection
