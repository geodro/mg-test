<?php

namespace MindGeekTest;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Movie
 * @package MindGeekTest
 */
class Movie extends Model
{
    /**
     * @var array
     */
    protected $dates = [
        'updated_at',
        'created_at',
        'lastUpdated'
    ];

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function cardImages()
    {
        return $this->embedsMany(Image::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function keyArtImages()
    {
        return $this->embedsMany(Image::class);
    }

    /**
     * @return \Jenssegers\Mongodb\Relations\EmbedsMany
     */
    public function videos()
    {
        return $this->embedsMany(Video::class);
    }
}
