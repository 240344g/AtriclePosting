<?php

class Model_Update extends Model{
    // データベースのアップデート
    public function update($table, $data_array, $where) {
        $query = DB::update($table)->set($data_array)->where_open();

        $i = 0;
        foreach ($where as $key => $value) {
            $i++;
            if ($i === 1) {
                $query = $query->where($key, $value);
            } else {
                $query = $query->and_where($key, $value);
            }
        }
        $query = $query->where_close()->execute();
    }
}