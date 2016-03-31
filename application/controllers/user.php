<?php
class UserController extends BasicController
{
    public function init()
    {
        parent::init();
        $logic = new logic\userLogicController;
        //    $this->test();
        $this->flag();
        $uid = getSession("uid");
        if($uid)
        {
            $this->getView()->assign('title','首页');
            $this->getView()->assign('user',getSession('uname'));
        }else{
            echo "请先登录";
            gotourl($t=2,$url='login');
            exit;
        }
    }
    public function indexAction() 
    {
        $uname = getSession("uname");
        $user = new userModel();
        $udata = $user->checksameuser($uname);
        //    获取上次登录的时间以及ip
        $udata['lasttime'] = getmem($udata['id'].'lasttime');
        $udata['lastip'] = getmem($udata['id'].'lastip');
        $this->getView()->assign("userdata", $udata); 
    }
    
    public function logoutAction()
    {        
        $uid = getSession("uid");
        $token_key = md5($uid.'token');
        clearCookie($token_key);
        clearCookie('uid');
        unsetSession('uname');
        unsetSession("uid");
        echo "已退出";
        gotourl($t=1,$url='index.php');
        return false;
    }
    //  修改密码
    public function updatapwdAction()
    {
        $this->getView()->assign('title','修改密码');
        if($_POST['pwd']){
            $uppwd = new logic\userLogicController;
            $res = $uppwd->updatapwd(filterStr($_POST['pwd']),getSession("uid"));
            $res = '['.$res.']';
            $res = json_decode($res);
            echo $res[0]->msg;
            gotourl($t=1,$url='user/updatapwd');
            exit;
        }
    }
    
    //  模拟订单支付
    public function orderpayAction()
    {
        $this->getView()->assign('title','订单支付');
        $adminMdl = new \AdminModel();
        //  $data['bank'] = $adminMdl->getdata('bank');
        $data['ordertype'] = $adminMdl->getdata('ordertype');
        //  获取已拥有支付通道的银行
        $where['is_show'] = 1;
        $data['bank'] = $adminMdl->getBankData('paycontact',$where);
        $this->getView()->assign('data',$data);
    }
    
    public function orderresAction()
    {   
        //  查表检查是否有该种订单充值可能性
        $adminMdl = new \AdminModel(); 
        $data['otype']=filterStr($_POST['ordertype']);
        $data['opaybank']=filterStr($_POST['bank']);
        
        //  入库。插入订单数据表
        $data['omoney']=(float)filterStr($_POST['money']);
        $data['onum']=filterStr($_POST['ordernum']);
        $data['otime']=time();
        $data['ouser']=getSession('uname');
        //  手续费计算() -商家通道
        //  a)用户本身手续费？订单类型指定银行=>判断订单金额=》限额支付商 =》手续费=》
        //  判断当前的银行可以走哪些支付商通道
        //  手续费计算公式：1、用户手续费*0.01*（限额？不限额）订单钱 2、支付商手续费*0.01*（限额？不限额）
        $where2['bmark'] = $data['opaybank'];
        $where2['is_show'] = 1;
        $paydata = $adminMdl->getdata('`paycontact`',$where2);
        
        //  $paydata = array_column($paydata,'pname','pmark');
        //  hc($paydata);
        if(!$paydata){
            echo "数据异常，请重试";
            gotourl(1.5,'/user/orderpay');
            exit;
        }
        
        $arr = array();
        $uwhere['id'] = getSession('uid');
        $userdata = $adminMdl->getonedata('user',$uwhere);
        if($userdata['poundage']>0 && $userdata['poundage']<100){
            foreach($paydata as $key=>$val){
                if($val['quota']<1 || $data['omoney']<$val['quota']){
                    //  不限额或不超额
                    $arr[$val['pmark']] = (float)($userdata['poundage']*0.01*$data['omoney']);
                }else{
                    //  超额部分不收钱？
                    $arr[$val['pmark']] = (float)($userdata['poundage']*0.01*$val['quota']);
                }
            }
        }else{
            foreach($paydata as $key=>$val){
                if($val['quota']<1 || $data['omoney']<$val['quota']){
                    //  不限额或不超额
                    $arr[$val['pmark']] = (float)($val['poundage']*0.01*$data['omoney']);
                }else{
                    //  超额部分不收钱？
                    $arr[$val['pmark']] = (float)($val['poundage']*0.01*$val['quota']);
                }
            }
        }
        //  hc($userdata['poundage']*0.01);
        
        //  hc($arr);
        $minpoundage = min($arr);
        $bankmark = array_search($minpoundage,$arr);
        $data['opayprovider']=$bankmark;
        $data['opoundage']=$minpoundage;
        
        //  禁止重复提交
        $where['onum']=$data['onum'];
        if($adminMdl->getonedata('`order`',$where)){
            echo "该订单已存在";
            gotourl(1.5,'/user/orderpay');
            exit;
        }else if($data['omoney']=='' || $data['onum']=='' || $data['opaybank']==''){
            echo "订单数据不正确，请返回";
            exit;
        }
        
        //  order是sql关键字 注意··
        if($adminMdl->insertbankinfo($data,'`order`')){
            $oderdata['msg'] = "订单已生成,订单数据为：";
            $oderdata['订单编号'] = $data['onum'];
            $oderdata['订单类型'] = $data['otype'];
            $oderdata['支付银行'] = $data['opaybank'];
            $oderdata['支付金额'] = $data['omoney'];
            $oderdata['订单时间'] = $data['otime'];
            $oderdata['订单用户'] = $data['ouser'];
            $oderdata['支付商'] = $data['opayprovider'];
            $oderdata['支付商收取手续费'] = $data['opoundage'];
        }else{
            $data['msg'] = "系统异常，订单未生成";
        }
        $this->getView()->assign('data',$oderdata);
    }
    
    public function getbankAction()
    {
        if($_POST){
            $typeval = filterStr($_POST['typeval']);
            $ordermoney = filterStr($_POST['ordermoney']);
            $adminMdl = new \AdminModel();
            $where['ordertype'] = $typeval;
            $where['is_show'] = 1;
            $res = $adminMdl->getdata('paycontact',$where);
            if($res!=''){
                $arr['code'] = 6;
                $arr['msg'] = array_unique(array_column($res,'bname','bmark'));
                echo json_encode($arr);
            }else{
                $res = $adminMdl->getdata('bank');
                $arr['msg']=array_unique(array_column($res,'bname','bmark'));
                $arr['code'] = -6;
                echo json_encode($arr);
            }
        }
        exit;
    }
}