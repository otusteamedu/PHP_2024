<?php

namespace App\Console\Commands;

use App\Application\Consumer\ConsumerInterface;
use App\Application\UseCase\Consume\ConsumeUseCase;
use Illuminate\Console\Command;

class Consumer extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:consumer';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(
        private readonly ConsumeUseCase $consumeUseCase
    )
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ($this->consumeUseCase)();
    }
}
