<?php

namespace MyPage;

use Fuel\Core\Model;
use Fuel\Core\DB;

class DeleteArticle extends Model{
    // 記事を削除
    public static function delete($article_id) {
        // 記事に押されたハートを削除
        DB::delete("heart")->where("article_id", $article_id)->execute();

        // 記事を削除
        DB::delete("article")->where("id", $article_id)->execute();
    }
}