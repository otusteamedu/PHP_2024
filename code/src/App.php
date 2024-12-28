<?php

declare(strict_types=1);

namespace Naimushina\DataMapper;

use Exception;
use Naimushina\DataMapper\Commands\AddDoctorCommand;
use Naimushina\DataMapper\Commands\AddPatientCommand;
use Naimushina\DataMapper\Commands\AddStudyCommand;
use Naimushina\DataMapper\Commands\GetStudiesCommand;
use Naimushina\DataMapper\Mappers\MedicalStudyMapper;
use Naimushina\DataMapper\Mappers\MedicMapper;
use Naimushina\DataMapper\Mappers\PatientMapper;
use PDO;
use Symfony\Component\Console\Application;

class App
{
    /**
     * Запуск приложения
     * @throws Exception
     */
    public function run(): int
    {
        $consoleApp = new Application();
        $configs = new ConfigService();
        $databaseConfig = $configs->getConfigByName('database');

        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            $databaseConfig['host'],
            $databaseConfig['db'],
            'UTF8'
        );

        $pdo = new PDO($dsn, $databaseConfig['user'], $databaseConfig['password']);
        $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $commandName = $_SERVER['argv'][1] ?? null;
        match ($commandName) {
            'get_studies' => $consoleApp->add(
                new GetStudiesCommand(
                    new MedicalStudyMapper($pdo, new IdentityMap()),
                    new PatientMapper($pdo, new IdentityMap()),
                    new MedicMapper($pdo, new IdentityMap())
                )
            ),
            'add_doctor' => $consoleApp->add(
                new AddDoctorCommand(new MedicMapper($pdo, new IdentityMap()))
            ),
            'add_patient' => $consoleApp->add(
                new AddPatientCommand(new PatientMapper($pdo, new IdentityMap()))
            ),
            'add_study' => $consoleApp->add(
                new AddStudyCommand(new MedicalStudyMapper($pdo, new IdentityMap()))
            ),
            default => throw new Exception('Unknown command "' . $commandName . '"')
        };
        return $consoleApp->run();
    }
}
