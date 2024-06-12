<?php

declare(strict_types=1);

namespace App\Application\Actions\Image;

use App\Application\DTO\ImageDTO;
use App\Domain\Image\Status;
use Psr\Http\Message\ResponseInterface as Response;

class GetImage extends ImageAction
{
    protected function action(): Response
    {
        $id = $this->resolveArg('id');

        $image = $this->imageStorage->getImage($id);

        if ($image === null) {
            throw new \Exception("Image not found");
        }

        if ($image->getStatus() !== Status::GENERATED->value) {
            throw new \Exception("Image is not ready");
        }

        $host =  $this->request->getUri()->getScheme() . '://' . $this->request->getUri()->getHost();

        return $this->respondWithData(new ImageDTO(
            $image->getId(),
            $image->getDescription(),
            $host . $image->getPath(),
        ));
    }
}
