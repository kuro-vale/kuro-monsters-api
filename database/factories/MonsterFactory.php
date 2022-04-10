<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Monster>
 */
class MonsterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $gender = ['male', 'female', 'non-binary'];
        $race = ['aberration', 'beast', 'dragon', 'elemental', 'undead', 'vampire', 'werewolf'];
        $size = ['small', 'medium', 'large'];
        $favorite_color = ['black', 'white', 'red', 'yellow', 'blue', 'orange', 'green', 'purple'];
        return [
            'name' => $this->faker->name(),
            'gender' => array_rand($gender),
            'race' => array_rand($race),
            'size' => array_rand($size),
            'favorite_color' => array_rand($favorite_color),
        ];
    }
}
