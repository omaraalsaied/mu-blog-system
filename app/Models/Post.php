<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'body',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'datetime: Y-m-d h:i',
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function post_images()
    {
        return $this->hasMany(PostImage::class);
    }

    // to cascade deleting post_images on post deletion
    public static function boot ()
    {
        parent::boot();
        static::deleting(function ($post) {
            $post->post_images()->delete();
        });
    }

}
