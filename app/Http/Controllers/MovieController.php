<?php

namespace MindGeekTest\Http\Controllers;

use MindGeekTest\Movie;

/**
 * Class MovieController
 * @package MindGeekTest\Http\Controllers
 */
class MovieController extends Controller
{
    /**
     * @param Movie $movie
     * @return mixed
     */
    public function show(Movie $movie)
    {
        return view('movie', [
            'movie' => $movie
        ]);
    }
}
