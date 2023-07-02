<?php

namespace Article;

use Fuel\Core\Model;
use Fuel\Core\DB;

class GetArticleContents extends Model{
    // 記事情報を取得
    public static function get($article_id) {
        $result = DB::select("article.*", ["user.name", "user_name"])->from("article")->join("user")->on("article.user_id", "=", "user.id")->where("article.id", $article_id)->execute()->as_array();

        return $result;
    }
}