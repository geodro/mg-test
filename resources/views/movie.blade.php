@extends('layouts.default')

@section('content')
    <div class="row">
        <div class="col">
            <h1>{{ $movie->headline }}</h1>
        </div>
    </div>

    @if(count($movie->cardImages))
        <div class="row mb-1">
            <div class="col">
                <div id="carouselIndicators" class="carousel slide mb-10" data-ride="carousel">
                    <ol class="carousel-indicators">
                        @foreach($movie->cardImages as $key => $image)
                            <li data-target="#carouselIndicators" data-slide-to="{{ $key }}"
                                @if($loop->first) class="active" @endif></li>
                        @endforeach
                    </ol>
                    <div class="carousel-inner">
                        @foreach($movie->cardImages as $image)
                            <div class="carousel-item @if($loop->first) active @endif" style="height: 360px">
                                <img class="d-block w-100" src="{{ $image['url'] }}">
                            </div>
                        @endforeach
                    </div>
                    <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </a>
                </div>
            </div>
        </div>
    @endif

    <div class="row mb-5">
        <div class="col">
            <b>{{ $movie->year }}</b> | Running time: <b>{{ $movie->duration/60 }} min</b> | Certificate:
            <b>{{ $movie->cert }}</b> @if($movie->rating)| Rating: <b>{{ $movie->rating }}</b>@endif @if($movie->genres)
                | Genre:
                <b>{{ implode(', ', $movie->genres) }}</b>@endif | Class: <b>{{ $movie->class }}</b>
        </div>
    </div>

    <div class="row">
        @if(count($movie->keyArtImages))
            <div class="col-auto">
                @foreach($movie->keyArtImages as $image)
                    <img src="{{ $image->url }}" class="rounded thumbnail">
                @endforeach
            </div>
        @endif

        <div class="col">

            <h3>Synopsis</h3>
            <p>{{ $movie->synopsis }}</p>

            <h3>Review</h3>
            @foreach(explode("\n", $movie->body) as $paragraf)
                <p>{{ $paragraf }}</p>
            @endforeach

            <blockquote class="blockquote">
                <p>{{ $movie->quote }}</p>
                @if($movie->reviewAuthor)
                    <footer class="blockquote-footer">{{ $movie->reviewAuthor }}</footer>
                @endif
            </blockquote>

            <br>

            <p>
                @if($movie->skyGoUrl)<a href="{{ $movie->skyGoUrl }}" target="_blank" class="btn btn-primary">view
                    movie</a>@endif
                <a href="{{ $movie->url }}" target="_blank" class="btn btn-primary">view review</a>
            </p>
        </div>

        <div class="col-auto">
            <div class="row">
                @if(count($movie->cast))
                    <div class="col">
                        <h3>Cast</h3>
                        @foreach($movie->cast as $cast)
                            <p>{{ $cast['name'] }}</p>
                        @endforeach
                    </div>
                @endif

                @if(count($movie->directors))
                    <div class="col">
                        <h3>Directors</h3>
                        @foreach($movie->directors as $director)
                            <p>{{ $director['name'] }}</p>
                        @endforeach
                    </div>
                @endif
            </div>
            @if($movie->viewingWindow)
                <div class="row">
                    <div class="col">
                        <table class="table">
                            <tbody>
                            @if(isset($movie->viewingWindow['title']))
                                <tr>
                                    <th scope="row">Title</th>
                                    <td>{{ $movie->viewingWindow['title'] }}</td>
                                </tr>
                            @endif
                            <tr>
                                <th scope="row">Where to watch</th>
                                <td>{{ $movie->viewingWindow['wayToWatch'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">From</th>
                                <td>{{ $movie->viewingWindow['startDate'] }}</td>
                            </tr>
                            <tr>
                                <th scope="row">Until</th>
                                <td>{{ $movie->viewingWindow['endDate'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

    </div>

    @foreach($movie->videos as $video)
        <div class="row justify-content-md-center mb-2">
            <div class="col-auto">
                <video id="my-video" class="video-js" controls preload="auto"
                       poster="{{ $movie->keyArtImages->random()->url }}" data-setup="{}">
                    <source src="{{ $video['url'] }}" type='video/mp4'>
                </video>
            </div>
        </div>
    @endforeach

    <div class="row">
        <div class="col">&nbsp;</div>
    </div>
@endsection

@section('footer')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>
    <script src="http://vjs.zencdn.net/6.6.3/video.js"></script>
    <script>
        $(document).ready(function () {
            $('.carousel').carousel();
        });
    </script>
@endsection