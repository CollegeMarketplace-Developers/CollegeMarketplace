<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class RentableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        //create an array of random words
        $randomTagsArray = $this->faker->words($nbWords = 6, $asText = false);
        $commaSeperatedString = implode(", ", $randomTagsArray);

        // rental type array
        $rentalType = array('Hourly', 'Daily', 'Weekly', 'Monthly');
        $rentalCondition = array('New' , 'Good', 'Slightly Used', 'Used Normal Wear');
        $rentalStatus = array('Rented', 'Available');
        $rentalCategory = array('Furniture', 'Clothes', 'Electronics', 'Kitchen', 'School Accessories', "Books");
        $rentableNegotiable = array('Fixed', 'Negotiable');
        return [
            'id'=>$this->faker->uuid(),
            // ownership
            'user_id'=> User::inRandomOrder()->take(1)->get()[0]->id,


            'rental_title' => $this->faker->text(random_int(5,100)),
            'rental_duration' => $rentalType[array_rand($rentalType)],
            'rental_charging' => random_int(50,500),
            'negotiable' => $rentableNegotiable[array_rand($rentableNegotiable)],
            'condition' => $rentalCondition[array_rand($rentalCondition)],
            'category' => $rentalCategory[array_rand($rentalCategory)],
            'tags' => strval($commaSeperatedString) ,
            'description' => $this->faker->paragraph(5),
            'image_uploads'=>null,
            'status' => $rentalStatus[array_rand($rentalStatus)],

            // rental location
            'street'=>'4176 Dale Boulevard',
            // 'city' =>$this->faker->city(),
            'city'=>'Dale City',
            // 'state'=>$this->faker->state(),
            'state'=>'VA',
            // 'country'=>$this->faker->country(),
            'country'=>'United States',
            // 'postcode'=>$this->faker->postcode(),
            'postcode'=>'22193',
            'latitude'=>'38.6440193',
            'longitude'=>'-77.3352243',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
