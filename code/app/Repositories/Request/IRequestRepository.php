<?php

namespace App\Repositories\Request;

use App\Models\RequestModel;
interface IRequestRepository
{
    public function create(string $status): RequestModel;
    public function update($id, $status);
    public function getById(int $id): RequestModel;
}
