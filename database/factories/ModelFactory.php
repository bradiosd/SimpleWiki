<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Models\Article::class, function (Faker\Generator $faker) {
    $title = ucwords($faker->unique()->words(rand(1, 5), true));
    $slug = snake_case($title);

    return [
        'title' => $title,
        'slug' => $slug,
        'description' => ucfirst($faker->words(rand(5, 10), true))
    ];
});

$factory->define(App\Models\Category::class, function (Faker\Generator $faker) {
    $title = ucwords($faker->unique()->words(rand(1, 5), true));
    $slug = snake_case($title);

    return [
        'title' => $title,
        'slug' => $slug,
        'description' => ucfirst($faker->words(rand(5, 10), true))
    ];
});

$factory->define(App\Models\Link::class, function (Faker\Generator $faker) {
    $title = ucwords($faker->unique()->words(rand(1, 5), true));
    $slug = snake_case($title);

    return [
        'title' => $title,
        'slug' => $slug,
        'description' => ucfirst($faker->words(rand(5, 10), true)),
        'url' => $faker->url
    ];
});
