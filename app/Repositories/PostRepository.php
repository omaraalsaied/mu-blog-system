<?php

namespace App\Repositories;

use App\Models\Post;

class PostRepository implements PostRepositoryInterface
{

    public function all()
    {
        // TODO: Implement all() method.
        return Post::with('user:id,name', 'post_images')->get();

    }

    public function store(array $data)
    {
        // TODO: Implement store() method.
        return Post::create($data);
    }

    public function find(int $id)
    {
        // TODO: Implement find() method.
        return Post::with('post_images', 'user:id,name')->findorfail($id);
    }

    public function update(int $id, array $data)
    {
        // TODO: Implement update() method.
        $post = Post::findOrFail($id);
        return $post->update($data) ;
    }

    public function delete(int $id)
    {
        // TODO: Implement delete() method.
        $post = Post::findOrFail($id);
        $post->delete();
    }

    public function user_posts(int $id)
    {
        // TODO: Implement user_posts() method.
        return Post::with('user:id,name', 'post_images')->where('user_id',$id)->get();
    }
}
