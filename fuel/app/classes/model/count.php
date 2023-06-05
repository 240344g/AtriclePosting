<?php

class Model_Count extends Model{
    // 記事に対するハートの数を取得
    public function count_heart($article_id) {
        $result = DB::select()->from("heart")->where("article_id", $article_id)->execute();
        return count($result);
    }
}