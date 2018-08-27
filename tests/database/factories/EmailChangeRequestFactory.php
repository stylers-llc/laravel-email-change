<?php

use Faker\Generator as Faker;
use Stylers\EmailChange\Models\EmailChangeRequest;

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(EmailChangeRequest::class, function (Faker $faker) {
    return [
        'email' => str_random(4) . '.' . $faker->unique()->safeEmail,
    ];
});
