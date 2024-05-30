<?php


namespace App\services\renders;


class TmpRender implements IRender
{
    public function render($template, $params=[])
    {
        $content = $this->renderTmpl($template, $params);
        return $this->renderTmpl('layouts/main', ['content'=>$content]);
    }
    public function renderTmpl($template, $params=[])
    {
        ob_start();
        extract($params);
        include dirname(dirname(__DIR__)) . '/views/' . $template . '.php';
        return ob_get_clean();
    }
}