<?php

namespace Article;

use Fuel\Core\Model;
use Fuel\Core\DB;

class DeleteHeart extends Model{
    // ハートを削除
    public static function delete($user_id, $article_id) {
        DB::delete("heart")->where_open()
            ->where("user_id", $user_id)
            ->where("article_id", $article_id)
        ->where_close()->execute();
    }
    // public function delete($table, $where) {
    //     $query = DB::delete($table)->where_open();

    //     $i = 0;
    //     foreach ($where as $key => $value) {
    //         $i++;
    //         if ($i === 1) {
    //             $query = $query->where($key, $value);
    //         } else {
    //             $query = $query->and_where($key, $value);
    //         }
    //     }
    //     $query = $query->where_close()->execute();
    // }
}