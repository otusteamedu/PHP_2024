<?php

declare(strict_types=1);

namespace Viking311\Analytics\Command;

use InvalidArgumentException;
use Viking311\Analytics\Http\Request\Request;
use Viking311\Analytics\Http\Response\Response;
use Viking311\Analytics\Registry\EventEntity;
use Viking311\Analytics\Registry\RegistryFactory;

class AddCommand implements CommandInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function run(Request $request, Response $response) :void
    {
        if ($request->getMethod() !== 'POST') {
            $response->setResultCode(400);
            $response->setContent('Only POST method allowed');
            return;
        }

        $body = $request->getBody();

        if (empty($body)) {
            $response->setResultCode(400);
            $response->setContent('No data');
            return;
        }

        if (!json_validate($body)) {
            $response->setResultCode(400);
            $response->setContent('Invalid JSON');
            return;
        }

        $data = json_decode($body);
        
        if (!is_object($data)) {
            $response->setResultCode(400);
            $response->setContent('Invalid JSON');
            return;
        }

        try {
            $event = new EventEntity($data);

            $registry = RegistryFactory::createInstance();
            $registry->addEvent($event);
            
            $response->setResultCode(200);            
            $response->setContent('Ok');
        } catch (InvalidArgumentException $ex) {
            $response->setResultCode(400);
            $response->setContent($ex->getMessage());
            return;
        } catch (\Exception) {
            $response->setResultCode(500);
        }
    }
}
