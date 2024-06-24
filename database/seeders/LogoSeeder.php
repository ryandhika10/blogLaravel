<?php

namespace Database\Seeders;

use App\Models\Logo;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class LogoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Logo::create([
            'gambar' => 'icon.png'
        ]);
    }
}
