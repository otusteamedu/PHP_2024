<?php

namespace App\Jobs;

class TaskJob extends Job
{
    public $taskId;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($taskId)
    {
        $this->taskId = $taskId;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // Имитация длительного процесса
        sleep(60);

        $result = [
            'id' => $this->taskId,
            'status' => 'completed',
            'data' => [
                'answer' => rand(1, 100)
            ]
        ];

        // Сохранение результата обработки в файл
        file_put_contents(storage_path("app/tasks/{$this->taskId}.task"), json_encode($result));
    }
}
