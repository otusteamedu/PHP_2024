<?php

enum ErrorCodeValPost
{
    case EmptyPost;
    case CloseBracketBeforeOpen;
    case CloseBracketАbsent;
    case Ok;
}


class ValidatePost{

    public function validate($post): ErrorCodeValPost{
        
        if(!isset($post["code"])) return ErrorCodeValPost::EmptyPost; 
        $code = $_POST["code"];
        
        $i = 0;
        $open_bracket = 0;
        do {
            $char = substr($code, $i, 1);
            if( $char == "(" ) $open_bracket++;        
            if( $char  == ")" ) $open_bracket--;
            if($open_bracket < 0 )
                return ErrorCodeValPost::CloseBracketBeforeOpen;
            ++$i;
        } while (isset($code{$i}));
        
        if($open_bracket != 0 )
            return ErrorCodeValPost::CloseBracketАbsent;

        return ErrorCodeValPost::Ok;    
    }
}