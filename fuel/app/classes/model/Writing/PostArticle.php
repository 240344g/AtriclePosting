<?php

namespace Writing;

use Fuel\Core\Model;
use Fuel\Core\DB;

class PostArticle extends Model{
    // 記事をデータベースに登録
    public static function insert($article_contents) {
        DB::insert("article")->set($article_contents)->execute();
    }
}