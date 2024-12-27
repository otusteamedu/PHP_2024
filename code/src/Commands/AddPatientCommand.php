<?php

namespace Naimushina\DataMapper\Commands;

use Naimushina\DataMapper\Entities\Medic;
use Naimushina\DataMapper\Entities\Patient;
use Naimushina\DataMapper\Mappers\MedicalStudyMapper;
use Naimushina\DataMapper\Mappers\MedicMapper;
use Naimushina\DataMapper\Mappers\PatientMapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddPatientCommand extends Command
{
    /**
     * @param PatientMapper $mapper
     */
    public function __construct(private readonly PatientMapper $mapper)
    {
        parent::__construct('add_patient');
    }
    protected function configure(): void
    {
        $this->addArgument(
            'patient',
            InputArgument::REQUIRED,
            'Patient object in json format'
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
            $patient = json_decode($input->getArgument('patient'));
            $result = $this->mapper->insert(new Patient(
                $patient->fullName,
                $patient->bithday,
                $patient->phone
            ));
            $output->writeln('Пациент добавлен, id: ' . $result->getId());
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln("Ошибка: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
