<?php

declare(strict_types=1);

namespace Application\Trading;

use Domain\Trading\Entities\TradeNotification;
use Domain\Trading\Services\AbstractTradingStrategy;
use Domain\User\Entities\User;
use Domain\Trading\Entities\Trade;
use Domain\Trading\ValueObjects\MarketData;
use Domain\Trading\Strategies\SimpleMovingAverageStrategy;
use Domain\Trading\Strategies\RandomStrategy;
use Domain\Notification\Services\NotificationServiceInterface;

class TradeService
{
    private NotificationServiceInterface $notificationService;

    public function __construct(NotificationServiceInterface $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    public function executeTrade(User $user, MarketData $marketData, string $strategyType): void
    {
        $strategy = $this->createStrategy($strategyType);
        $tradeDecision = $strategy->analyze($marketData);

        $trade = new Trade(
            1, // Идентификатор сделки
            $tradeDecision->getType(),
            $tradeDecision->getAsset(),
            $tradeDecision->getQuantity(),
            $tradeDecision->getPrice()
        );

        $tradeNotification = new TradeNotification($user, $trade, $this->notificationService);
        $tradeNotification->sendNotification();
    }

    private function createStrategy(string $strategyType): AbstractTradingStrategy
    {
        switch ($strategyType) {
            case 'simple_moving_average':
                return new SimpleMovingAverageStrategy();
            case 'random':
                return new RandomStrategy();
            default:
                throw new \InvalidArgumentException('Invalid strategy type');
        }
    }
}
