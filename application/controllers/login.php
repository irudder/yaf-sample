<?php
class LoginController extends BasicController 
{
    public function init()
    {
        parent::init();
        $this->flag();
        return false;
    }
    
    public function indexAction() 
    {//默认Action
        $uid = getSession('uid');
        $token_key = md5($uid.'token');
        $token_c = getCookie($token_key);
        $token_m = getmem($token_key);
        if(getSession('uname') && $token_c===$token_m)
        {
            echo "已登录~";;
            gotourl($t=0,$url='user');
            return false;
        }        
        $this->getView();
   }
   public function checkloginAction()
   {
        $data['uname'] = filterStr($_POST['uname']);
        $data['pwd'] = filterStr($_POST['password']);
        $login = new logic\LogicController;
        $login = $login->login($data);
        echo $login;
        exit;
       /*
        //清除可能的xss注入~~filterStr
        $uname = filterStr($_POST['uname']);
        $password = md5(filterStr($_POST['password']));
        if($uname=='' || $password==''){
            $arr['code'] = 0;
            $arr['msg']  = "用户名或密码不能为空";
        }else{
            $user = new UserModel();
            $udata = $user->checkuserinfo($uname,$password);
            if($udata['id']){
                $arr['code'] = 200;
                $arr['msg']  = "登录成功";        
                
                //保存cookie和session和memcache
                setSession('uname',$udata['uname']);
                setSession('uid',$udata['id']);
                putCookie("uid", $udata['id'], 3600*24*7);
                //加密的token用作比较是否修改密码
                $token_key = md5($udata['id'].'token');
                $token_val = md5($udata['id'].''.$udata['pwd']);
                putCookie($token_key, $token_val, 3600*24*7);
                setmem($token_key, $token_val);        
                
                //记录上次登录ip以及时间
                if(!getmem($udata['id'].'lasttime') || !getmem($udata['id'].'lastip')){
                    setmem($udata['id'].'lasttime',$udata['lasttime']);
                    setmem($udata['id'].'lastip',$udata['lastip']);
                }else{
                    replacemem($udata['id'].'lasttime',$udata['lasttime']);
                    replacemem($udata['id'].'lastip',$udata['lastip']);
                }                
                
                //更新最后登录时间以及最后登录ip
                $m['lasttime'] = time();
                $m['lastip'] = $_SERVER["REMOTE_ADDR"];
                if(!$user->updatarecord($udata['id'],$m))
                {
                    $arr['code'] = -500;
                    $arr['msg']  = "系统异常，请稍候再试";
                    echo json_encode($arr);
                    exit;
                }                
                //TODO....如果没有进行更新将error存入日志
                
            }else{
                $arr['code'] = -400;
                $arr['msg']  = "用户名或密码错误";
            }
        }
        echo json_encode($arr);
        exit;
        */
   }
}