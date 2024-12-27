<?php

namespace Naimushina\DataMapper\Commands;

use Naimushina\DataMapper\Entities\Medic;
use Naimushina\DataMapper\Entities\Patient;
use Naimushina\DataMapper\Mappers\MedicalStudyMapper;
use Naimushina\DataMapper\Mappers\MedicMapper;
use Naimushina\DataMapper\Mappers\PatientMapper;
use Naimushina\DataMapper\Entities\MedicalStudy;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddStudyCommand extends Command
{
    /**
     * @param MedicalStudyMapper $mapper
     */
    public function __construct(private readonly MedicalStudyMapper $mapper)
    {
        parent::__construct('add_study');
    }
    protected function configure(): void
    {
        $this->addArgument(
            'study',
            InputArgument::REQUIRED,
            'Study object in json format'
        )
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $study = json_decode($input->getArgument('study'));
            $result = $this->mapper->insert(new MedicalStudy(
                $study->patient_id,
                $study->medic_id,
                $study->diagnoses,
                $study->study_memo,
                $study->study_date
            ));
            $output->writeln('Прием добавлен, id: ' . $result->getId());
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln("Ошибка: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}