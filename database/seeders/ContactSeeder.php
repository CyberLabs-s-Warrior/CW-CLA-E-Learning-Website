<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    public function run(): void
    {
        Contact::create([
            'alamat'     => 'Jl. Pemurus Baru No. 123, Kota Banjarmasin, Kalimantan Selatan',
            'email'      => 'info@elearning.com',
            'telepon'    => '+62 812-3456-7890',
            'latitude'   => '-3.339917', 
            'phone_number'  => '+62 812-3456-7890', // <-- TAMBAHKAN INI

            'longitude'  => '114.609222',
            'link_maps'  => 'https://www.google.com/maps/place/MJ65%2B2MQ+Pemurus+Baru,+Kota+Banjarmasin,+Kalimantan+Selatan/@-3.339917,114.609222,17z/data=!3m1!4b1!4m5!3m4!1s0x2de423a8c9999999:0x1234567890abcdef!8m2!3d-3.339917!4d114.609222'
        ]);
    }
}
