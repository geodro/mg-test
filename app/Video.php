<?php

namespace MindGeekTest;

use GuzzleHttp\Client;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Video
 * @package MindGeekTest
 */
class Video extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'title', 'alternatives', 'type', 'url'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * @param $source
     * @return bool
     */
    public static function reachable($source): bool
    {
        try {
            (new Client())->head($source);
            return true;
        } catch
        (\Exception $e) {
            return false;
        }
    }
}
