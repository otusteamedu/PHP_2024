<?php

declare(strict_types=1);

namespace AKagirova\Hw17;

class ArticleIdentityMap
{
    private static $_instance;
    private $articles = array();

    static public function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new ArticleIdentityMap();
        }
        return self::$_instance;
    }

    static public function getArticle($key){
        $inst = self::getInstance();
        if(isset($inst->articles[$key])){
            return $inst->articles[$key];
        }
        return false;
    }

    static public function getId(Article $article){
        $inst = self::getInstance();
        $id = array_search($article, $inst->articles);
        return $id;
    }

    static public function addArticle($article, $id){
        $inst = self::getInstance();
        $inst->article[$id] = $article;
    }
}
