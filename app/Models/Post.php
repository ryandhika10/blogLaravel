<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $table = 'post';
    protected $fillable = ['sampul', 'judul', 'konten', 'slug', 'id_kategori', 'id_user'];

    /**
     * Get the user that owns the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori');
    }

    /**
     * The roles that belong to the Post
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tag()
    {
        return $this->belongsToMany(Tag::class, 'post_tag', 'id_post', 'id_tag');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user');
    }

    public function rekomendasi()
    {
        return $this->hasOne(Rekomendasi::class, 'id_post');
    }
}
