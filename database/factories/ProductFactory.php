<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        //Asignar subcategoría según cada categoría

        $categories_num = Category::all()->count();
        $category_id = $this->faker->numberBetween(1, $categories_num);

        $subcategories = Subcategory::where('category_id', $category_id)->get();
        $subcategory_id = $this->faker->numberBetween($subcategories->min('id'), $subcategories->max('id'));

        return [
            'name'           => $this->faker->word,
            'category_id'    => $category_id,
            'subcategory_id' => $subcategory_id,
            'product_type_id'=> $this->faker->numberBetween(1,2),
            'description'    => $this->faker->sentence,
            'price'          => $this->faker->randomFloat(3, 2, 100)
        ];
    }
}
