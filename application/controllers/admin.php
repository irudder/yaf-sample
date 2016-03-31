<?php
class AdminController extends BasicController
{
    /**
     * 银行信息的增查改
     **/
    public function indexAction() 
    {
        //显示支付商家与银行信息
        //$admin = new logic\adminLogicController;
        $admin = new \AdminModel();
        $data = $admin->getdata('bank');
        $this->getView()->assign('data',$data);
        //TODO 分页
    }
    
    public function editbankAction()
    {
        $bid=$this->get('bid');
        if(!$bid){
            echo "非法访问，请返回重试~";
            exit;
        }
        $admin = new \AdminModel();        
        if($_POST){
            $data['bname'] = $this->getpost('bankname');
            $data['bmark'] = $this->getpost('bankmark');
            $data['binfo'] = $this->getpost('bankinfo');
            $bid = $this->getpost('bankid');
            $where['bid'] = $bid;
            if($admin->updatainfo('bank',$data,$where)){
                $arr['code'] = 5;
                $arr['msg'] = '信息修改成功！';
            }else{
                $arr['code'] = -5;
                $arr['msg'] = '信息修改失败！';
            }
            echo json_encode($arr);
            exit;
        }
        $where['bid'] = $bid;
        $data = $admin->getonedata('bank',$where);
        $this->getView()->assign('data',$data);
        //hc($data);
        //echo $this->get('id');
        //$admin = new logic\adminLogicController;
    }
    
    public function addbankAction()
    {
        $admin = new logic\adminLogicController;
        $data['bname'] = $this->getpost('bankname');
        $data['bmark'] = $this->getpost('bankmark');
        $data['binfo'] = $this->getpost('bankinfo');
        $where['bmark'] = $data['bmark'];
        if($data['bname'] && $data['bmark'] && $data['binfo']){
            //hc($this->getpost('bname'));
            if($admin->checkexist($where,'bank')){
                $arr['code'] = -5;
                $arr['msg'] = '该支付商信息已存在，请不要重复添加';
            }else{
                $admin->savedata($data,'bank');
                $arr['code'] = 5;
                $arr['msg'] = '信息添加成功';
            }
            echo json_encode($arr);
            exit;            
        }
        //$this->getView('editbank.pthml');
    }
    
    /**
     * 支付商信息的增查改
     **/
    public function payinfoAction() 
    {
        //显示支付商家信息
        //$admin = new logic\adminLogicController;
        $admin = new \AdminModel();
        $data = $admin->getdata('payprovider');
        $this->getView()->assign('data',$data);
        
        //TODO 分页
        
    }
    public function editpayAction()
    {
        if($this->get('pid')){
            $pid=$this->get('pid');
        }elseif($this->getpost('payid')){
            $pid=$this->getpost('payid');
        }        
        if(!$pid)
        {
            echo "非法访问，请返回重试~~";
            exit;
        }
        
        $admin = new \AdminModel();     
        $data['pname'] = $this->getpost('payname');
        $data['pmark'] = $this->getpost('paymark');
        $data['quota'] = $this->getpost('quota');
        $data['poundage'] = $this->getpost('poundage');
        $where['pid'] = $pid;
        if($data['pname'] && $data['pmark']  && $data['poundage']){
            if($this->getpost('quota')<0){
                $arr['code'] = -11;
                $arr['msg'] = '限额只能为大于零的数值！';
                exit;
            }elseif($this->getpost('poundage')<=0 || $this->getpost('poundage')>=100){
                $arr['code'] = -12;
                $arr['msg'] = '手续费值在0-100之内的数值';
                exit;
            }
            if($admin->updatainfo('payprovider',$data,$where)){
                //更新联系表中所有支付商手续费
                $cdata['poundage'] = $data['poundage'];
                $cwhere['pmark'] = $data['pmark'];
                $admin->updatainfo('paycontact',$cdata,$cwhere);
                //TODO 失败回滚 rollback
                
                $arr['code'] = 5;
                $arr['msg'] = '信息修改成功！';
            }else{
                $arr['code'] = -5;
                $arr['msg'] = '信息修改失败！';
            }
            echo json_encode($arr);
            exit;
        }
        $where['pid'] = $pid;
        $data = $admin->getonedata('payprovider',$where);
        $this->getView()->assign('data',$data);
    }
    
