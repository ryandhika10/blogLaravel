<?php

namespace Database\Seeders;

use App\Models\Like;
use App\Models\Post;
use App\Models\Rekomendasi;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // post 1
        $post = Post::create([
            'id_kategori' => 1,
            'id_user' => 1,
            'sampul' => 'post1.jpg',
            'judul' => 'Tutorial cara merawat laptop',
            'konten' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores, quasi cupiditate accusantium tempora laborum est ad aut odit saepe corrupti facere veritatis, beatae perferendis. Quo ea repellendus in maiores nam?',
            'slug' => Str::slug('Tutorial cara merawat laptop')
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 1,
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 3,
        ]);

        Like::create([
            'id_post' => $post->id,
            'id_user' => 3
        ]);

        // post 2
        $post = Post::create([
            'id_kategori' => 2,
            'id_user' => 2,
            'sampul' => 'post2.jpg',
            'judul' => 'Belajar Laravel',
            'konten' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores, quasi cupiditate accusantium tempora laborum est ad aut odit saepe corrupti facere veritatis, beatae perferendis. Quo ea repellendus in maiores nam?',
            'slug' => Str::slug('Belajar Laravel')
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 2,
        ]);

        Like::create([
            'id_post' => $post->id,
            'id_user' => 3
        ]);

        Rekomendasi::create([
            'id_post' => $post->id
        ]);

        // post 3
        $post = Post::create([
            'id_kategori' => 2,
            'id_user' => 2,
            'sampul' => 'post3.jpeg',
            'judul' => 'Belajar Laravel Autentifikasi',
            'konten' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores, quasi cupiditate accusantium tempora laborum est ad aut odit saepe corrupti facere veritatis, beatae perferendis. Quo ea repellendus in maiores nam?',
            'slug' => Str::slug('Belajar Laravel Autentifikasi')
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 2,
        ]);

        Rekomendasi::create([
            'id_post' => $post->id
        ]);

        // post 4
        $post = Post::create([
            'id_kategori' => 3,
            'id_user' => 1,
            'sampul' => 'post4.jpg',
            'judul' => 'Rekomendasi Hp Tahun 2022',
            'konten' => 'Lorem ipsum dolor sit, amet consectetur adipisicing elit. Asperiores, quasi cupiditate accusantium tempora laborum est ad aut odit saepe corrupti facere veritatis, beatae perferendis. Quo ea repellendus in maiores nam?',
            'slug' => Str::slug('Rekomendasi Hp Tahun 2022')
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 3,
        ]);

        DB::table('post_tag')->insert([
            'id_post' => $post->id,
            'id_tag' => 1,
        ]);
    }
}
