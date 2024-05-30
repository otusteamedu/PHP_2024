<?php

namespace App\services\renders;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;
use Twig\Loader\FilesystemLoader;


class TwigRender implements IRender
{
    protected $twig;

    public function __construct()
    {
        $loader = new FilesystemLoader([dirname(dirname(__DIR__)) . '/templates/Admin',
                dirname(dirname(__DIR__)) . '/templates/AuthUser',
                dirname(dirname(__DIR__)) . '/templates',]

        );

        $this->twig = new Environment($loader);
    }

    public function render($template, $params = [])
    {
        $template .= '.php.twig';
        try {
            return $this->twig->render($template, $params);
        } catch (LoaderError $e) { echo $e->getMessage();
        } catch (RuntimeError $e) { echo $e->getMessage();
        } catch (SyntaxError $e) { echo $e->getMessage();
        }
    }
}



