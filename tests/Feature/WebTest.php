<?php

namespace Tests\Feature;

use MindGeekTest\Movie;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * Class WebTest
 * @package Tests\Feature
 */
class WebTest extends TestCase
{
    /**
     * Test showcase dashboard
     */
    public function testShowcase()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    /**
     * Test movie page
     */
    public function testMovie()
    {
        factory(Movie::class)->create();

        $movie = Movie::query()->first();

        $response = $this->get(route('movie', $movie));

        $response->assertStatus(200);
    }
}
