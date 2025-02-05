<?php

namespace Functional;

use App\Application\BotCommand\BotCommandEnum\BotCommandEnum;
use App\Application\TextMessageEnum\TextMessageEnum;
use Support\Helper\AbstractFunctionalHelper;

class UseCaseTest extends AbstractFunctionalHelper
{
    public function testGetCheckListWhenEmpty(): void
    {
        $this->getCheckList();

        $expectedData = TextMessageEnum::ShoppingListEmpty->value;

        $realData = $this->getDataFromLog();

        $this->tester->assertTrue(str_contains($realData, $expectedData));
    }

    public function testGetCheckListWithItems(): void
    {
        $updateWithItems = $this->createItemOfShoppingList();

        $this->getCheckList();

        $expectedPurchaseArray = $this->messageService->getItemNotPurchasedByChatId(
            $updateWithItems->message->chat->id
        );
        $expectedTitle = TextMessageEnum::CheckList->value;

        $expectedHtmlContent = $this->twig->render('bot-message/check-list.html.twig', [
            'title' => $expectedTitle,
            'items' => $expectedPurchaseArray,
        ]);

        $realData = $this->getDataFromLog();

        $this->tester->assertTrue(
            str_contains($realData, json_encode($expectedHtmlContent, JSON_UNESCAPED_UNICODE))
            && str_contains($realData, $expectedTitle)
            && str_contains($realData, trim($expectedPurchaseArray[0]->title))
            && str_contains($realData, trim($expectedPurchaseArray[1]->title))
        );
    }

    public function testPlanShopping(): void
    {
        $updateWithItems = $this->createItemOfShoppingList();

        $expectedPurchaseArray = $this->getExpectedPurchaseArray($updateWithItems);

        $realPurchaseArray = explode(BotCommandEnum::PurchaseSeparatorDot->value, $updateWithItems->message->text);

        $this->tester->assertSame(trim($realPurchaseArray[0]), $expectedPurchaseArray[0]->getTitle());
        $this->tester->assertSame(trim($realPurchaseArray[1]), $expectedPurchaseArray[1]->getTitle());
    }

    public function testGetShoppingListWhenEmpty(): void
    {
        $this->getShoppingListUpdate();

        $expectedData = TextMessageEnum::ShoppingListEmpty->value;

        $realData = $this->getDataFromLog();

        $this->tester->assertTrue(str_contains($realData, $expectedData));
    }

    public function testGetShoppingListWithItems(): void
    {
        $updateWithItems = $this->createItemOfShoppingList();

        $this->getShoppingListUpdate();

        $expectedData = TextMessageEnum::ShoppingList->value;
        $expectedPurchaseArray = $this->getExpectedPurchaseArray($updateWithItems);
        $expectedMarkdown = $this->getMarkdownForTestGetShoppingListWithItems(
            [$expectedPurchaseArray[0]->getId(), $expectedPurchaseArray[1]->getId()]
        );

        $realData = $this->getDataFromLog();

        $this->tester->assertTrue(
            str_contains($realData, $expectedData)
            && str_contains($realData, $expectedMarkdown)
            && str_contains($realData, $expectedPurchaseArray[0]->getTitle())
            && str_contains($realData, $expectedPurchaseArray[1]->getTitle())
            && str_contains($realData, BotCommandEnum::ItemRemove->value
                                            . BotCommandEnum::CommandSeparator->value
                                            . $expectedPurchaseArray[0]->getId())
            && str_contains($realData, BotCommandEnum::ItemRemove->value
                                            . BotCommandEnum::CommandSeparator->value
                                            . $expectedPurchaseArray[1]->getId())
        );
    }

    public function testDoShopping(): void
    {
        $updateWithItems = $this->createItemOfShoppingList();

        $updateRemoveItemFromShoppingList = $this->getUpdateObject(
            'RemoveItemFromShoppingList',
            $this->getPurchaseIdArrayByUpdate($updateWithItems)
        );
        $this->chatHandler->handleChatUpdate($updateRemoveItemFromShoppingList);

        $expectedPurchaseArray = $this->getExpectedPurchaseArray($updateRemoveItemFromShoppingList);
        $expectedMarkdown = $this->getMarkdownForTestRemoveItemFromShoppingListUpdate(
            $expectedPurchaseArray[1]->getId()
        );

        $realData = $this->getDataFromLog();

        $this->tester->assertTrue(
            str_contains($realData, $expectedMarkdown)
            && $expectedPurchaseArray[0]->getIsPurchased()
            && $expectedPurchaseArray[0]->getFirstName() === $updateRemoveItemFromShoppingList->callbackQuery->from->firstName
            && $expectedPurchaseArray[0]->getUserName() === $updateRemoveItemFromShoppingList->callbackQuery->from->username
            && $expectedPurchaseArray[0]->getTelegramUserId() === $updateRemoveItemFromShoppingList->callbackQuery->from->id
        );
    }

    public function testShoppingCompleted(): void
    {
        $updateWithOneItem = $this->getUpdateObject('PlanShoppingOneItem');
        $this->chatHandler->handleChatUpdate($updateWithOneItem);

        $updateRemoveItemFromShoppingList = $this->getUpdateObject(
            'RemoveLastItemFromShoppingList',
            $this->getPurchaseIdArrayByUpdate($updateWithOneItem),
        );
        $this->chatHandler->handleChatUpdate($updateRemoveItemFromShoppingList);

        $expectedData = TextMessageEnum::ShoppingListCompleted->value;

        $realData = $this->getDataFromLog();

        $this->tester->assertTrue(str_contains($realData, $expectedData));
    }
}
