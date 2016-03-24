<?php
class UserModel extends CommonModel
{    
    public function getuserinfo($id)
    {
        $sql = 'select uname from user where id='."$id";
        $res = $this->selectsql($sql);
        if($res!=false){
            return $res;
        }else{
            return false;
        }
    }
    public function checksameuser($uname)
    {
        $sql = 'select * from user where uname='."'$uname'";
        $res = $this->selectsql($sql);
        if($res!=false){
            return $res;
        }else{
            return false;
        }
    }
    //
    public function checkuserinfo($uname ,$password)
    {
        $sql = 'select * from user where uname='."'$uname'".' and pwd='."'$password'";
        $res = $this->selectsql($sql);
        if($res!=false){
            return $res;
        }else{
            return false;
        }
    }
    //更新密码
    public function updatauserinfo($id,$pwd)
    {
        $sql = 'update user set pwd='."'$pwd'".' where id='.$id;
        if($this->dosql($sql)){
            return true;
        }
        return false;
    }
    //插入数据
    public function insertuserinfo($m)
    {
        $sql = "insert into user (uname,pwd,relname,idcard,regtime,regip,lasttime,lastip) 
            values ('{$m["uname"]}', '{$m["pwd"]}', '{$m["realname"]}', '{$m["idcard"]}', '{$m["regtime"]}', '{$m["regip"]}', '{$m["lasttime"]}', '{$m["lastip"]}' )";
        if($this->dosql($sql)){
            return true;
        }
        return false;
    }
    //更新时间以及ip
    public function updatarecord($id,$data)
    {
        $sql = "update user set lasttime='{$data["lasttime"]}',lastip='{$data["lastip"]}' where id=".$id;
        if($this->dosql($sql))
        {
            return true;
        }
        return false;
    }
    
} 
    
    