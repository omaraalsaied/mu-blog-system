<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostImage extends Model
{
    use HasFactory, SoftDeletes;


    protected  $fillable = [
      'post_id',
      'post_image_path'
    ];
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

}
