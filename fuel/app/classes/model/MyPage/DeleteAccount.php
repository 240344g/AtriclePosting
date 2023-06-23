<?php

namespace MyPage;

use Fuel\Core\Model;
use Fuel\Core\DB;

class DeleteAccount extends Model{
    // アカウントを削除
    public static function delete($user_id) {
        // ユーザが記事に押したハートを削除
        DB::delete("heart")->where("user_id", $user_id)->execute();

        // アカウントを削除
        DB::delete("user")->where("id", $user_id)->execute();
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