<?php

namespace App\Services;
use App\Models\Post;
use App\Repositories\PostImageRepositoryInterface;

class PostImageService
{
    public function __construct(
        protected PostImageRepositoryInterface $postImage
    ){
    }

    public function upload(array $images, Post $post)
    {
        return $this->postImage->uploadImages($images, $post);
    }

    public function delete(int $id)
    {
        return $this->postImage->deleteImage($id);
    }
}
