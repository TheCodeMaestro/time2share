<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\User;
use App\Models\Review;

class ReviewFactory extends Factory
{
    protected $model = Review::class;

    public function definition(): array
    {   
        $reviewer = User::where('admin', 0)->pluck('id')->random();
        $reviewed_user_id = User::where('admin', 0)->where('id', '!=', $reviewer)->pluck('id')->random();
        if(Product::where('user_id', $reviewer)->doesntExist()){
            $product_id = null;
        } else{
            $product_id = Product::where('user_id', $reviewer)->pluck('id')->random();
        }

        return [
            'title' => fake()->word(),
            'message' => fake()->sentence(20),
            'product_id' => $product_id,
            'reviewer_id' => $reviewer,
            'reviewed_user_id' => $reviewed_user_id,
            'score' => rand(1, 5),
        ];
    }
}