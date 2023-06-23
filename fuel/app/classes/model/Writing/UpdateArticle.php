<?php

namespace Writing;

use Fuel\Core\Model;
use Fuel\Core\DB;

class UpdateArticle extends Model{
    // 記事の編集
    public static function update($new_article_contents, $article_id) {
        DB::update("article")->set($new_article_contents)->where("id", $article_id)->execute();
    }
}