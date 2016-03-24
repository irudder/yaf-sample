<?php
header("Content-type:text/html;char-set=utf-8");
class basicController extends Yaf_Controller_Abstract
{
    public function init()
    {
        yaf_Loader::import(APP_PATH.'/application/functions/function.php');
    }
    
    //判断是否自动登录
    public function flag()
    {
        $flag =0;
        if($this->getSession("uid"))
        {
            $uid =$this->getSession("uid");
            $flag=1;
        }elseif($this->getCookie("uid")){
            $uid =$this->getCookie("uid");
            $flag=1;
        }else{
            $flag=0;
        }
        if($flag==1)
        {
            $token_key = md5($uid.'token');
            $token_c = $this->getCookie($token_key);
            $token_m = $this->getmem($token_key);
            if($token_c===$token_m){
                if(!$this->getSession("uid")){
                    //未登录时重新登录
                    $user = new UserModel();
                    $udata = $user->getuserinfo($uid);
                    //var_dump($udata);exit;
                    $this->setSession('uname',$udata['uname']);
                    $this->setSession('uid',$uid);
                    //记录上次登录ip以及时间
                    $this->replacemem($udata['id'].'lasttime',$udata['lasttime']);
                    $this->replacemem($udata['id'].'lastip',$udata['lastip']);
                }
                
            }else{
                $this->unsetSession('uname');
                $this->unsetSession("uid");
            }
        }        
        
    }
    //设置memcache
    public function getmem($key)
    {
        $mem = new Memcache;
        $mem->connect('127.0.0.1',11211);
        return $mem->get($key);
    }
    //获取memcache
    public function setmem($key, $val, $flag=false, $t=86400)
    {
        $t = $t*7;//一周
        $mem = new Memcache;
        $mem->connect('127.0.0.1',11211);
        return $mem->set($key, $val, $flag,$t);
    }
    //替换memcache
    public function replacemem($key, $val, $flag=false, $t=86400)
    {
        $t = $t*7;//一周
        $mem = new Memcache;
        $mem->connect('127.0.0.1',11211);
        return $mem->replace($key, $val, $flag,$t);
    }
    //php跳转
    public function gotourl($t=0, $url='/')
    {
        $url = "http://".$_SERVER['HTTP_HOST']."/".$url;
        if($t==0){
            $go = "Location:".$url;
        }else{
            $go = "refresh:".$t.";url=".$url;
        }
        header($go);
        exit;
    }
    
    public function getSession($key)
    {
        return Yaf_Session::getInstance()->__get($key);
    }

    public function setSession($key, $val)
    {
        return Yaf_Session::getInstance()->__set($key, $val);
    }

    public function unsetSession($key)
    {
        return Yaf_Session::getInstance()->__unset($key);
    }
    
    public function clearCookie($key)
    {
        //echo $key."<br>";
        setcookie($key,'',time()-3600,'/');
    }

    public function setCookie($key, $value, $expire = 3600, $path = '/', $domain = '', $httpOnly = FALSE)
    {
        setCookie($key, $value, time() + $expire, $path, $domain, $httpOnly);
    }

    public function getCookie($key)
    {
        //echo $key;exit;
        return trim($_COOKIE[$key]);
    }
}