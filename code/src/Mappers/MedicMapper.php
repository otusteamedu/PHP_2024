<?php

namespace Naimushina\DataMapper\Mappers;

use Naimushina\DataMapper\Entities\Medic;

class MedicMapper extends BasicMapper
{
    protected function getTableName(): string
    {
        return 'medics';
    }

    protected function getColumns(): array
    {
        return [
            'full_name',
            'position_name',
            'cabinet_number'
        ];
    }

    protected function setDTO(array $result): Medic
    {
        return new Medic(
            $result['full_name'],
            $result['position_name'],
            $result['cabinet_number'],
            $result['id'],
        );
    }
}
