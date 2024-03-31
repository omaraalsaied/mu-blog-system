<?php

namespace App\Repositories;

interface CommentRepositoryInterface
{
    public function store(array $data);

    public function update(int $id, array $data);

    public function delete(int $id);
}
