<?php

namespace App\Controllers;

use App\Models\Request;
use App\Services\NotificationService;
use App\Services\QueueProcessor;
use RedisException;

class RequestController
{
    public function showForm(): string
    {
        return file_get_contents(__DIR__ . '/../../resources/views/form.html');
    }

    /**
     * @throws RedisException
     */
    public function submitRequest(Request $request, QueueProcessor $queueProcessor): void
    {
        $email = $_POST['email'];
        $start_date = $_POST['start_date'];
        $end_date = $_POST['end_date'];

        $request->create($email, $start_date, $end_date);

        $queueProcessor->addToQueue([
            'email' => $email,
            'start_date' => $start_date,
            'end_date' => $end_date
        ]);
    }
}
