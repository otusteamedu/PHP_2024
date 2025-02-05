<?php

namespace Acceptance;

use App\Tests\Support\AcceptanceTester;

class UseCaseCest
{
    public function testCreateItemOfShoppingListUseCase(AcceptanceTester $I): void
    {
        $I->createItemOfShoppingList();

        $I->checkItemAndCleanDB();
    }

    public function testRemoveItemFromShoppingListUseCase(AcceptanceTester $I): void
    {
        $I->createItemOfShoppingList();

        $I->markItemAsPurchased();

        $I->checkItemAsPurchasedAndCleanDB();
    }
}

