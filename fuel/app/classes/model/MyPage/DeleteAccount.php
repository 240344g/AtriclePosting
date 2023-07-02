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
}