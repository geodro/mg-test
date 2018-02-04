<?php

namespace MindGeekTest\Jobs;

use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use MindGeekTest\Image;
use MindGeekTest\Movie;
use MindGeekTest\Video;

/**
 * Class ProcessMovie
 * @package MindGeekTest\Jobs
 */
class ProcessMovie implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * @var int
     */
    public $timeout = 300;

    /**
     * @var array
     */
    public $source;

    /**
     * @var string
     */
    protected $url;

    /**
     * Create a new job instance.
     *
     * @param array $source
     * @param string $url
     * @return void
     */
    public function __construct(array $source, string $url)
    {
        $this->source = $source;
        $this->url = $url;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $movie = Movie::query()->where(['source.url' => $this->url, 'source.id' => $this->source['id']])->first();

        if ($movie) {
            if (Carbon::parse($this->source['lastUpdated'])->lte($movie->lastUpdated)) {
                return;
            }
        } else {
            $movie = new Movie();
        }

        $movie->source = [
            'id' => $this->source['id'],
            'url' => $this->url
        ];

        unset($this->source['id']);

        foreach ($this->source as $key => $value) {
            $movie->$key = $value;
            switch ($key) {
                case 'cardImages':
                case 'keyArtImages':

                    $movie->$key = collect($value)->map(function ($image) {
                        return Image::import($image);
                    })->reject(function ($image) {
                        return is_null($image);
                    })->toArray();

                    break;
                case 'videos':

                    $movie->$key = collect($value)->map(function ($video) {
                        return Video::reachable($video['url']) ? $video : null;
                    })->reject(function ($video) {
                        return is_null($video);
                    })->toArray();

                    break;
                default:
                    $movie->$key = $value;
            }
        }

        $movie->save();

        Log::info('Done processing: ' . $movie->headline);
    }
}
