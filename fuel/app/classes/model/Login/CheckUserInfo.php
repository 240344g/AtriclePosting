<?php

namespace Login;

use Fuel\Core\Model;
use Fuel\Core\DB;

// ユーザ名とパスワードのセットがあるかを確認
class CheckUserInfo extends Model{
    public static function check($form) {
        $result = DB::select()->from("user")->where_open()
            ->where("name", $form["user_name"])
            ->and_where("password", $form["password"])
        ->where_close()->execute();

        if (count($result) === 1) {
            $user_data = array(
                "id" => $result[0]["id"],
                "name" => $result[0]["name"]
            );
            return $user_data;
        } else {
            return null;
        }
    }
}