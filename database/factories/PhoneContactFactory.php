<?php

namespace Database\Factories;

use App\Models\PhoneContact;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PhoneContact>
 */
class PhoneContactFactory extends Factory
{
    protected $model = PhoneContact::class;

    public function definition()
    {
        return [
            'user_id' => \App\Models\User::factory(), // Utilizza la Factory di User per generare un user_id valido
            'contact_name' => $this->faker->name,
            'contact_number' => $this->faker->phoneNumber,
        ];
    }
}
