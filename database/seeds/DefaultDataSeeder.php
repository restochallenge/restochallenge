<?php

use Illuminate\Database\Seeder;

use App\User;
use App\Item;
use App\Restaurant;

class DefaultDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $mcdo = Restaurant::Create([
            'name' => 'McDonald'
        ]);

        $tim = Restaurant::Create([
            'name' => 'Tim Horton'
        ]);

        $subway = Restaurant::Create([
            'name' => 'Subway'
        ]);

        for($i=1;$i<=12;$i++) {
            $mcdo->items()->save(
                Item::make(['name' => 'McBurger #'.$i, 'description' => 'Good burger '.$i]),
                ['price' => rand(1, 20)]
            );
            $tim->items()->save(
                Item::make(['name' => 'Coffee #'.$i, 'description' => 'Good coffee '.$i]), 
                ['price' => rand(1, 20)]
            );
            $subway->items()->save(
                Item::make(['name' => 'Sandwich #'.$i, 'description' => 'Goodd sandwich '.$i]),
                 ['price' => rand(1, 20)]
             );
        }

        // Create 2 random users
        factory(User::class, 2)->create();
    }
}