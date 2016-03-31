<?php
class basicController extends Yaf_Controller_Abstract
{
    public function init()
    {
        header('Content-type:text/html;charset=utf-8');
        //yaf_Loader::import(APP_PATH.'/application/functions/function.php');
    }
    
    //判断是否自动登录
    public function flag()
    {
        $flag =0;
        if(getSession("uid"))
        {
            $uid =getSession("uid");
            $flag=1;
        }elseif(getCookie("uid")){
            $uid =getCookie("uid");
            $flag=1;
        }else{
            $flag=0;
        }
        if($flag==1)
        {
            $token_key = md5($uid.'token');
            $token_c = getCookie($token_key);
            $token_m = getmem($token_key);
            if($token_c===$token_m){
                if(!getSession("uid")){
                    //未登录时重新登录
                    $user = new UserModel();
                    $udata = $user->getuserinfo($uid);
                    //var_dump($udata);exit;
                    setSession('uname',$udata['uname']);
                    setSession('uid',$uid);
                    //记录上次登录ip以及时间
                    replacemem($udata['id'].'lasttime',$udata['lasttime']);
                    replacemem($udata['id'].'lastip',$udata['lastip']);
                }
                
            }else{
                unsetSession('uname');
                unsetSession("uid");
            }
        }        
        
    }
    
    public function get($key, $filter = TRUE) {
        if ($filter) {
            return filterStr($this ->getRequest() ->get($key));
        } else {
            return $this ->getRequest() ->get($key);
        }
    }

    public function getPost($key, $filter = TRUE) {
        if ($filter) {
            return filterStr($this ->getRequest() ->getPost($key));
        } else {
            return $this ->getRequest() ->getPost($key);
        }
    }

    public function getParam($key, $filter = TRUE) {
        if ($this ->getRequest() ->isGet()) {
            if ($filter) {
                return filterStr($this ->getRequest() ->get($key));
            } else {
                return $this ->getRequest() ->get($key);
            }
        } else {
            if ($filter) {
                return filterStr($this ->getRequest() ->getPost($key));
            } else {
                return $this ->getRequest() ->getPost($key);
            }
        }
    }
}