<?php

namespace App;

use App\Actions\SearchAction;
use App\Actions\SeedAction;
use App\Components\ElasticComponent;
use App\Console\Input;
use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\MissingParameterException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use InvalidArgumentException;

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
        match ($input->action) {
            'seed' => (new SeedAction())->run(),
            'search' => (new SearchAction())->run($input->template, $input->title, $input->price),
            default => throw new InvalidArgumentException('Command does not exist.')
        };
    }

    protected function registerComponents(): void
    {
        $this->elastic = new ElasticComponent();
    }
}
