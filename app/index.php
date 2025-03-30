<?php

try {

    $e = new MyOpenSearchClass();
    $e->info();
    $e->createIndex();
    $e->create();
    //give elastic a little time to create before update
    sleep(2);
    $e->update();
    $e->bulk();
    $e->getOneByID();
    $e->getMultipleDocsByIDs();
    $e->search();
    $e->searchUsingSQL();
    $e->searchByPointInTime();
    $e->deleteByQuery('');
    $e->deleteByID();
    $e->deleteByIndex();
} catch (\Throwable $th) {
    echo 'uncaught error ' . $th->getMessage() . "\n";
}