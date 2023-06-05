<?php

class Model_Insert extends Model{
    // ユーザ情報をデータベースに挿入
    public function user_data_insert($form) {
        $data = array(
            "name" => $form["user_name"],
            "password" => $form["password"]
        );

        DB::insert("user")->set($data)->execute();
    }

    // 万能insert
    public function insert($table, $data) {
        DB::insert($table)->set($data)->execute();
    }
}