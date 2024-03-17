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
            $count = 0;
            do {
                $res = preg_replace('/\(([^\(\)]*)\)/i', '', $param, -1, $count);
                if (is_null($res) || $count <= 0) {
                    break;
                }
                $param = $res;
            } while (true);

            if (strpos($param, '(') || strpos($param, ')')) {
                $result->addError('Bad Parentheses.' . $param);
            } else {
                $result->addMessage('Parentheses are good.');
            }
        }

        return $result;
    }
}
