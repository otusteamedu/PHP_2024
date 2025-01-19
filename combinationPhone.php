<?php

class Solution {

    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        if($digits === "") return [];
        $hash = [''];
        for($i=0;$i<strlen($digits);$i++){
            $newhash = [];
            for($k=0;$k<count($hash);$k++)
                switch($digits[$i]){
                case '1':
                    $newhash[] = $hash[$k].' ';
                break;
                case '2':
                    $newhash[] = $hash[$k].'a';
                    $newhash[] = $hash[$k].'b';
                    $newhash[] = $hash[$k].'c';
                break;
                case '3':
                    $newhash[] = $hash[$k].'d';
                    $newhash[] = $hash[$k].'e';
                    $newhash[] = $hash[$k].'f';
                break;
                case '4':
                    $newhash[] = $hash[$k].'g';
                    $newhash[] = $hash[$k].'h';
                    $newhash[] = $hash[$k].'i';
                break;
                    case '5':
                    $newhash[] = $hash[$k].'j';
                    $newhash[] = $hash[$k].'k';
                    $newhash[] = $hash[$k].'l';
                break;
                    case '6':
                    $newhash[] = $hash[k].'m';
                    $newhash[] = $hash[k].'n';
                    $newhash[] = $hash[k].'o';
                break;
                    case '7':
                    $newhash[] = $hash[k].'p';
                    $newhash[] = $hash[k].'q';
                    $newhash[] = $hash[k].'r';
                    $newhash[] = $hash[k].'s';
                break;
                case '8':
                    $newhash[] = $hash[k].'t';
                    $newhash[] = $hash[k].'u';
                    $newhash[] = $hash[k].'v';
                break; 
                case '9':
                    $newhash[] = $hash[k].'t';
                    $newhash[] = $hash[k].'x';
                    $newhash[] = $hash[k].'y';
                    $newhash[] = $hash[k].'z';
                break;         
            }
            $hash = $newhash;
        }
        return $hash;    
    }
}

$solv = new Solution();
print_r($solv->letterCombinations("23"));

