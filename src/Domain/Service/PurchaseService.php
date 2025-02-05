<?php

namespace App\Domain\Service;

use App\Domain\Entity\Purchase;
use App\Domain\Model\ShoppingListItem\ShoppingListItemModel;
use App\Domain\Model\Purchase\PurchaseModel;
use App\Domain\RepositoryInterface\PurchaseRepositoryInterface;

class PurchaseService
{
    public function __construct(
        private readonly PurchaseRepositoryInterface $purchaseRepository,
    ) {
    }

    public function createPurchase(PurchaseModel $purchaseModel): Purchase
    {
        $purchase = new Purchase();
        $purchase->setTitle($purchaseModel->title);
        $purchase->setIsPurchased($purchaseModel->isPurchased);

        $this->purchaseRepository->create($purchase);

        return $purchase;
    }

    public function markItemAsPurchasedById(ShoppingListItemModel $itemFromCheckListModel)
    {
        $purchase = $this->getPurchaseById($itemFromCheckListModel->id);
        $purchase->setIsPurchased($itemFromCheckListModel->isPurchased);
        $purchase->seTelegramUserId($itemFromCheckListModel->userId);
        $purchase->setFirstName($itemFromCheckListModel->firstName);
        $purchase->setUserName($itemFromCheckListModel->userName);
        $purchase->setIsBot($itemFromCheckListModel->isBot);
        $purchase->setDate($itemFromCheckListModel->date);

        $this->purchaseRepository->update($purchase);
    }

    private function getPurchaseById(int $id): Purchase
    {
        return  $this->purchaseRepository->getPurchaseById($id);
    }

    public function remove(Purchase $purchase): void
    {
        $this->purchaseRepository->remove($purchase);
    }
}
