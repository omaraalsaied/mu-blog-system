<?php

namespace App\Services;
use App\Repositories\CommentRepositoryInterface;

class CommentService
{
    public function __construct(
        protected CommentRepositoryInterface $commentRepositoryInterface
    ){
    }

    public function store (array $data)
    {
        return $this->commentRepositoryInterface->store($data);
    }

    public function update (int $id, array $data)
    {
        return $this->commentRepositoryInterface->update($id, $data);
    }

    public function delete (int $id)
    {
        return $this->commentRepositoryInterface->delete($id);
    }
}
