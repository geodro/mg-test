<?php

use Faker\Generator as Faker;

$factory->define(\MindGeekTest\Image::class, function (Faker $faker) {
    $w = 1110;
    $h = 360;

    return [
        'url' => $faker->imageUrl($w, $h),
        'h' => $h,
        'w' => $w
    ];
});
