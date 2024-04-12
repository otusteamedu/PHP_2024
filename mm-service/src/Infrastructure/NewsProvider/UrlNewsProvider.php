<?php
declare(strict_types=1);

namespace App\Infrastructure\NewsProvider;

use App\Application\NewsProvider\Exception\InvalidNewsDeterminationAttributesException;
use App\Application\NewsProvider\NewsProviderInterface;
use App\Domain\Entity\News;
use App\Domain\Validator\Exception\InvalidUrlException;
use App\Domain\ValueObject\Title;
use App\Domain\ValueObject\Url;
use Symfony\Component\DomCrawler\Crawler;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class UrlNewsProvider implements NewsProviderInterface
{
    public function __construct(
        private readonly HttpClientInterface $httpClient,
    )
    {
    }

    /**
     * @param mixed[] $newsDeterminationAttributes
     * @return bool
     */
    public function supports(array $newsDeterminationAttributes): bool
    {
        return array_key_exists('url', $newsDeterminationAttributes);
    }

    /**
     * @param mixed[] $newsDeterminationAttributes
     * @return News
     *
     * @throws InvalidNewsDeterminationAttributesException
     */
    public function retrieve(array $newsDeterminationAttributes): News
    {
        $url = $this->getUrlFromAttributes($newsDeterminationAttributes);

        $response = $this->httpClient->request('GET', $url->getValue());

        $crawler = new Crawler($response->getContent());

        $title = $crawler->filterXPath('//title[1]')->text();

        return new News(
            new Title($title),
            $url,
        );
    }

    /**
     * @param mixed[] $attributes
     * @return Url
     *
     * @throws InvalidNewsDeterminationAttributesException
     */
    private function getUrlFromAttributes(array $attributes): Url
    {
        if (false === array_key_exists('url', $attributes)) {
            throw new InvalidNewsDeterminationAttributesException('Attribute "url" is required.');
        }

        try {
            return new Url($attributes['url']);
        } catch (InvalidUrlException $e) {
            throw new InvalidNewsDeterminationAttributesException($e->getMessage(), $e);
        }
    }
}
