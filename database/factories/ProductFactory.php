<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\User;


class ProductFactory extends Factory
{
    protected $model = Product::class;

    public function definition(): array
    {   

        $id_of_user = User::where('admin', 0)->pluck('id')->random();
        $loaner_id = User::where('admin', 0)->where('id', '!=', $id_of_user)->pluck('id')->random();

        return [
            'name' => fake()->word(),
            'description' => fake()->sentence(40),
            'category' => fake()->randomElement(['Gereedschap', 'Speelgoed', 'Meubel', 'Keuken apparatuur', 'Anders']),
            'deadline' => fake()->dateTimeBetween('+1 day', '+1 year')->format('y-m-d'),
            'user_id' => $id_of_user,
            'loaner_id' => fake()->randomElement([$loaner_id, null]),
            'image_path' => 'https://picsum.photos/640/480?' . uniqid(),
        ];
    }
}