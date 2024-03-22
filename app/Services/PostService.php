<?php

namespace App\Services;

use App\Repositories\PostRepositoryInterface;

class PostService
{

    public function __construct(
        protected PostRepositoryInterface $postRepository
    ){
    }

    public function all()
    {
        return $this->postRepository->all();
    }

    public function store(array $data)
    {
        return $this->postRepository->store($data);
    }

    public function find(int $id)
    {
        return $this->postRepository->find($id);
    }

    public function update(int $id, array $data)
    {
        return $this->postRepository->update($id, $data);
    }

    public function delete(int $id)
    {
        return $this->postRepository->delete($id);
    }
}
