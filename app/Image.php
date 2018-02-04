<?php

namespace MindGeekTest;

use GuzzleHttp\Client;
use Illuminate\Support\Facades\Storage;
use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Class Image
 * @package MindGeekTest
 */
class Image extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'url', 'h', 'w'
    ];

    /**
     * @return mixed
     */
    public function getUrlAttribute(): string
    {
        return url(parse_url($this->attributes['url'])['path']);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    /**
     * @param array $image
     * @return Image|null
     */
    public static function import(array $image)
    {
        $path = parse_url($image['url'])['path'];

        if (!Storage::disk('public')->exists($path) && !self::store($image['url'], $path)) {
            return null;
        }

        return new self($image);
    }

    /**
     * @param $source
     * @param $path
     * @return bool
     */
    public static function store($source, $path): bool
    {
        try {
            Storage::disk('public')
                ->put($path, (new Client())->get($source)->getBody());
            return true;
        } catch
        (\Exception $e) {
            return false;
        }
    }
}
