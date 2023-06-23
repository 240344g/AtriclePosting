<?php

namespace Article;

use Fuel\Core\Model;
use Fuel\Core\DB;

class AddHeart extends Model{
    // ハートを追加
    public static function add($heart_info) {
        DB::insert("heart")->set($heart_info)->execute();
    }
}