<?php

namespace Top;

use Fuel\Core\Model;
use Fuel\Core\DB;

class GetArticles extends Model{
    // 記事情報を取得
    public static function get() {
        $result = DB::select()->from("article")->execute()->as_array();

        // 執筆者とハートの数を取得
        for ($i = 0; $i < count($result); $i++) {
            $user_info = DB::select("name")->from("user")->where("id", $result[$i]["user_id"])->execute()->as_array();
            $hearts = DB::select()->from("heart")->where("article_id", $result[$i]["id"])->execute()->as_array();

            $result[$i]["user_name"] = $user_info[0]["name"];
            $result[$i]["hearts"] = count($hearts);
        }
        
        return $result;
    }
}