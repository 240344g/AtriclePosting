<?php

class Model_Check extends Model{
    public function check($form) {
        // userテーブルからユーザネームとパスワードのセットの個数を取得
        $data = DB::select()->from("user")->where_open()
            ->where("name", $form["user_name"])
            ->and_where("password", $form["password"])
        ->where_close()->execute();
        $data_num = count($data);

        return $data_num;
    }
}