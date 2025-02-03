<?php

namespace KRudenko\Otus\Command;

use Exception;
use InvalidArgumentException;
use KRudenko\Otus\Service\SearchServiceInterface;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand('app:search', 'Search in Elasticsearch')]
class SearchCommand extends Command
{
    public function __construct(
        private readonly SearchServiceInterface $elasticService
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addOption(
                'filter',
                'f',
                InputOption::VALUE_REQUIRED | InputOption::VALUE_IS_ARRAY,
                'Фильтры в формате: 
- Точное значение: field=value
- Диапазон: field[operator]=value (операторы: eq, gt, gte, lt, lte)
- Множественные значения: field[]=value1&field[]=value2
- Поиск по подстроке: field~=value
Примеры: 
- -f "title=PHP"
- -f "price[gte]=100" -f "price[lte]=200"
- -f "genre[]=fiction" -f "genre[]=programming"
- -f "description~=best"',
                []
            )
            ->addOption('index', null, InputOption::VALUE_OPTIONAL, 'index for elasticsearch', $_ENV['ELASTIC_INDEX'])
            ->addOption('page', null, InputOption::VALUE_OPTIONAL, 'Номер страницы', 1)
            ->setHelp(sprintf('Если опции не указывать, будут выведены первые %d книг', $_ENV['PAGE_SIZE']));
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $results = $this->elasticService->search(
                $this->parseFilters($input->getOption('filter')),
                $input->getOption('page'),
                $input->getOption('index'),
            );

            $output->writeln("Search results:");
            $output->writeln(json_encode($results, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));

            return Command::SUCCESS;
        } catch (Exception $e) {
            $output->writeln('<error>Search failed: ' . $e->getMessage() . '</error>');
            return Command::FAILURE;
        }
    }

    private function parseFilters(array $filters): array
    {
        $criteria = [];

        foreach ($filters as $filter) {
            $parts = explode('=', $filter, 2);
            if (count($parts) !== 2) {
                throw new InvalidArgumentException("Некорректный формат фильтра: $filter");
            }

            [$fieldWithOperator, $value] = $parts;
            $this->parseFieldOperator($fieldWithOperator, $field, $operator);

            $criteria = $this->addCriterion($criteria, $field, $operator, $value);
        }

        return $criteria;
    }

    private function parseFieldOperator(string $fieldWithOperator, &$field, &$operator): void
    {
        if (preg_match('/^([\w~]+)(\[([\w~]+)])?$/', $fieldWithOperator, $matches)) {
            $field = $matches[1];
            $operator = $matches[3] ?? 'eq';

            // Специальная обработка для ~=
            if (str_contains($field, '~')) {
                $operator = 'match';
                $field = str_replace('~', '', $field);
            }
        } else {
            throw new InvalidArgumentException("Некорректный формат поля: $fieldWithOperator");
        }
    }

    private function addCriterion(array $criteria, string $field, string $operator, string $value): array
    {
        switch ($operator) {
            case 'eq':
                if (isset($criteria[$field]['in'])) {
                    $criteria[$field]['in'][] = $value;
                } else {
                    $criteria[$field] = $value;
                }
                break;

            case 'in':
                $criteria[$field]['in'] = array_merge(
                    $criteria[$field]['in'] ?? [],
                    explode(',', $value)
                );
                break;

            case 'gte':
            case 'gt':
            case 'lte':
            case 'lt':
                $criteria[$field]['range'][$operator] = $value;
                break;

            case 'match':
                $criteria[$field]['match'] = $value;
                break;

            default:
                throw new InvalidArgumentException("Неподдерживаемый оператор: $operator");
        }

        return $criteria;
    }
}
