<?php

namespace App\Console\Commands\Search;

use App\Models\Youtubechannel;
use App\Observers\YoutubechannelsObserver;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class DeleteYoutubechannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:delete:youtubechannels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Удаление YouTube каналов из системы';

    /** @var \Elastic\Elasticsearch\Client */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
     * @param Client $elasticsearch
     * @return void
     */
    public function __construct(Client $elasticsearch)
    {
        parent::__construct();
        $this->elasticsearch = $elasticsearch;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info("Удаление YouTube каналов из системы");

        $observer = new YoutubechannelsObserver($this->elasticsearch);
        $observer->deleted();
        $this->info('\\nDone!');
    }
}
