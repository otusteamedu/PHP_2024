<?php
namespace App;

use App\Controllers\StatementController;

class Router {
    private $controller;

    public function __construct() {
        $this->controller = new StatementController();
    }

    public function route() {
        $action = isset($_GET['action']) ? $_GET['action'] : 'form';

        switch ($action) {
            case 'process':
                $this->controller->processForm();
                break;
            case 'form':
            default:
                $this->controller->showForm();
                break;
        }
    }
}