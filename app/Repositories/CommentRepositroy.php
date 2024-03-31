<?php

namespace App\Repositories;

use App\Models\Comment;

class CommentRepositroy implements CommentRepositoryInterface
{
    public function store(array $data)
    {
        return Comment::create($data);
    }

    public function update (int $id, array $data)
    {
        $comment = Comment::findOrFail($id);

        return $comment->update($data);
    }

    public function delete(int $id)
    {
        $comment = Comment::findOrFail($id);

        $comment->delete();
    }
}
