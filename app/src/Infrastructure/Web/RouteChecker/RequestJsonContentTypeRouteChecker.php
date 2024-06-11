<?php

declare(strict_types=1);

namespace App\Infrastructure\Web\RouteChecker;

use Symfony\Bundle\FrameworkBundle\Routing\Attribute\AsRoutingConditionService;
use Symfony\Component\HttpFoundation\Request;

//Usage:
// #[Route('/', methods: ['POST'], condition: "service('request_json_content_type_route_checker').check(request)")]
#[AsRoutingConditionService(alias: 'request_json_content_type_route_checker')]
class RequestJsonContentTypeRouteChecker
{
    public function check(Request $request): bool
    {
        return $request->getContentTypeFormat() === 'json';
    }
}
