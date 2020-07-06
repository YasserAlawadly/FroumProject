<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Reply::class, function (Faker $faker) {
    return [
        'user_id' => factory(\App\User::class)->create(),
        'thread_id' => factory(\App\Thread::class)->create(),
        'body' => $faker->paragraph
    ];
});