    public function editquotaAction()
    {
        $adminMdl = new \AdminModel();
        if($_POST){
            $data['quota'] = $this->getpost('quota');
            $where['pid'] = $this->getpost('pid');
            if($data['quota']<0 ){
                $arr['code']=-4;
                $arr['msg']='非法额度，请正确填写不小于〇的数值';
            }else{
                if($adminMdl->updatainfo('payprovider',$data,$where)){
                    $arr['code'] = 5;
                    $arr['msg'] = '额度修改成功';
                }else{
                    $arr['code'] = -500;
                    $arr['msg'] = '系统异常，请稍候再试';
                }
            }
        }
        echo json_encode($arr);
        exit; 
    }
    
    public function addpayAction()
    {
        $admin = new logic\adminLogicController;
        $data['pname'] = $this->getpost('payname');
        $data['pmark'] = $this->getpost('paymark');
        $data['quota'] = $this->getpost('quota');
        $data['poundage'] = $this->getpost('poundage');
        $where['pmark'] = $data['pmark'];
       // hc($data);
        if($data['pname']!='' && $data['pmark']!='' && $data['quota']!='' && $data['poundage']!=''){
            if($admin->checkexist($where,'payprovider')){
                $arr['code'] = -5;
                $arr['msg'] = '该支付商信息已存在，请不要重复添加';
            }else{
                if($admin->savedata($data,'payprovider')){
                    $arr['code'] = 5;
                    $arr['msg'] = '信息添加成功';
                }else{
                    $arr['code'] = -500;
                    $arr['msg'] = '系统异常，请稍候再试';
                }
            }
            echo json_encode($arr);
            exit; 
        }
        
        //$this->getView('editpay.pthml');
    }
    
    /**
     * 用户信息的查改
     **/
    public function userinfoAction()
    {
        $adminMdl = new \AdminModel();
        $data = $adminMdl->getdata('user');
        $this->getView()->assign('data',$data);
    }
    public function edituserinfoAction()
    {
        $adminMdl = new \AdminModel();
        if($_POST){
            $data['poundage'] = $this->getpost('poundage');
            $where['id'] = $this->getpost('uid');
            if($data['poundage']>=100 || $data['poundage']<0 ){
                $arr['code']=-4;
                $arr['msg']='非法额度，请正确填写0-100之内的数值';
            }else{
                if($adminMdl->updatainfo('user',$data,$where)){
                    $arr['code'] = 5;
                    $arr['msg'] = '额度修改成功';
                }else{
                    $arr['code'] = -500;
                    $arr['msg'] = '系统异常，请稍候再试';
                }
            }
        }
        echo json_encode($arr);
        exit; 
    }

    /**
     * 订单类型信息的增查改
     **/
    public function ordertypeAction() 
    {
        //显示订单类型
        //$admin = new logic\adminLogicController;
        $admin = new \AdminModel();
        $data = $admin->getdata('ordertype');
        $this->getView()->assign('data',$data);
        
        //TODO 分页
        
    }
    public function edittypeAction()
    {
        $typeid=$this->get('typeid');
        if(!$typeid){
            //TODO判断数据库是否存在该id或者判断是否通过修改url直接过来
            echo "非法访问，请返回重试~";
            exit;
        }
        $admin = new \AdminModel();        
        if($_POST){
            $data['type'] = $this->getpost('ordertype');
            $typeid = $this->getpost('typeid');
            $where['id'] = $typeid;
            if($admin->updatainfo('ordertype',$data,$where)){
                $arr['code'] = 5;
                $arr['msg'] = '信息修改成功！';
            }else{
                $arr['code'] = -5;
                $arr['msg'] = '信息修改失败！';
            }
            echo json_encode($arr);
            exit;
        }
        $where['id'] = $typeid;
        $data = $admin->getonedata('ordertype',$where);
        $this->getView()->assign('data',$data);
        //hc($data);
        //echo $this->get('id');
        //$admin = new logic\adminLogicController;
    }
    
    public function addtypeAction()
    {
        $admin = new logic\adminLogicController;
        $data['type'] = $this->getpost('ordertype');
        //hc($data);
        $where['type'] = $data['type'];
        if($data['type']){
            //hc($this->getpost('bname'));
            if($admin->checkexist($where,'ordertype')){
                $arr['code'] = -5;
                $arr['msg'] = '该订单类型信息已存在，请不要重复添加';
            }else{
                $admin->savedata($data,'ordertype');
                $arr['code'] = 5;
                $arr['msg'] = '订单类型信息添加成功';
            }
            echo json_encode($arr);
            exit;            
        }
        //$this->getView('editbank.pthml');
    }
    
