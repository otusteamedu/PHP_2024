<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

class Controller extends BaseController
{
    /**
     * @OA\Info(
     *     title="Your API Title",
     *     version="1.0.0",
     *     description="A detailed description of your API.",
     *     @OA\Contact(
     *         name="Your Name",
     *         url="https://yourwebsite.com",
     *         email="your-email@example.com"
     *     ),
     *     @OA\License(
     *         name="Apache 2.0",
     *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
     *     )
     * )
     */
}
