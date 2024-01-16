@extends('layouts.app')
@section('content')
    <section class="container my-3" id="item-project">
        <div class="d-flex justify-content-between align-items-center">
            <h1>{{ $project->title }}</h1>
            <p><a href="{{ $project->link }}">{{ $project->link }}</a></p>
            <p>{{ $project->body }}</p>
        </div>
        <div>
            @if ($project->image)
                <div>
                    <img class="card-img-top" src="{{ asset('storage/' . $project->image) }}" alt="{{ $project->title }}">
                </div>
            @endif
        </div>
        </div>

        </div>


    </section>
@endsection
