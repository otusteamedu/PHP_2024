<?php

declare(strict_types=1);

namespace SFadeev\Hw12\Infrastructure\Condition;

use Doctrine\Common\Lexer\Token;
use RuntimeException;
use SFadeev\Hw12\Infrastructure\Condition\AST\Comparison;
use SFadeev\Hw12\Infrastructure\Condition\AST\Logical;
use SFadeev\Hw12\Infrastructure\Condition\AST\Parameter;

class Parser
{
    public function __construct(
        private Lexer $lexer,
    ) {
    }

    public function parse(string $input): Logical
    {
        $this->lexer->setInput($input);

        $this->lexer->moveNext();

        return $this->getLogicalExpression();
    }

    private function getLogicalExpression()
    {
        $comparisonExpr = $this->getComprasionExpression();

        if ($this->lexer->isNextToken(Lexer::T_COMMA)) {
            $this->lexer->moveNext();
            return new Logical($comparisonExpr, Logical::T_AND, $this->getLogicalExpression());
        }

        return new Logical($comparisonExpr, Logical::T_AND, true);
    }

    private function getComprasionExpression()
    {
        switch ($this->lexer->glimpse()?->type ?? null) {
            case Lexer::T_EQUALS:
                $paramExpr = $this->getParameterExpression();
                $this->lexer->moveNext();
                $value = $this->getValue();
                $expression = new Comparison($paramExpr, Comparison::T_EQUAL, $value);
                break;
            default:
                $this->syntaxError('=');
        }

        return $expression;
    }

    private function getParameterExpression(): Parameter
    {
        $lookaheadType = $this->lexer->lookahead?->type ?? null;

        if (Lexer::T_NAME !== $lookaheadType) {
            $this->syntaxError('T_NAME');
        }

        $this->lexer->moveNext();

        return new Parameter($this->lexer->token->value);
    }

    private function getValue(): int|float|string|bool
    {
        $lookaheadType = $this->lexer->lookahead?->type ?? null;

        $value = match ($lookaheadType ?? null) {
            Lexer::T_INTEGER => (int)$this->lexer->lookahead->value,
            Lexer::T_FLOAT => (float)$this->lexer->lookahead->value,
            Lexer::T_BOOL => (bool)$this->lexer->lookahead->value,
            Lexer::T_STRING => $this->lexer->lookahead->value,
            default => $this->syntaxError('T_INTEGER, T_FLOAT, T_STRING, T_BOOL'),
        };

        $this->lexer->moveNext();

        return $value;
    }

    private function syntaxError(string $expected = '', Token|null $token = null): never
    {
        if ($token === null) {
            $token = $this->lexer->lookahead;
        }

        $tokenPos = $token->position ?? '-1';

        $message = sprintf('line 0, col %d: Error: ', $tokenPos);
        $message .= $expected !== '' ? sprintf('Expected %s, got ', $expected) : 'Unexpected ';
        $message .= $this->lexer->lookahead === null ? 'end of string.' : sprintf("'%s'", $token->value);

        throw new RuntimeException($message);
    }
}
