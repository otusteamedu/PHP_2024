<?php

namespace Naimushina\DataMapper\Entities;

class MedicalStudy
{
    public function __construct(
        private int $patient_id,
        private int $medic_id,
        private string $diagnoses,
        private string $study_memo,
        private string $study_date,
        private ?int $id = null
    )
    {
    }

    /**
     * @return int
     */
    public function getPatientId(): int
    {
        return $this->patient_id;
    }

    /**
     * @param int $patient_id
     */
    public function setPatientId(int $patient_id): void
    {
        $this->patient_id = $patient_id;
    }

    /**
     * @return int
     */
    public function getMedicId(): int
    {
        return $this->medic_id;
    }

    /**
     * @param int $medic_id
     */
    public function setMedicId(int $medic_id): void
    {
        $this->medic_id = $medic_id;
    }

    /**
     * @return string
     */
    public function getDiagnoses(): string
    {
        return $this->diagnoses;
    }

    /**
     * @param string $diagnoses
     */
    public function setDiagnoses(string $diagnoses): void
    {
        $this->diagnoses = $diagnoses;
    }

    /**
     * @return string
     */
    public function getStudyMemo(): string
    {
        return $this->study_memo;
    }

    /**
     * @param string $study_memo
     */
    public function setStudyMemo(string $study_memo): void
    {
        $this->study_memo = $study_memo;
    }

    /**
     * @return string
     */
    public function getStudyDate(): string
    {
        return $this->study_date;
    }

    /**
     * @param string $study_date
     */
    public function setStudyDate(string $study_date): void
    {
        $this->study_date = $study_date;
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int|null $id
     */
    public function setId(?int $id): void
    {
        $this->id = $id;
    }

}