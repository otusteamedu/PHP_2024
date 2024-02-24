<?php

namespace Pavelsergeevich\Hw6\Controllers;

use Pavelsergeevich\Hw6\Core\Controller;

class EmailController extends Controller
{
    /**
     * @throws \Exception
     */
    public function validationAction(): void
    {
        $resultValidation = $this->model->checkEmailValidation();
        if ($resultValidation['isSuccess']) {
            $this->view->render($resultValidation['data']);
        } else {
            $this->view->render();
        }
    }
}