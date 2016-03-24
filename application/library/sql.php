<?php
class Sql 
{
    const DBHOST='127.0.0.1';
    const DBNAME='root';
    const DBPWD ='root';
    const DBPORT =3306;
    const DB    ='yuser';
    
    private $link;
    static private $_instance;
    // 连接数据库
    public function __construct()
    {
        $this->link = mysql_connect(Sql::DBHOST, Sql::DBNAME, Sql::DBPWD);
        $this->query("SET NAMES 'utf8'", $this->link);
        $this->select_db();
        
        /*PDO
         $this->link = new  PDO( "mysql:dbname=".Sql::DB.";host=".Sql::DBHOST,Sql::DBNAME, Sql::DBPWD);
         $this->link->exec('set names ust8');
        */
        
        return $this->link;
    }
    
    private function __clone(){}
    
    public static function get_class_sql()
    {        
        if( FALSE == (self::$_instance instanceof self) )
        {
            self::$_instance = new Sql();
        }
        return self::$_instance;
    }
    
    // 连接数据表
    public function select_db()
    {
        $this->result = mysql_select_db(Sql::DB);
        return $this->result;
    }
    
    // 执行SQL语句
    public function query($query)
    {
        return $this->result = mysql_query($query, $this->link);
    }
    
    // 将结果集保存为数组
    public function fetch_array($fetch_array)
    {
        return $this->result = mysql_fetch_array($fetch_array, MYSQL_ASSOC);
    }
    
    // 获得记录数目
    public function num_rows($query)
    {
        return $this->result = mysql_num_rows($query);
    }
    
    // 关闭数据库连接
    public function close()
    {
        return $this->result = mysql_close($this->link);
    }
    
    public function __destruct()
    {
        return $this->link=null;
    }
}