<?php

class Model_Select extends Model{
    // 記事情報を取得
    public function select($column = "*", $table = null, $where = null) {
        if (is_null($where)) {
            $result = DB::select($column)->from($table)->execute()->as_array();
        } else {
            $result = DB::select($column)->from($table)->where_open();

            $i = 0;
            foreach ($where as $key => $value) {
                $i++;
                if ($i === 1) {
                    $result = $result->where($key, $value);
                } else {
                    $result = $result->and_where($key, $value);
                }
            }
            $result = $result->where_close()->execute()->as_array();
        }
        
        return $result;
    }
}