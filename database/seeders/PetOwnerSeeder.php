<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Pet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetOwnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 pet owners with pets
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Pet Owner ' . $i,
                'email' => 'petowner' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'pet_owner', // Assuming 'user' is the role for pet owners
            ]);

            // Create 1-3 pets for each owner
            $numPets = rand(1, 3);
            for ($j = 1; $j <= $numPets; $j++) {
                $petTypes = ['dog', 'cat', 'bird', 'rabbit', 'hamster'];
                $petType = $petTypes[array_rand($petTypes)];
                
                $breeds = [
                    'dog' => ['Labrador', 'German Shepherd', 'Beagle', 'Poodle', 'Golden Retriever'],
                    'cat' => ['Persian', 'Siamese', 'Maine Coon', 'Ragdoll', 'Bengal'],
                    'bird' => ['Parakeet', 'Cockatiel', 'Canary', 'Lovebird', 'Finch'],
                    'rabbit' => ['Holland Lop', 'Dutch', 'Flemish Giant', 'Mini Rex', 'Netherland Dwarf'],
                    'hamster' => ['Syrian', 'Dwarf Campbell', 'Winter White', 'Roborovski', 'Chinese'],
                ];
                
                $breed = $breeds[$petType][array_rand($breeds[$petType])];
                $sex = rand(0, 1) ? 'male' : 'female';
                
                Pet::create([
                    'user_id' => $user->id,
                    'pet_name' => 'Pet' . $j . ' of Owner' . $i,
                    'pet_type' => $petType,
                    'pet_breed' => $breed,
                    'age' => rand(1, 10),
                    'sex' => $sex,
                    'allergies' => rand(0, 1) ? 'None' : 'Food allergies',
                    'image_path' => null, // Default image will be used
                ]);
            }
        }

        $this->command->info('Pet owners and their pets created successfully!');
    }
}