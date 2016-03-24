<?php
class ConMemcache 
{
    const MENHOST='127.0.0.1';
    const MENPORT=11211;
    private static $mem;
    private static $obj;
    
    public function __construct()
    {
        self::$mem = new Memcache;
        self::$mem->connect(self::MENHOST,self::MENPORT);
        //return $this->$mem;
    }
    public function createmem()
    {
        if(!isset(self::$obj))
        {
            self::$obj = new ConMemcache();
        }
        return self::$obj;
    }
    public function getmem($key){
        return self->get($key);
    }
}
/* new ConMemcache; */