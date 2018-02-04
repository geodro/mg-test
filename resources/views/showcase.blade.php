@extends('layouts.default')

@section('content')

    @foreach($movies->chunk(5) as $items)
        <div class="row">
            <div class="col">
                <div class="card-deck">

                    @foreach($items as $movie)
                        <div class="card mb-4 box-shadow">
                            @if(count($movie->keyArtImages))
                                <img class="card-img-top"
                                     alt="{{ $movie->headline }}"
                                     src="{{ $movie->keyArtImages->random()->url }}">
                            @endif
                            <div class="card-body">
                                <p class="card-text">{{ $movie->headline }}</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="btn-group">
                                        <a href="{{ route('movie', $movie) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                    </div>
                                    <small class="text-muted">{{ $movie->duration/60 }} mins</small>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>

        </div>
    @endforeach

    <div class="row">
        <div class="col">
            {{ $movies->links() }}
        </div>
    </div>
@endsection