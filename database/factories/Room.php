<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Room;
use Faker\Generator as Faker;

$factory->define(Room::class, function (Faker $faker) {
    return [
        'name' => $faker->word,
        'room_type_id' => \App\RoomType::default()->id,
        'user_id' => factory(App\User::class),
    ];
});