<?php

namespace MyPage;

use Fuel\Core\Model;
use Fuel\Core\DB;

class GetMyArticles extends Model{
    // 記事情報を取得
    public static function get($user_id, $user_name) {
        $result = DB::select()->from("article")->where("user_id", $user_id)->execute()->as_array();

        // 執筆者とハートの数を取得
        for ($i = 0; $i < count($result); $i++) {
            $hearts = DB::select()->from("heart")->where("article_id", $result[$i]["id"])->execute()->as_array();

            $result[$i]["user_name"] = $user_name;
            $result[$i]["hearts"] = count($hearts);
        }

        return $result;
    }
}