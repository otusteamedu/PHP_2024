<?php

namespace Naimushina\DataMapper\Commands;

use Naimushina\DataMapper\Entities\MedicalStudy;
use Naimushina\DataMapper\Mappers\MedicalStudyMapper;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetStudiesCommand extends Command
{
    /**
     * @param MedicalStudyMapper $mapper
     */
    public function __construct(private MedicalStudyMapper $mapper)
    {
        parent::__construct('get_studies');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function execute(InputInterface $input, OutputInterface $output): int
    {
        try {
            $studies = $this->mapper->getAll();
            $studyLines = [];
            foreach ($studies as $study) {
                /**
                 * @type $study MedicalStudy
                 */
                $patient = $this->mapper->getPatient($study->getPatientId());
                $medic = $this->mapper->getMedic($study->getMedicId());
                $studyLines[] = [
                    $study->getStudyDate(),
                    $medic->getCabinetNumber(),
                    $patient->getFullName() . ' ' . $patient->getPhone(),
                    $medic->getFullName() . ' ' . $medic->getPositionName(),
                    $study->getDiagnoses(),
                ];
            }

            $table = new Table($output);
            $table->setHeaders(['study_date', 'Cabinet', 'Patient', 'Medic', 'diagnoses'])
                ->setRows($studyLines);
            $table->render();
            return self::SUCCESS;
        } catch (\Exception $e) {
            $output->writeln("Ошибка " . $e->getMessage());
            return self::FAILURE;
        }
    }
}
