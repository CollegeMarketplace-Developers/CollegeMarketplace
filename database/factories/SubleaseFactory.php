<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Sublease>
 */
class SubleaseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $utilities = array('Electric', 'Trash', 'Internet', 'Gas', 'Water');
        $subleaseCondition = array('New' , 'Good', 'Slightly Used', 'Used Normal Wear');
        $negotiable = array('Fixed', 'Negotiable');
        $leaseStatus = array('Leased', 'Available');
        return [
            // owner of sublease
            'user_id'=> random_int(1,10),

            'sublease_title' => $this->faker->text(random_int(5,100)),
            'location' => $this->faker->text(5), //ex. shamrock, standard
            'date_from' => null,
            'date_to' => null,
            'rent' => random_int(50,500),
            'negotiable' => $negotiable[array_rand($negotiable)],
            'condition' => $subleaseCondition[array_rand($subleaseCondition)],
            'utilities' => $utilities[array_rand($utilities)],
            'description' => $this->faker->paragraph(5),
            'image_uploads' =>null,

            // rental location
            'street'=>'14894 Emberdale Drive',
            // 'city' =>$this->faker->city(),
            'city'=>'Dale City',
            // 'state'=>$this->faker->state(),
            'state'=>'VA',
            // 'country'=>$this->faker->country(),
            'country'=>'United States',
            // 'postcode'=>$this->faker->postcode(),
            'postcode'=>'22193-2678',
            'latitude'=>'38.630017',
            'longitude'=>'-77.338868',

            'status'=> $leaseStatus[array_rand($leaseStatus)],
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
