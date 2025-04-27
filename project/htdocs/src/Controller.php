<?php
namespace Src;
class Controller
{
    public function enqueue()
    {
        $data = json_decode(file_get_contents('php://input'), true);
        $id = StatusStorage::createPending();
        QueuePublisher::publish([
            'id' => $id,
            'payload' => $data,
        ]);
        echo json_encode(['request_id' => $id]);
    }

    public function status(int $id)
    {
        $status = StatusStorage::getStatus($id);
        if ($status === null) {
            http_response_code(404);
            echo json_encode(['error' => 'Request not found']);
        } else {
            echo json_encode(['status' => $status]);
        }
    }
}