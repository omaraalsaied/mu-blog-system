<?php

namespace App\Repositories;

use App\Models\Post;

interface PostImageRepositoryInterface
{
    public function uploadImages(array $images, Post $post);

    public function deleteImage(int $id);
}
