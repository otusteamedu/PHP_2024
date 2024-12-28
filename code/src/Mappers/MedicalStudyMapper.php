<?php

namespace Naimushina\DataMapper\Mappers;

use Naimushina\DataMapper\Entities\Medic;
use Naimushina\DataMapper\Entities\Patient;
use Naimushina\DataMapper\Entities\MedicalStudy;

class MedicalStudyMapper extends BasicMapper
{
    /**
     * @var Patient|bool
     */
    private Patient|bool|null $patient = false;
    /**
     * @var Medic|bool
     */
    private Medic|bool|null $medic = false;

    /**
     * @return string
     */
    public function getTableName(): string
    {
        return 'medical_studies';
    }

    /**
     * @return string[]
     */
    public function getColumns(): array
    {
        return [
            'patient_id',
            'medic_id',
            'diagnoses',
            'study_memo',
            'study_date',
        ];
    }

    /**
     * @param array $result
     * @return MedicalStudy
     */
    public function setDTO(array $result): MedicalStudy
    {
        return new MedicalStudy(
            $result['patient_id'],
            $result['medic_id'],
            $result['diagnoses'],
            $result['study_memo'],
            $result['study_date'],
            $result['id'],
        );
    }
}
