<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\File;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Resource>
 */
class ResourceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $filepath = storage_path('resource');

        if(!File::exists($filepath)){
            File::makeDirectory($filepath);
        }

        return [
            'title' => $this->faker->words(3,true),
            'resource_author' => $this->faker->lastName(),
            'image' => $this->faker->image($filepath,300,200),
            'slug' => $this->faker->slug(3),
            'description' => $this->faker->sentence(100),
            'price' => $this->faker->randomElement([0, 300]),
            'link' => $this->faker->url(),
            'category_id' => $this->faker->randomElement([1, 4])
        ];
    }
}
