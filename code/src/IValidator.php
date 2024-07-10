<?php

namespace Naimushina\Webservers;

interface IValidator
{
    /**
     * Валидация параметров запроса
     * @param Request $request
     * @return void
     */
    public function validate(Request $request);
}
