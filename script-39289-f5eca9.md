# Архитектура кода

## Введение

```
https://github.com/symfony/demo/blob/main/src/Controller/BlogController.php
```

## LIVE

```sh
docker exec otus-php-architecture--php php bin/console cache:clear
```

### Domain/ValueObject

```php
class Name
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidName($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidName(string $value): void
    {
        if (mb_strlen($value) < 3) {
            throw new \InvalidArgumentException('Name must be at least 3 characters long');
        }
    }
}
```

```php
class Phone
{
    private string $value;

    public function __construct(string $value)
    {
        $this->assertValidPhone($value);
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    private function assertValidPhone(string $value): void
    {
        if (!preg_match('/^\d{10}$/', $value)) {
            throw new \InvalidArgumentException('Phone number must contain exactly 10 digits');
        }
    }
}
```

### Domain/Entity

```php
class Lead
{
    private ?int $id = null;

    public function __construct(
        private Name  $name,
        private Phone $phone
    )
    {
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): Name
    {
        return $this->name;
    }

    public function getPhone(): Phone
    {
        return $this->phone;
    }
}
```

### Domain/Factory

```php
interface LeadFactoryInterface
{
    public function create(string $name, string $phone): Lead;
}
```

### Domain/Repository

```php
interface LeadRepositoryInterface
{
    /**
     * @return Lead[]
     */
    public function findAll(): iterable;

    public function findById(int $id): ?Lead;

    public function save(Lead $lead): void;

    public function delete(Lead $lead): void;
}
```

---

### Application/UseCase/SubmitLead

```php
class SubmitLeadUseCase
{
    public function __invoke()
    {
        // Создать лид
        // Сохранить лид в базу
        // Отправить лид в банк
        // Вернуть результат
    }
}
```

```php
class SubmitLeadRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $phone,
    )
    {
    }
}
```

```php
class SubmitLeadResponse
{
    public function __construct(
        public readonly int $id,
        public readonly int $bankId,
    )
    {
    }
}
```

```php
class SubmitLeadUseCase
{
    public function __invoke(SubmitLeadRequest $request): SubmitLeadResponse
    {
        // Создать лид
        // Сохранить лид в базу
        // Отправить лид в банк
        // Вернуть результат
    }
}
```

```php
class SubmitLeadUseCase
{
    public function __construct(
        private readonly LeadFactoryInterface    $leadFactory,
        private readonly LeadRepositoryInterface $leadRepository,
    )
    {
    }

    public function __invoke(SubmitLeadRequest $request): SubmitLeadResponse
    {
        // Создать лид
        $lead = $this->leadFactory->create($request->name, $request->phone);

        // Сохранить лид в базу
        $this->leadRepository->save($lead);

        // Отправить лид в банк
        // Вернуть результат
    }
}
```

### Application/Gateway

```php
class BankGatewayRequest
{
    public function __construct(
        public readonly string $name,
        public readonly string $phone,
    )
    {
    }
}
```

```php
class BankGatewayResponse
{
    public function __construct(
        public readonly int $bankId,
    )
    {
    }
}
```

```php
interface BankGatewayInterface
{
    public function sendLead(BankGatewayRequest $request): BankGatewayResponse;
}
```

### Application/UseCase/SubmitLead

```php
class SubmitLeadUseCase
{
    public function __construct(
        private readonly LeadFactoryInterface    $leadFactory,
        private readonly LeadRepositoryInterface $leadRepository,
        private readonly BankGatewayInterface $bankGateway,
    )
    {
    }

    public function __invoke(SubmitLeadRequest $request): SubmitLeadResponse
    {
        // Создать лид
        $lead = $this->leadFactory->create($request->name, $request->phone);

        // Сохранить лид в базу
        $this->leadRepository->save($lead);

        // Отправить лид в банк
        $bankGatewayRequest = new BankGatewayRequest($request->name, $request->phone);
        $bankGatewayResponse = $this->bankGateway->sendLead($bankGatewayRequest);

        // Вернуть результат
        return new SubmitLeadResponse(
            $lead->getId(),
            $bankGatewayResponse->bankId,
        );
    }
}
```

---

### Infrastructure/Factory

```php
class CommonLeadFactory implements LeadFactoryInterface
{

    public function create(string $name, string $phone): Lead
    {
        return new Lead(
            new Name($name),
            new Phone($phone),
        );
    }
}
```

### Infrastructure/Repository

```php
class FileLeadRepository implements LeadRepositoryInterface
{

    public function findAll(): iterable
    {
        // TODO: Implement findAll() method.
        return [];
    }

    public function findById(int $id): ?Lead
    {
        // TODO: Implement findById() method.
        return null;
    }

    public function save(Lead $lead): void
    {
        // Имитация сохранения в БД с присваиванием ID
        $reflectionProperty = new \ReflectionProperty(Lead::class, 'id');
        $reflectionProperty->setAccessible(true);
        $reflectionProperty->setValue($lead, 1);
    }

    public function delete(Lead $lead): void
    {
        // TODO: Implement delete() method.
    }
}
```

### Infrastructure/Gateway

```php
class BetaBankGateway implements BankGatewayInterface
{
    public function sendLead(BankGatewayRequest $request): BankGatewayResponse
    {
        sleep(2);
        $bankId = random_int(10_000, 99_999);
        if ($bankId % 10 <= 2) {
            throw new \Exception('Failed to send lead due to bank error');
        }
        return new BankGatewayResponse($bankId);
    }
}
```

### Infrastructure/Http

```php
use App\Application\UseCase\SubmitLead\SubmitEventUseCase;
use App\Application\UseCase\SubmitLead\SubmitLeadRequest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class SubmitLeadController extends AbstractFOSRestController
{
    public function __construct(
        private SubmitEventUseCase $useCase,
    )
    {
    }

    /**
     * @Rest\Post("/api/v1/leads")
     * @ParamConverter("request", converter="fos_rest.request_body")
     * @param SubmitLeadRequest $request
     * @return Response
     */
    public function __invoke(SubmitLeadRequest $request): Response
    {
        try {
            $response = ($this->useCase)($request);
            $view = $this->view($response, 201);
        } catch (\Throwable $e) {
            // todo В реальности используются более сложные обработчики ошибок
            $errorResponse = [
                'message' => $e->getMessage()
            ];
            $view = $this->view($errorResponse, 400);
        }
        return $this->handleView($view);
    }
}
```

---

### Infrastructure/Command

```php
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use App\Application\UseCase\SubmitLead\SubmitEventUseCase;
use App\Application\UseCase\SubmitLead\SubmitLeadRequest;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:submit-lead')]
class SubmitLeadCommand extends Command
{
    public function __construct(
        private SubmitEventUseCase $useCase,
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('name', InputArgument::REQUIRED, 'Name')
            ->addArgument('phone', InputArgument::REQUIRED, 'Phone');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $submitLeadRequest = new SubmitLeadRequest(
                $input->getArgument('name'),
                $input->getArgument('phone'),
            );
            $submitLeadResponse = ($this->useCase)($submitLeadRequest);
            $output->writeln('Lead ID: ' . $submitLeadResponse->id);
            $output->writeln('Bank ID: ' . $submitLeadResponse->bankId);
            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln($e->getMessage());
            return Command::FAILURE;
        }
    }
}
```

```sh
docker exec otus-php-architecture--php \
  php bin/console app:submit-lead \
  Дмитрий 9051234567
```

## Ссылка на опрос

```
https://otus.ru/polls/99094/
```
