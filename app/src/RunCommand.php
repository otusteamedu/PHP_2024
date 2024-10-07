<?php

declare(strict_types=1);

namespace Evgenyart\Hw13;

class RunCommand
{
    private $filmMapper;

    public function __construct()
    {
        $pdo = new DBConnection();
        $this->filmMapper = new FilmMapper($pdo->connect());
    }

    public function selectAllData()
    {
        $result = $this->filmMapper->selectAll();
        print_r($result);
    }

    public function selectData($params)
    {
        $id = CommandHelper::checkParams($params, 'select');
        $result = $this->filmMapper->findById($id);
        print_r($result);
    }

    public function updataData($params)
    {
        $arParams = CommandHelper::checkParams($params, 'update');
        $film = $this->filmMapper->findById($arParams['id']);
        $key = $arParams['key'];
        $value = $arParams['value'];

        switch ($key) {
            case 'name':
                $film->setName($value);
                break;
            case 'original_name':
                $film->setOriginalName($value);
                break;
            case 'release_date':
                $film->setReleaseDate($value);
                break;
            case 'rating':
                $film->setRating($value);
                break;
            case 'duration':
                $film->setDuration($value);
                break;
            case 'description':
                $film->setDescription($value);
                break;
        }

        $result = $this->filmMapper->update($film);
        if ($result) {
            print_r("Запись успешно обновлена" . PHP_EOL);
            $resultAfter = $this->filmMapper->findById($arParams['id']);
            print_r($resultAfter);
        }
    }

    public function insertData($params)
    {
        $arParams = CommandHelper::checkParams($params, 'insert');
        $result = $this->filmMapper->insert($arParams);
        print_r($result);
    }

    public function deleteData($params)
    {
        $id = CommandHelper::checkParams($params, 'delete');
        $result = $this->filmMapper->delete($id);
        print_R($result);
    }
}
