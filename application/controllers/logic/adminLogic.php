<?php
namespace Logic;

class adminLogicController
{
    public function savedata($data, $tablename)
    {
        //var_dump($this->$admin);
        //保存数据
        $admin = new \AdminModel();
        if($admin->insertbankinfo($data, $tablename)){
            return true;
        }else{
            return false;
        }
    }
    
    //检查是否已存在
    public function checkexist($bmark, $tablename)
    {
        $admin = new \AdminModel();
        if($admin->checkexist($bmark,$tablename)){
            return true;
        }else{
            return false;
        }
    }
    
    //  分页 (表名，开始条，展示条，当前页)
    public function dopage($tablename, $nowpage=1, $num=10)
    {
        $admin = new \AdminModel();
        $countdata = $admin->getDataCount($tablename);
        $maxpage = ceil($countdata[0]['cc']/$num);
        if($nowpage>$maxpage){
            $nowpage = $maxpage;
        }elseif(!($nowpage>=1 && $nowpage<=$maxpage)){
            $nowpage = 1;
        }
        $start = ($nowpage-1)*$num;
        $pagedata = $admin->getPageData($tablename, '', $start, $num);
        $data['maxpage'] = $maxpage;
        $data['nowpage'] = $nowpage;
        $data['pagedata'] = $pagedata;
        return $data;
    }
    
    /* //查找数据
    public function getdata($tablename)
    {
        $admin = new \AdminModel();
        if($res = $admin->getdata($tablename)){
            return $res;
        }else{
            return false;
        }
    } */
}