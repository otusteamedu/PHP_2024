<?php

namespace AnatolyShilyaev\Backend\Application\UseCase\ParseCourtCases;

class ParseCourtCasesUseCase
{
    public function __construct(
        private GetCourtCaseHtmlUseCase $htmlUseCase,
        private ParseCourtCaseFromHtmlUseCase $parserUseCase
    ) {
        //empty
    }

    public function __invoke(string $url): array
    {
        $htmlResult = ($this->htmlUseCase)($url);
        if ($htmlResult['status'] !== 'success') {
            return $htmlResult;
        }

        return ($this->parserUseCase)($htmlResult['html'], $htmlResult['title']);
    }
}
