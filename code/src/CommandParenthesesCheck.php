<?php

namespace IraYu\OtusHw4;

class CommandParenthesesCheck implements Command
{
    public function execute(Request $request): Result
    {
        $result = new CommandResult();

        $param = $request->get('string');
        if (empty($param)) {
            $result->addError('Required parameter "string" is empty.');
        } else {
            $pointer = 0;
            $length = strlen($param);
            for ($i = 0; $i < $length; $i++) {
                if ($param[$i] === '(') {
                    $pointer++;
                } else if ($param[$i] === ')') {
                    $pointer--;
                    if ($pointer < 0) {
                        break;
                    }
                }
            }
            if ($pointer !== 0) {
                $result->addError('Bad Parentheses.' . $param);
            }
        }

        return $result;
    }
}
