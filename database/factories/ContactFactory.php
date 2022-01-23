<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Contact;
use Faker\Generator as Faker;

$factory->define(Contact::class, function (Faker $faker) {
    return [
        'firstname' => $faker->firstName,
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->e164PhoneNumber
    ];
});
