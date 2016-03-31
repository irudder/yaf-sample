<?php
class AdminModel extends CommonModel
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
    //插入数据
    public function insertbankinfo($m,$tablename)
    {
        if($m=='' || $tablename==''){
            echo '数据库访问参数出错1';
            exit;
        }
        $key_data = array_keys($m);
        $val_data = array_values($m);
        $arr = implode($key_data,',');
        $brr = implode($val_data,'\',\'');
        //hc($arr);
        $sql = "insert into ".$tablename." ({$arr}) 
            values ('{$brr}')";
            //echo $sql;
        if($this->dosql($sql)){
            return true;
        }
        return false;
    }
    /*
     * 输入为参数 1、数组 key=>val
     *            2、表名
     */
    public function checkexist($where,$tablename)
    {
        if(empty($where) || $tablename==''){
            echo '数据库访问参数出错2';
            exit;
        }
        $k = key($where);
        $v = current($where);
        $sql = 'select * from '.$tablename.' where '.$k.' = '."'{$v}'";
        $res = $this->selectsql($sql);
        if($res!=false){
            return $res;
        }else{
            return false;
        }
    }
    //获取特定的字段
    public function getBankData($tablename,$where='')
    {
        if($tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
        $str = '';
        if($where!=''){
            foreach($where as $key=>$val){
                $str .= ' and '.$key.'='."'{$val}'"; 
            }
        }        
        $sql = 'select distinct bname,bmark from '.$tablename.' where 1=1'.$str;
        $res = $this->selectall($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    
    public function getdata($tablename,$where='')
    {
        if($tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
        $str = '';
        if($where!=''){
            foreach($where as $key=>$val){
                $str .= ' and '.$key.'='."'{$val}'"; 
            }
        }        
        $sql = 'select * from '.$tablename.' where 1=1'.$str;
        //echo $sql;
        $res = $this->selectall($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    
    public function getDataCount($tablename,$where='')
    {
        if($tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
        $str = '';
        if($where!=''){
            foreach($where as $key=>$val){
                $str .= ' and '.$key.'='."'{$val}'"; 
            }
        }        
        $sql = 'select count(1) as cc,sum(omoney) as money,sum(opoundage) as poundage from '.$tablename.' where 1=1'.$str;
        
        $res = $this->selectall($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    public function getDataTime($tablename,$str='')
    {
        if($tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
          
        $sql = 'select count(1) as cc,sum(omoney) as money,sum(opoundage) as poundage from '.$tablename.' where 1=1'.$str;
        $res = $this->selectall($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    public function getDataSum($tablename,$where='')
    {
        if($tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
        $str = '';
        if($where!=''){
            foreach($where as $key=>$val){
                $str .= ' and '.$key.'='."'{$val}'"; 
            }
        }        
        $sql = 'select sum(1) as ss from '.$tablename.' where 1=1'.$str;
        
        $res = $this->selectall($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    
    public function getPageData($tablename, $where='', $start=0, $num=0)
    {
        if($tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
        $str = '';
        if($where!=''){
            foreach($where as $key=>$val){
                $str .= ' and '.$key.'='."'{$val}'"; 
            }
        }
        if(!($start==0 && $num==0)){
            $str .= ' limit '.$start.','.$num;
        }
        $sql = 'select * from '.$tablename.' where 1=1'.$str;
        //echo $sql;
        $res = $this->selectall($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    
    public function getonedata($tablename,$where)
    {
        if(empty($where) || $tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
        $k = key($where);
        $v = current($where);
        $sql = 'select * from '.$tablename.' where '.$k.' = '."'{$v}'";
        $res = $this->selectsql($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    
    
    public function getcontactdata($tablename,$where)
    {
        if(empty($where) || $tablename==''){
            echo '数据库访问参数出错';
            exit;
        }
        //hc($where);
        $str = '';
        foreach($where as $key=>$val){
            $str .= ' and '.$key.'='."'{$val}'"; 
        }
        $sql = 'select * from '.$tablename.' where 1=1'.$str;
        $res = $this->selectsql($sql);
        if($res!=false){
            //var_dump($res);
            return $res;
        }else{
            return false;
        }
    }
    
    public function updatainfo($tablename,$data,$where)
    {
        if(empty($data) || $tablename=='' || empty($where)){
            echo '数据库访问参数出错';
            exit;
        }
        $str = '';
        foreach($data as $key=>$val)
        {
            $str .= $key.'='."'$val'".',';
        }
        $str = substr($str,0,-1);
        $k = key($where);
        $v = current($where);
        $sql = 'update '.$tablename.' set '.$str.' where '.$k.' = '."'{$v}'";
        if($this->dosql($sql)){
            return true;
        }
        return false;
    }
        
} 
    
    