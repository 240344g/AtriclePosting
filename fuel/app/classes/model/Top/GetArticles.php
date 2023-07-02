<?php

namespace Top;

use Fuel\Core\Model;
use Fuel\Core\DB;

class GetArticles extends Model{
    // 記事情報を取得
    public static function get() {
        $result = DB::select("article.*", ["user.name", "user_name"], [DB::expr("COUNT(heart.id)"), "hearts"])->from("article")
            ->join("user")->on("article.user_id", "=", "user.id")
            ->join("heart")->on("article.id", "=", "heart.article_id")
            ->group_by("article.id")->execute()->as_array();
        
        return $result;
    }
}