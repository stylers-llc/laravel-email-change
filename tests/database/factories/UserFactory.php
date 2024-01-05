<?php

use Faker\Generator as Faker;
use Stylers\EmailChange\Models\User;
use Illuminate\Support\Str;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(User::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'email' => Str::random(4) . '.' . $faker->unique()->safeEmail,
    ];
});
