class Solution {
    /**
     * @param String $digits
     * @return String[]
     */
    function letterCombinations($digits) {
        if ($digits === "") {
            return []; // Условие: если строка пуста, то возвращаем пустой массив
        }

        $phoneMap = [
            '2' => 'abc', 
            '3' => 'def', 
            '4' => 'ghi', 
            '5' => 'jkl', 
            '6' => 'mno', 
            '7' => 'pqrs', 
            '8' => 'tuv', 
            '9' => 'wxyz'
        ];

        $result = [];
        $this->backtrack($phoneMap, $digits, 0, "", $result);
        return $result;
    }

    private function backtrack($phoneMap, $digits, $index, $current, &$result) {
        if ($index === strlen($digits)) {
            $result[] = $current; // Добавляем текущую комбинацию в результат
            return;
        }

        $digit = $digits[$index];
        $letters = $phoneMap[$digit];

        for ($i = 0; $i < strlen($letters); $i++) {
            $this->backtrack($phoneMap, $digits, $index + 1, $current . $letters[$i], $result);
        }
    }
}
