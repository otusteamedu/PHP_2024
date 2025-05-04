<?php

namespace App\Repositories\Request;

use App\Models\RequestModel;
class RequestEloquentRepository implements IRequestRepository
{
    private RequestModel $request;

    public function __construct()
    {
        $this->request = new RequestModel();
    }

    public function create(string $message): RequestModel
    {
        return $this->request->create([
            'status' => 'new',
        ]);
    }

    public function update($id, $status)
    {
        $request = RequestModel::find($id);
        $request->status = $status;
        $request->save();
    }

    public function getById(int $id): RequestModel
    {
        return $this->request->find($id);
    }
}
