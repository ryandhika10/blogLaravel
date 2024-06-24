<?php

namespace Database\Seeders;

use App\Models\Banner;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class BannerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Banner::create([
            'sampul' => 'banner1.jpeg',
            'judul' => 'Tips dan Trik Membeli Laptop Secara Online',
            'konten' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores, quasi cupiditate accusantium tempora laborum est ad aut odit saepe corrupti facere veritatis, beatae perferendis. Quo ea repellendus in maiores nam?',
            'slug' => Str::slug('Tips dan Trik Membeli Laptop Secara Online'),
        ]);
    }
}
