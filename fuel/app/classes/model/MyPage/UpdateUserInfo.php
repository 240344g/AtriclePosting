<?php

namespace MyPage;

use Fuel\Core\Model;
use Fuel\Core\DB;

class UpdateUserInfo extends Model{
    // ユーザ名とパスワードのアップデート
    public static function update($form, $user_id) {
        $new_data = array(
            "name" => $form["user_name"],
            "password" => $form["password"]
        );

        DB::update("user")->set($new_data)->where("id", $user_id)->execute();
    }
}