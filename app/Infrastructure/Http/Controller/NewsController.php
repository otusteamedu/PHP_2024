<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use App\Application\UseCase\CreateNews;
use App\Application\UseCase\CreateReport;
use App\Application\UseCase\ParseNewsTitle;
use App\Application\UseCase\Request\CreateNewsRequest;
use App\Application\UseCase\Request\CreateReportRequest;
use App\Application\UseCase\Request\ParseNewsTitleRequest;
use App\Domain\Exceptions\ReportFileCreateException;
use App\Domain\Exceptions\Validate\UrlValidateException;
use App\Infrastructure\Database\Connection;
use App\Infrastructure\Repository\NewsRepository;
use Carbon\Carbon;

class NewsController extends Controller
{
    /**
     * @throws UrlValidateException
     */
    public function create(...$params): string
    {
        $url = $params['url'];
        $title = (new ParseNewsTitle())(new ParseNewsTitleRequest($url))->title;
        $newsRequest = new CreateNewsRequest(Carbon::now()->toDateString(), $title, $url);

        $response = (new CreateNews(new NewsRepository(Connection::getInstance())))($newsRequest);

        return json_encode(['id' => $response->id]);
    }

    /**
     * @throws ReportFileCreateException
     */
    public function createReport(...$params): string
    {
        $ids = json_decode($params['ids']);

        $reportRequest = new CreateReportRequest($ids, config('report_path'));
        $response = (new CreateReport(new NewsRepository(Connection::getInstance())))($reportRequest);

        return env('APP_HOST') . '/reports/' . $response->fileName;
    }

    public function getAll(): string
    {
        return json_encode((new NewsRepository(Connection::getInstance()))->getAll());
    }
}
