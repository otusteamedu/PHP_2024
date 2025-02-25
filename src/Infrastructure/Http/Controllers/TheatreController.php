<?php

declare(strict_types=1);

namespace Infrastructure\Http\Controllers;

use Application\Services\TheatreService;
use Domain\Entities\Theatre;

class TheatreController
{
    private TheatreService $theatreService;

    public function __construct(TheatreService $theatreService)
    {
        $this->theatreService = $theatreService;
    }

    public function index(): false|string
    {
        $theatres = $this->theatreService->getAllTheatres();

        return json_encode($theatres, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function show(int $id): false|string
    {
        $theatre = $this->theatreService->getTheatreById($id);

        return json_encode($theatre, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    }

    public function store(Theatre $theatre): bool
    {
        $this->theatreService->createTheatre($theatre);

        return true;
    }

    public function update(Theatre $theatre): bool
    {
        $this->theatreService->updateTheatre($theatre);

        return true;
    }

    public function destroy(int $id): bool
    {
        $this->theatreService->deleteTheatre($id);

        return true;
    }
}
