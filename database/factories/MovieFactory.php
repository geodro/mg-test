<?php

use Faker\Generator as Faker;

$factory->define(\MindGeekTest\Movie::class, function (Faker $faker) {
    return [
        'body' => implode("\n", $faker->paragraphs(5)),
        'headline' => $faker->sentence,
        'year' => $faker->year,
        'duration' => rand(40, 120) * 60,
        'cert' => $faker->randomLetter,
        'rating' => rand(1, 5),
        'class' => $faker->word,
        'synopsis' => implode(' ', $faker->sentences(5)),
        'reviewAuthor' => $faker->name,
        'cardImages' => factory(\MindGeekTest\Image::class, rand(1, 5))->make()->toArray(),
        'keyArtImages' => factory(\MindGeekTest\Image::class, rand(1, 5))->make(['h' => 169, 'w' => 114])->toArray()
    ];
});
