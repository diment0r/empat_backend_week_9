<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::inRandomOrder()->get();
        $categories = Category::inRandomOrder()->get();

        foreach ($users as $user) {
            foreach ($categories as $category) {
                $productCount = rand(1, 2);
                Product::factory()->count($productCount)->create([
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                ]);
            }
        }
    }
}
