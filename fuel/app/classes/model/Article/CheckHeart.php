<?php

namespace Article;

use Fuel\Core\Model;
use Fuel\Core\DB;

class CheckHeart extends Model{
    // ハートが既に押されたか確認
    public static function check($user_id, $article_id) {
        $result = DB::select()->from("heart")->where_open()
            ->where("user_id", $user_id)
            ->and_where("article_id", $article_id)
        ->where_close()->execute();

        if (count($result) > 0) {
            return true;
        } else {
            return false;
        }
    }
}