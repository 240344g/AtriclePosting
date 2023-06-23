<?php

namespace Article;

use Fuel\Core\Model;
use Fuel\Core\DB;

class GetArticleContents extends Model{
    // 記事情報を取得
    public static function get($article_id) {
        $result = DB::select()->from("article")->where("id", $article_id)->execute()->as_array();

        // 執筆者を取得
        $user_info = DB::select("name")->from("user")->where("id", $result[0]["user_id"])->execute()->as_array();
        $result[0]["user_name"] = $user_info[0]["name"];

        return $result;
    }
}