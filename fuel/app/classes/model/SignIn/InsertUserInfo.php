<?php

namespace SignIn;

use Fuel\Core\Model;
use Fuel\Core\DB;

class InsertUserInfo extends Model{
    // ユーザ情報をデータベースに挿入
    public static function insert($form) {
        $data = array(
            "name" => $form["user_name"],
            "password" => $form["password"]
        );

        DB::insert("user")->set($data)->execute();
    }
}