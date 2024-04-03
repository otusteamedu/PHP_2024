<?php


class ArticleIdentityMap
{
    private static $_instance;
    private $articles = array();

    static function getInstance(){
        if(!isset(self::$_instance)){
            self::$_instance = new ArticleIdentityMap();
        }
        return self::$_instance;
    }

    static function getArticle($key){
        $inst = self::getInstance();
        if(isset($inst->articles[$key])){
            return $inst->articles[$key];
        }
        return false;
    }

    static function getId(Article $article){
        $inst = self::getInstance();
        $id = array_search($article, $inst->articles);
        return $id;
    }

    static function addArticle($article, $id){
        $inst = self::getInstance();
        $inst->article[$id] = $article;
    }
}
