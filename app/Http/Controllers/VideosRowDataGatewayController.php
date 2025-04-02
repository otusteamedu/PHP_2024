<?php

namespace App\Http\Controllers;

use App\Services\RowDataGateway\VideosRow;
use PDO;

class VideosRowDataGatewayController extends Controller
{
    protected $videos;

    /**
     * @throws \Exception
     */
    public function __construct()
    {
        $this->initializeDatabaseConnection();
    }

    private function initializeDatabaseConnection(): void
    {
        $host = env('DB_HOST');
        $port = env('DB_PORT');
        $dbname = env('DB_DATABASE');
        $username = env('DB_USERNAME');
        $password = env('DB_PASSWORD');

        try {
            $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $this->videos = new VideosRow($pdo);

            $this->initializeVideoData();
        } catch (PDOException $e) {
            error_log('Database Connection Error: ' . $e->getMessage());
            throw new \Exception('Unable to connect to the database');
        }
    }

    private function initializeVideoData(): void
    {
        $this->videos->setChannelsId(1);
        $this->videos->setName('test-video2');
        $this->videos->addLike();
        $this->videos->addDislikes();
    }

    public function create(): void
    {
        $this->videos->insert();
    }

    public function update(): void
    {
        $this->videos->setId(1);
        $this->videos->update();
    }
}
