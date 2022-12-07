<?php

namespace Database\Factories;
use App\Models\User;
use NunoMaduro\Collision\Adapters\Phpunit\State;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
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
        $listingCondition = array('New' , 'Good', 'Slightly Used', 'Used Normal Wear');
        $listingStatus = array('Sold', 'Pending', 'Available');
        $listingCategory = array('Furniture', 'Clothes', 'Electronics', 'Kitchen', 'School Accessories', "Books");
        $listingNegotiable =array('Fixed', 'Negotiable' , 'Free');
        // $temp = 'https://picsum.photos/300/200?sig='. random_int(0,100);
        // $imgUploads = array($temp);
        return [
            'id'=>$this->faker->uuid(),
            'user_id'=> User::inRandomOrder()->take(1)->get()[0]->id,
            'item_name' => $this->faker->text(random_int(5,100)),
            'price' => random_int(50,500),
            'negotiable' => $listingNegotiable[array_rand($listingNegotiable)],
            'condition' => $listingCondition[array_rand($listingCondition)],
            'category' => $listingCategory[array_rand($listingCategory)],
            'tags' => strval($commaSeperatedString) ,
            'description' => $this->faker->paragraph(5),
            // 'image_uploads'=>json_encode($imgUploads),
            'image_uploads'=>null,
            // 'street' => $this->faker->streetAddress(),
            'street'=>'4215 Cheshire Station Plaza',
            // 'city' =>$this->faker->city(),
            'city'=>'Dale City',
            // 'state'=>$this->faker->state(),
            'state'=>'VA',
            // 'country'=>$this->faker->country(),
            'country'=>'United States',
            // 'postcode'=>$this->faker->postcode(),
            'postcode'=>'22193',
            'status'=> $listingStatus[array_rand($listingStatus)],
            'latitude'=>'38.6453055',
            'longitude'=>'-77.3329809',
            'created_at' => now(),
            'updated_at' => now()
        ];
    }
}
