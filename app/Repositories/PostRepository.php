<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{

    public function all()
    {
        // TODO: Implement all() method.
        return Post::with('user', 'post_images')->get();

    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
        return Post::create($data);
    }

    public function find(int $id)
    {
        // TODO: Implement find() method.
        return Post::with('post_images', 'user')->findorfail($id);
    }

    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $post = findOrFail($id);
        $post->update($data);
        return $post;
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $post = Post::findOrFail($id);
        $post->delete();
    }
}
