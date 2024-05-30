<?php


namespace App\services;


interface IDB
{
    /**
     *
     * @param string $sql
     * @return mixed
     */
    public function find(string $sql);

    /**
     * @param string $sql
     * @return mixed
     */
    public function findAll(string $sql);


}