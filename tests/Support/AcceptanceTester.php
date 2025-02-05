<?php

declare(strict_types=1);

namespace App\Tests\Support;

use App\Controller\Cli\CodeceptionSupportCommand\CodeceptionSupportCommandEnum\CodeceptionSupportCommandEnum;
use Codeception\Actor;
use Codeception\Util\HttpCode;
use Support\Data\UpdateForEachUseCase\PlanShoppingTwoItems;
use Support\Data\UpdateForEachUseCase\RemoveItemFromShoppingList;

/**
 * Inherited Methods
 *
 * @method void wantTo($text)
 * @method void wantToTest($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause($vars = [])
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends Actor
{
    use _generated\AcceptanceTesterActions;

    private const COMMAND_REMOVE_MESSAGE = CodeceptionSupportCommandEnum::FindAndRemoveTestMessageCommandName->value;
    private const COMMAND_GET_PURCHASE_ID = CodeceptionSupportCommandEnum::GetTestPurchaseIdCommandName->value;
    private const COMMAND_REMOVE_PURCHASE = CodeceptionSupportCommandEnum::FindAndRemoveTestPurchaseCommandName->value;
    private const EXPECTED_CODE  = 0;


    public function createItemOfShoppingList(): void
    {
        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->send('POST', '', (new PlanShoppingTwoItems())::getUpdateString());
        $this->canSeeResponseCodeIs(HttpCode::OK);
    }

    public function checkItemAndCleanDB(): void
    {
        $checkUpdateAndCleanDBCommand = 'php bin/console ' . self::COMMAND_REMOVE_MESSAGE;
        exec($checkUpdateAndCleanDBCommand,$message,$code);
        echo $message[0];
        if (self::EXPECTED_CODE !== $code) {
            $this->canSeeResponseCodeIs(HttpCode::I_AM_A_TEAPOT);
        }

        $this->canSeeResponseCodeIs(HttpCode::OK);
    }

    public function markItemAsPurchased(): void
    {
        $getTestPurchaseIdCommand = 'php bin/console ' . self::COMMAND_GET_PURCHASE_ID;
        exec($getTestPurchaseIdCommand,$message,$code);
        if (self::EXPECTED_CODE !== $code) {
            echo $message[0];
            $this->canSeeResponseCodeIs(HttpCode::I_AM_A_TEAPOT);
        }

        $idArray = explode(';', $message[0]);
        $this->haveHttpHeader('Content-Type', 'application/json');
        $this->send('POST', '', (new RemoveItemFromShoppingList())::getUpdateString($idArray));
        $this->canSeeResponseCodeIs(HttpCode::OK);
    }

    public function checkItemAsPurchasedAndCleanDB(): void
    {
        $checkUpdateAndCleanDBCommand = 'php bin/console ' . self::COMMAND_REMOVE_PURCHASE;
        exec($checkUpdateAndCleanDBCommand,$message,$code);
        echo $message[0];
        if (self::EXPECTED_CODE !== $code) {
            $this->canSeeResponseCodeIs(HttpCode::I_AM_A_TEAPOT);
        }

        $this->canSeeResponseCodeIs(HttpCode::OK);
    }
}
