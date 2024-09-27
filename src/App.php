<?php

declare(strict_types=1);

namespace hw10;

class App
{
    public function unit(array $data1, array $data2)
    {
        $fistList = (new Define())->init($data1);
        $secondList = (new Define())->init($data2);

        return (new Solution())->mergeTwoLists($fistList, $secondList);
    }
}
