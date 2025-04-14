<?php

namespace App\Console\Commands\Search;

use App\Models\Youtubechannel;
use App\Observers\YoutubechannelsObserver;
use Elastic\Elasticsearch\Client;
use Illuminate\Console\Command;

class ReindexYoutubechannel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'search:reindex:youtubechannels';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Индексация всех каналов youtube.';
    /** @var \Elastic\Elasticsearch\Client */
    private $elasticsearch;

    /**
     * Create a new command instance.
     *
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
        $this->info('Индексация всех каналов youtube. Это может занять некоторое время...');
        $observer = new YoutubechannelsObserver($this->elasticsearch);
        $observer->reindex();
        $this->info('\\nDone!');
    }
}
