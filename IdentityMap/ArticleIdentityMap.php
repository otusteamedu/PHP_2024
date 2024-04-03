<?php

declare(strict_types=1);

namespace AKagirova\Hw17;

class ArticleIdentityMap
{
    private static $_instance;
    private $articles = array();

    public static function getInstance()
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new ArticleIdentityMap();
        }
        return self::$_instance;
    }

    public static function getArticle($key)
    {
        $inst = self::getInstance();
        if(isset($inst->articles[$key])){
            return $inst->articles[$key];
        }
        return false;
    }

    public static function getId(Article $article)
    {
        $inst = self::getInstance();
        $id = array_search($article, $inst->articles);
        return $id;
    }

    public static function addArticle($article, $id)
    {
        $inst = self::getInstance();
        $inst->article[$id] = $article;
    }
}
