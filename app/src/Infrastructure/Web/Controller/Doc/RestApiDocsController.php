<?php

declare(strict_types=1);

namespace App\Infrastructure\Web\Controller\Doc;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\DependencyInjection\Attribute\Autowire;

class RestApiDocsController extends AbstractController
{
    #[Route('/restapi-docs', methods: ['GET'])]
    public function __invoke(#[Autowire('%kernel.project_dir%')] string $projectDir): BinaryFileResponse
    {
        $file = new File($projectDir . '/docs/openapi_built.yaml');
        return $this->file($file, 'openapi.yaml');
    }
}
