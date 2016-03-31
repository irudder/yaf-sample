<?php
class CommonModel extends Sql
{
    protected function selectsql($sql)
    {
        /* $con = new sql();
        $con::con('127.0.0.1', 'root', 'root');
        $con::select_db("yuser"); */
        $con=Sql::get_class_sql();
        $query = $con::query($sql);
        $res = $con::fetch_array($query);
        return $res;
    }
    protected function dosql($sql)
    {
        /* $con = new sql();
        $con::con('127.0.0.1', 'root', 'root');
        $con::select_db("yuser"); */
        $con=Sql::get_class_sql();
        $query = $con::query($sql);
        return $query;
    }
    protected function selectall($sql)
    {
        $con=Sql::get_class_sql();
        $query = $con::query($sql);
        $temp=array();
        while($res=mysql_fetch_assoc($query)) {
            $temp[]=$res;
        }
        return $temp;
    }
}
