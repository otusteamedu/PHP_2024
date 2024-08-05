<?php

namespace App;

use App\Actions\SearchAction;
use App\Actions\SeedAction;
use App\Components\ElasticComponent;
use App\Console\Input;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;

class App
{
    public static self $instance;

    readonly public ElasticComponent $elastic;

    public function __construct()
    {
        $this->registerComponents();

        static::$instance = $this;
    }

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws MissingParameterException
     */
    public function run(Input $input): void
    {
        if ($input->action === 'seed') {
            (new SeedAction())->run();
        }
    }

    protected function registerComponents(): void
    {
        $this->elastic = new ElasticComponent();
    }
}