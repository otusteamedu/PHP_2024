<?php

namespace App\Models;

class Request
{
    private $mysqli;

    public function __construct()
    {
        $this->mysqli = new \mysqli(
            getenv('DB_HOST'),
            getenv('DB_USER'),
            getenv('DB_PASSWORD'),
            getenv('DB_NAME')
        );
    }

    public function create($email, $start_date, $end_date)
    {
        $stmt = $this->mysqli->prepare("INSERT INTO requests (email, start_date, end_date) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $email, $start_date, $end_date);
        $stmt->execute();
    }

    public function updateStatus($email, $start_date, $end_date, $status)
    {
        $stmt = $this->mysqli->prepare("UPDATE requests SET status=? WHERE email=? AND start_date=? AND end_date=?");
        $stmt->bind_param("ssss", $status, $email, $start_date, $end_date);
        $stmt->execute();
    }
}
