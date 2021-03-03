<?php

namespace Database\Factories;

use App\Models\Product;
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
    protected $category_id;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category_id = $this->faker->numberBetween(1,6);
        return [
            'name'          => $this->faker->word,
            'category_id'   =>$category_id,
            'subcategory_id'   => function(){
                if($this->category_id == 1 || $this->category_id ==5){
                    return $this->faker->numberBetween(1,4);
                }elseif($this->category_id == 2 || $this->category_id ==3){
                    return $this->faker->numberBetween(1,3);
                }elseif($this->category_id == 4){
                    return $this->faker->numberBetween(1,2);
                }else{
                    return $this->faker->numberBetween(1,5);
                }
            },
            'product_type_id'=> $this->faker->numberBetween(1,2),
            'description'    => $this->faker->sentence,
            'price'          => $this->faker->randomFloat(3, 2, 100)
        ];
    }
}
