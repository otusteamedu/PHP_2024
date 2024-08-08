<?php

declare(strict_types=1);

namespace Viking311\Analytics\Command;

use Viking311\Analytics\Http\Request\Request;
use Viking311\Analytics\Http\Response\Response;
use Viking311\Analytics\Registry\RegistryFactory;

class SearchCommand implements CommandInterface
{
    /**
     * @param Request $request
     * @param Response $response
     * @return void
     */
    public function run(Request $request, Response $response) :void
    {
        if ($request->getMethod() !== 'GET') {
            $response->setResultCode(400);
            $response->setContent('Only GET method allowed');
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

        if (!property_exists($data, 'params')) {
            $response->setResultCode(400);
            $response->setContent('Params were not defined');
            return;
        }

        try {
            $registry = RegistryFactory::createInstance();   
            $result = $registry->search(
                (array) $data->params
            );
            if (!is_null($result)) {
                $response->setResultCode(200);
                $response->setContent(
                    json_encode($result)
                );    
            } else {
                $response->setResultCode(404);
            }
        } catch (\Exception) {
            $response->setResultCode(500);
        }
    }
}
