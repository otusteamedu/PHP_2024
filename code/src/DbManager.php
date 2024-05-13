<?php
declare(strict_types=1);

namespace App;


use App\ActiveRecord\Films;
use App\ServicePDO\ServicePDO;

class DbManager
{


    public function run(array $arguments): array
    {
        array_shift($arguments);

        $films = new Films(new ServicePDO());
        $result = [
            'data' => null,
            'message' => ''
        ];
        switch ($arguments[0]):
            case 'insert': {
                array_shift($arguments);
                $result['data'] = (count($arguments) == 2) ? $films->insert($arguments) : false;
                $result['message'] = ($result['data'])? "Film has been inserted successfully\n" : "Error\n";
                break;
            }

            case 'update': {
                array_shift($arguments);
                $result['data'] = (count($arguments) == 2)? $films->update($arguments[0],$arguments[1]) : false;
                $result['message'] = ($result['data'])? "Film has been updated successfully\n" : "Error\n";
                break;
            }

            case 'delete': {
                array_shift($arguments);
                $result['data'] = (count($arguments) == 1)? $films->delete($arguments[0]) : false;
                $result['message'] = ($result['data'])? "Film has been deleted successfully\n" : "Error\n";
                break;
            }

            case'selectOne': {
                array_shift($arguments);
                $result['data'] = (count($arguments) == 1)? $films->selectOne($arguments[0]) : false;
                $result['message'] = ($result['data'])? "" : "Film not found\n";
                break;
            }

            case'selectAll': {
                array_shift($arguments);
                $result['data'] = $films->selectAll();
                $result['message'] = ($result['data'])? "" : "Films not found\n";
                break;
            }

            default:
                return ["Unknown command\n"];
        endswitch;

        return $result;
    }

}