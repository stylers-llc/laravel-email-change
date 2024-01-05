<?php

use Faker\Generator as Faker;
use Stylers\EmailChange\Models\EmailChangeRequest;
use Illuminate\Support\Str;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(EmailChangeRequest::class, function (Faker $faker) {
    return [
        'email' => Str::random(4) . '.' . $faker->unique()->safeEmail,
    ];
});
