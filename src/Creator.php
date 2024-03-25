<?php

declare(strict_types=1);

namespace hw14;

use hw14\elastic\CreateIndex;
use hw14\elastic\ExistsIndex;
use hw14\elastic\Test;

class Creator
{
    /**
     * @param string $method
     * @return string
     */
    public function create(string $method = MethodDictionary::TEST)
    {
        switch ($method) {
            case MethodDictionary::BULK:
                return '';
            case MethodDictionary::EXISTS_INDEX:
                return (new ExistsIndex())->exec();
            case MethodDictionary::CREATE_INDEX:
                return (new CreateIndex())->exec();
            case MethodDictionary::TEST:
            default:
                return (new Test())->exec();
        }
    }

}
