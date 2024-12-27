<?php

namespace Naimushina\DataMapper\Mappers;

use Naimushina\DataMapper\Entities\Patient;

class PatientMapper extends BasicMapper
{
    public function getTableName(): string
    {
        return 'patients';
    }

    public function getColumns(): array
    {
        return ['full_name', 'birthday', 'phone'];
    }

    public function setDTO(array $result): Patient
    {
       return new Patient(
           $result['full_name'],
           $result['birthday'],
           $result['phone'],
           $result['id'],
       );
    }


}