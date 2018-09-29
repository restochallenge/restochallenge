<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'restaurant_id' => factory(App\Restaurant::class)->create()->id,
        'user_id' => factory(App\User::class)->create()->id
    ];
});
