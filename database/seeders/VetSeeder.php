<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Vet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class VetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 5 veterinarians
        for ($i = 1; $i <= 5; $i++) {
            $user = User::create([
                'name' => 'Dr. Veterinarian ' . $i,
                'email' => 'vet' . $i . '@example.com',
                'password' => Hash::make('password'),
                'role' => 'vet', // Assuming 'vet' is the role for veterinarians
            ]);

            // Create vet profile
            $specializations = [
                'General Veterinary Medicine',
                'Surgery',
                'Dermatology',
                'Cardiology',
                'Neurology',
                'Orthopedics',
                'Dentistry',
                'Oncology',
                'Internal Medicine',
                'Emergency Medicine'
            ];
            
            $services = [
                'Vaccinations',
                'Wellness Exams',
                'Surgery',
                'Dental Care',
                'X-rays and Imaging',
                'Laboratory Services',
                'Emergency Care',
                'Pet Nutrition Counseling'
            ];
            
            // Select 2-4 random services
            $randomServices = [];
            $serviceCount = rand(2, 4);
            $serviceKeys = array_rand($services, $serviceCount);
            
            if (!is_array($serviceKeys)) {
                $serviceKeys = [$serviceKeys];
            }
            
            foreach ($serviceKeys as $key) {
                $randomServices[] = $services[$key];
            }
            
            // Create availability hours
            $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'];
            $availabilityHours = [];
            
            foreach ($days as $day) {
                // 70% chance of being available on a weekday, 30% chance on weekends
                $isAvailable = (($day == 'Saturday' || $day == 'Sunday') ? rand(0, 100) < 30 : rand(0, 100) < 70);
                
                if ($isAvailable) {
                    $startHour = rand(8, 10);
                    $endHour = rand(16, 18);
                    $availabilityHours[$day] = sprintf('%02d:00 - %02d:00', $startHour, $endHour);
                } else {
                    $availabilityHours[$day] = 'Not Available';
                }
            }

            Vet::create([
                'user_id' => $user->id,
                'clinic_name' => 'Pet Clinic ' . $i,
                'specialization' => $specializations[array_rand($specializations)],
                'experience_years' => rand(2, 20),
                'qualification' => 'Doctor of Veterinary Medicine (DVM)',
                'license_number' => 'VET' . rand(10000, 99999),
                'biography' => 'Dr. Veterinarian ' . $i . ' is a highly skilled veterinary professional with years of experience in animal healthcare. Specializing in ' . $specializations[array_rand($specializations)] . ', they are dedicated to providing the best care for your pets.',
                'services_offered' => $randomServices,
                'address' => $i . ' Veterinary Street',
                'city' => 'Pet City',
                'state' => 'PS',
                'zip_code' => '1000' . $i,
                'phone_number' => '555-555-' . sprintf('%04d', $i),
                'website' => 'https://vetclinic' . $i . '.example.com',
                'consultation_fee' => rand(30, 100) + 0.99,
                'image_path' => null, // Default image will be used
                'is_available' => true,
                'availability_hours' => $availabilityHours,
                'is_verified' => true
            ]);
        }

        $this->command->info('Veterinarians created successfully!');
    }
}