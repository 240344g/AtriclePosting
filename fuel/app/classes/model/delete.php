<?php

class Model_Delete extends Model{
    // データ削除(and_where)
    public function delete($table, $where) {
        $query = DB::delete($table)->where_open();

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