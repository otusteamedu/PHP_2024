<?php

declare(strict_types=1);

namespace RailMukhametshin\Hw\Commands\Elastic;

use Elastic\Elasticsearch\Exception\ClientResponseException;
use Elastic\Elasticsearch\Exception\ServerResponseException;
use LucidFrame\Console\ConsoleTable;
use RailMukhametshin\Hw\Commands\AbstractCommand;
use RailMukhametshin\Hw\Repositories\Elastic\OtusShopRepository;
use RailMukhametshin\Hw\Traits\ConditionParsableTrait;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

/**
 * Command example: php app.php otus-shop-search "max-price=1000" "min-price=500" "title=рыцОри" "in-stock=yes"
 */
class OtusShopSearchCommand extends AbstractCommand
{
    use ConditionParsableTrait;

    const MAX_PRICE_FIELD = 'max-price';
    const MIN_PRICE_FIELD = 'min-price';
    const IN_STOCK_FIELD = 'in-stock';
    const TITLE_FIELD = 'title';

    const FIELDS = [
        self::MAX_PRICE_FIELD,
        self::MIN_PRICE_FIELD,
        self::IN_STOCK_FIELD,
        self::TITLE_FIELD
    ];

    /**
     * @throws ClientResponseException
     * @throws ServerResponseException
     * @throws UnknownProperties
     */
    public function execute(): void
    {
        $otusShopRepository = $this->container->get(OtusShopRepository::class);
        $this->parseAndSetSearchParams($otusShopRepository);
        $response = $otusShopRepository->search();
        $responseData = $response->asArray();
        $items = $this->normalizeData($responseData);
        $this->formatter->output($this->verticalPrintItems($items));
    }

    private function parseAndSetSearchParams(OtusShopRepository $otusShopRepository): void
    {
        foreach ($this->argv as $condition) {
            $fieldValue = $this->parseCondition($condition, self::FIELDS);

            if ($fieldValue !== null) {
                $value = $fieldValue->value;
                switch ($fieldValue->field) {
                    case self::MAX_PRICE_FIELD:
                        $otusShopRepository->setSearchMaxPrice((int) $value);
                        break;
                    case self::MIN_PRICE_FIELD:
                        $otusShopRepository->setSearchMinPrice((int) $value);
                        break;
                    case self::IN_STOCK_FIELD:
                        $otusShopRepository->setSearchInStock();
                        break;
                    case self::TITLE_FIELD:
                        $otusShopRepository->setSearchTitle($value);
                        break;
                }
            }
        }
    }

    private function normalizeData(array $data): array
    {
        $resultData = [];
        $items = $data['hits']['hits'];
        foreach ($items as $itemData) {
            $item = $itemData['_source'];
            $item = array_merge(['score' => $itemData['_score'], 'id' => $itemData['_id']], $item);
            $resultData[] = $item;
        }
        return $resultData;
    }

    private function arrayToString(array $items): string
    {
        $result = "";
        foreach ($items as $item) {
            $result .= "(";
            foreach ($item as $key => $value) {
                $result .= sprintf('%s => %s, ', $key, $value);
            }
            $result = trim($result, " ,");
            $result .= ") | ";
        }

        return trim($result, ", |");
    }

    private function verticalPrintItems(array $items): string
    {
        $result = "";
        foreach ($items as $item) {
            $table = new ConsoleTable();
            foreach ($item as $key => $value) {
                if (!is_array($value)) {
                    $table->addRow(array($key, $value));
                } else {
                    $table->addRow(array($key,  $this->arrayToString($value)));
                }
            }
            $result .= $table->getTable();
        }

        return $result;
    }
}
