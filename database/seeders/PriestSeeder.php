<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Priest;

class PriestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $priests = [
            [
                'name' => 'Fr. Juan Carlos Santos',
                'email' => 'fr.juan@santamarta.ph',
                'phone' => '+63 912 345 6789',
                'specialization' => 'Parish Priest',
                'availability_status' => true,
                'notes' => 'Head pastor of Santa Marta Parish. Available for all sacraments.'
            ],
            [
                'name' => 'Fr. Miguel Rodriguez',
                'email' => 'fr.miguel@santamarta.ph',
                'phone' => '+63 923 456 7890',
                'specialization' => 'Wedding Specialist',
                'availability_status' => true,
                'notes' => 'Specializes in wedding ceremonies and marriage counseling.'
            ],
            [
                'name' => 'Fr. Antonio Cruz',
                'email' => 'fr.antonio@santamarta.ph',
                'phone' => '+63 934 567 8901',
                'specialization' => 'Youth Ministry',
                'availability_status' => true,
                'notes' => 'Focuses on baptisms, confirmations and youth programs.'
            ],
            [
                'name' => 'Fr. Francisco Dela Cruz',
                'email' => 'fr.francisco@santamarta.ph',
                'phone' => '+63 945 678 9012',
                'specialization' => 'Senior Pastor',
                'availability_status' => true,
                'notes' => 'Senior priest with extensive experience in all sacraments.'
            ],
            [
                'name' => 'Fr. Pedro Morales',
                'email' => 'fr.pedro@santamarta.ph',
                'phone' => '+63 956 789 0123',
                'specialization' => 'Hospital Chaplain',
                'availability_status' => false,
                'notes' => 'Currently on leave for medical reasons.'
            ]
        ];

        foreach ($priests as $priest) {
            Priest::create($priest);
        }
    }
}
