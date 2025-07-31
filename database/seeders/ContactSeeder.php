<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::create([
            'email' => 'info@tastyfood.com',
            'phone_number' => '+62 812 3456 7890',
            'location_label' => 'Jl. Kuliner No.123, Jakarta',
            'location_url' => 'https://maps.google.com/?q=-6.200000,106.816666',
        ]);
    }
}