    /**
     * 支付通道信息的增查改
     **/
    public function addcontactAction()
    {
        $adminCtl = new logic\adminLogicController;
        $adminMdl = new \AdminModel();
        if($_POST){
            $bmark = $this->getpost('bankmark');
            $pmark = $this->getpost('paymark');
            $ordertype = $this->getpost('ordertype');
            $where['bmark']=$bmark;
            $where['pmark']=$pmark;
            if(!($ordertype=='0' || $ordertype=='-1') ){
                $where['ordertype']=$ordertype;
            }
            if($bmark && $pmark){
                if($adminMdl->getcontactdata('paycontact',$where)){
                    $arr['code'] = -5;
                    $arr['msg'] = '该支付商信息已存在，请不要重复添加';
                }else{
                    //在两表查询有无该银行或者支付商信息 有则添加 无则表示是恶意post
                    $where1['pmark']=$pmark;
                    $payres = $adminMdl->getonedata('payprovider',$where1);
                    $where2['bmark']=$bmark;
                    $bankres = $adminMdl->getonedata('bank',$where2);
                    if(!$payres && !$bankres){
                        $arr['code'] = -8;
                        $arr['msg'] = '无此商家或银行信息记录，请先添加';
                        echo json_encode($arr);
                        exit;
                    }
                    $data['bmark'] = $bmark;
                    $data['pmark'] = $pmark;
                    if(!($ordertype=='0' || $ordertype=='-1') ){
                        $data['ordertype'] = $ordertype;
                    }
                    $data['poundage'] = $payres['poundage'];
                    $data['bname'] = $bankres['bname'];
                    $data['pname'] = $payres['pname'];
                    if($this->getpost('quota')){
                        $data['quota'] = $this->getpost('quota');
                    }else{
                        $data['quota'] = $payres['quota'];
                    }
                    
                    if($adminCtl->savedata($data,'paycontact')){
                        $arr['code'] = 5;
                        $arr['msg'] = '信息添加成功';
                    }else{
                        $arr['code'] = -500;
                        $arr['msg'] = '系统异常，请稍候再试';
                    }
                }
            }else{
                $arr['code'] = -9;
                $arr['msg'] = '请正确添加信息';
            }
            echo json_encode($arr);
            exit;
        }
        
        $data['bank'] = $adminMdl->getdata('bank');
        $data['pay'] = $adminMdl->getdata('payprovider');
        $data['ordertype'] = $adminMdl->getdata('ordertype');
        $data['contact'] = $adminMdl->getdata('paycontact');
        $this->getView()->assign('data',$data);
    }
    //关闭该支付通道
    public function closepayAction()
    {
        if($_POST){
            $adminMdl = new \AdminModel();
            $flag=$this->getpost('flag');
            if($flag==1){
                $data['is_show']=0;
            }else{
                $data['is_show']=1;
            }
            $where['id'] = $this->getpost('pid');
            if($adminMdl->updatainfo('`paycontact`',$data,$where)){
                $arr['code'] = 4;
                $arr['msg'] = '修改成功';
            }else{
                $arr['code'] = -4;
                $arr['msg'] = '系统异常，请稍候再试';
            }
            echo json_encode($arr);
            exit;
        }
    }
    
    /**
     * 订单信息展示
     **/
    public function orderlistAction()
    {
        $adminCtl = new logic\adminLogicController;
        $nowpage = $this->get('page');
        $data = $adminCtl->dopage('`order`',$nowpage,10);
        $data['addpage'] = $data['nowpage'];
        $data['descpage'] = $data['nowpage'];
        $this->getView()->assign('data',$data);
        
        //hc($data);
        /* $adminMdl = new \AdminModel();
        $num = 10;
        $countdata = $adminMdl->getDataCount('`order`');
        $maxpage = ceil($countdata[0]['cc']/$num);
        if($this->get('page')){
            $page = $this->get('page');
        }else{
            $page = 1;
        }
        if($page>$maxpage){
            $page = $maxpage;
        }elseif($page<1){
            $page = 1;
        }
        $start = ($page-1)*$num;
        $data = $adminMdl->getPageData('`order`', '', $start, $num);
        $this->getView()->assign('maxpage',$maxpage);
        $this->getView()->assign('descnowpage',$page);
        $this->getView()->assign('addnowpage',$page);
        $this->getView()->assign('data',$data); */
    }

}