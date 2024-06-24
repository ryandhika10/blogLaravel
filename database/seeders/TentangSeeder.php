<?php

namespace Database\Seeders;

use App\Models\Tentang;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TentangSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Tentang::create([
            'konten' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores, quasi cupiditate accusantium tempora laborum est ad aut odit saepe corrupti facere veritatis, beatae perferendis. Quo ea repellendus in maiores nam?',
            'facebook' => 'www.facebook.com',
            'instagram' => 'www.instagram.com',
            'twitter' => 'www.twitter.com'
        ]);
    }
}
