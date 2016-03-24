<?php
class CommonModel extends Sql
{
    protected function selectsql($sql)
    {
        /* $con = new sql();
        $con::con('127.0.0.1', 'root', 'root');
        $con::select_db("yuser"); */
        $con=Sql::get_class_sql();
        $res = $con::query($sql);
        $res = $con::fetch_array($res);
        return $res;
    }
    protected function dosql($sql)
    {
        /* $con = new sql();
        $con::con('127.0.0.1', 'root', 'root');
        $con::select_db("yuser"); */
        $con=Sql::get_class_sql();
        $res = $con::query($sql);
        return $res;
    }
}
