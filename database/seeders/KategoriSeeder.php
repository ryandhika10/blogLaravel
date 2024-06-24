<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $kategories = ['komputer dan laptop', 'bahasa pemrograman', 'android'];
        foreach ($kategories as $kategori) {
            Kategori::create([
                'nama' => $kategori,
                'slug' => Str::slug($kategori)
            ]);
        }
    }
}
