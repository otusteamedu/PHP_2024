<?php

namespace Naimushina\DataMapper\Commands;

use Naimushina\DataMapper\Entities\Medic;
use Naimushina\DataMapper\Mappers\MedicalStudyMapper;
use Naimushina\DataMapper\Mappers\MedicMapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class AddDoctorCommand extends Command
{
    /**
     * @param MedicMapper $mapper
     */
    public function __construct(private readonly MedicMapper $mapper)
    {
        parent::__construct('add_doctor');
    }
    protected function configure(): void
    {
        $this->addArgument(
            'doctor',
            InputArgument::REQUIRED,
            'Medic object in json format'
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
            $doctor = json_decode($input->getArgument('doctor'));
            $result = $this->mapper->insert(new Medic(
                $doctor->fullName,
                $doctor->position,
                $doctor->cabinet
            ));
            $output->writeln('Доктор добавлен, id: ' . $result->getId());
            return self::SUCCESS;
        } catch (\Throwable $e) {
            $output->writeln("Ошибка: " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
