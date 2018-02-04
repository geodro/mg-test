<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Bus;
use MindGeekTest\Console\Commands\Import;
use MindGeekTest\Jobs\ProcessMovie;
use Tests\TestCase;

/**
 * Class MovieTest
 * @package Tests\Feature
 */
class MovieTest extends TestCase
{
    /**
     * Test json parsing of showcase source
     */
    public function testReadJsonShowcase()
    {
        // Replace `url('showcase.json')` with real source
        $request = (new Import())->request(url('showcase.json'));

        $this->assertNotTrue(empty($request));
    }

    /**
     *
     */
    public function testImportCommand()
    {
        Bus::fake();

        $this->artisan('import:showcase', ['url' => '']);

        Bus::assertNotDispatched(ProcessMovie::class);

        $url = url('showcase.json');

        $movies = (new Import())->request($url);

        $this->artisan('import:showcase', ['url' => $url]);

        Bus::assertDispatched(ProcessMovie::class, function ($job) use ($movies) {
            return in_array($job->source, $movies);
        });
    }
}
