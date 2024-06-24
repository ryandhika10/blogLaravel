<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['lenovo', 'php', 'samsung'];
        foreach ($tags as $tag) {
            Tag::create([
                'nama' => $tag,
                'slug' => Str::slug($tag)
            ]);
        }
    }
}
