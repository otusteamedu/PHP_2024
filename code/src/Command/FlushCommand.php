<?php

declare(strict_types=1);

namespace Viking311\Analytics\Command;

use Viking311\Analytics\Http\Request\Request;
use Viking311\Analytics\Http\Response\Response;
use Viking311\Analytics\Registry\RegistryFactory;

class FlushCommand implements CommandInterface
{
    
    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function run(Request $request, Response $response): void
    {
        if ($request->getMethod() !== 'GET') {
            $response->setResultCode(400);
            $response->setContent('Only GET method allowed');
            return;
        }

        try {
            $registry = RegistryFactory::createInstance();
            $registry->flush();
            
            $response->setResultCode(200);            
            $response->setContent('Ok');
        } catch (\Exception) {
            $response->setResultCode(500);
        }
    }
}
