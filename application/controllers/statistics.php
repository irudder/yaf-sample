<?php
class StatisticsController extends BasicController
{
    public function indexAction() 
    {
        //显示支付商家
        $admin = new \AdminModel();
        $data = $admin->getdata('`payprovider`');
        foreach($data as $key=>$val){
            $where['opayprovider'] = $val['pmark'];
            $paydata['pname'][$key] = $val['pname'];
            $orderdata =$admin->getDataCount('`order`',$where);
            $paydata['count'][$key] = $orderdata[0]['cc'];//订单数
            $paydata['money'][$key] = $orderdata[0]['money'];//金额数
            $paydata['poundage'][$key] = $orderdata[0]['poundage'];//金额数
            //$paydata['user'][$key] = $orderdata[0]['user'];//用户使用数
        }
        
        $data['pname'] = '"'.implode('","',$paydata['pname']).'"';
        $data['count'] = implode(',',$paydata['count']);
        $data['money'] = implode(',',$paydata['money']);
        $data['poundage'] = implode(',',$paydata['poundage']);
        //$data['user'] = implode(',',$paydata['user']);
        //hc($paydata);
        $this->getView()->assign('data',$data);
        
        //TODO 分页
        
    }
    public function paybankAction() 
    {
        //显示支付银行
        $admin = new \AdminModel();
        $data = $admin->getdata('`bank`');
        foreach($data as $key=>$val){
            $where['opaybank'] = $val['bmark'];
            $paydata['bname'][$key] = $val['bname'];
            $orderdata =$admin->getDataCount('`order`',$where);
            $paydata['count'][$key] = $orderdata[0]['cc'];//订单数
            $paydata['money'][$key] = $orderdata[0]['money'];//金额数
            $paydata['poundage'][$key] = $orderdata[0]['poundage'];//金额数
            //$paydata['user'][$key] = $orderdata[0]['user'];//用户使用数
        }
        
        $data['bname'] = '"'.implode('","',$paydata['bname']).'"';
        $data['count'] = implode(',',$paydata['count']);
        $data['money'] = implode(',',$paydata['money']);
        $data['poundage'] = implode(',',$paydata['poundage']);
        //$data['user'] = implode(',',$paydata['user']);
        //hc($paydata);
        $this->getView()->assign('data',$data);
        
        //TODO 分页
        
    }
    public function ordertimeAction() 
    {
        //凌晨时间
        $admin = new \AdminModel();
        $aday = 24*60*60;
        $today0 = strtotime(date('Y-m-d'));
        $today1 = $today0+$aday;
        $month0 = strtotime(date('Y-m'));
        $days = ceil(($today1 - $month0)/($aday));//从一号到今天共多少天
        //echo $a;//date('y-m-d H:i:s',$month0);
        for($i=0;$i<$days;$i++){
            $str = " and otime>".($month0+$i*$aday).' and otime<'.($month0+($i+1)*$aday);
            $orderdata[$i] = $admin->getDataTime('`order`',$str);
            $paydata['time'][$i] = '第'.($i+1).'天';//第几天
            $paydata['count'][$i] = $orderdata[$i][0]['cc'];//订单数
            $paydata['money'][$i] = $orderdata[$i][0]['money'];//金额数
            $paydata['poundage'][$i] = $orderdata[$i][0]['poundage'];//金额数
        }
        $data['time'] = '"'.implode('","',$paydata['time']).'"';
        $data['count'] = implode(',',$paydata['count']);
        $data['money'] = implode(',',$paydata['money']);
        $data['poundage'] = implode(',',$paydata['poundage']);
        $this->getView()->assign('data',$data);
        //TODO 分页
        
    }
}