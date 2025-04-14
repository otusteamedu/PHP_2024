<?php

namespace App\Providers;

use App\Services\Youtubechannel\Repositories\ElasticsearchSearchYoutubechannelRepository;
use App\Services\Youtubechannel\Repositories\EloquentYoutubechannelRepository;
use App\Services\Youtubechannel\Repositories\EloquentSearchYoutubechannelRepository;
use App\Services\Youtubechannel\Repositories\SearchYoutubechannelRepository;
use App\Services\Youtubechannel\Repositories\WriteYoutubechannelRepository;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    public $bindings = [
        WriteYoutubechannelRepository::class => EloquentYoutubechannelRepository::class,
    ];
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(SearchYoutubechannelRepository::class, function (){
            if (! config('services.search.enabled')) {
                return new EloquentSearchYoutubechannelRepository();
            }
            return new ElasticsearchSearchYoutubechannelRepository(
                $this->app->make(Client::class)
            );
        });

        $this->bindSearchClient();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function (){
            return ClientBuilder::create()->setHosts($this->app['config']
                ->get('services.search.hosts'))
                ->build();
        });
    }
}
