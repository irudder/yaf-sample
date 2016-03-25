<?php
namespace logic;
class LogicController 
{
    public function test()
    {
        hc('本类为抽象出的业务层；只接受传入的数据，只返回对应的结果');
    }
    
    //注册表单验证
    public function valiRegDate($data)
    {
        if(!(valiUsername($data['uname']) && valiRealname($data['realname']) && valiPwd($data['pwd']) && valiIdcard($data['idcard']))){
            return false;
        }
        return true;
    }
    /**
     * 输入data为$uname,$pwd,$relname,$idcard
     * return $arr['code'].$arr['msg']
     */
    public function reg($data)//表单注册
    {
        //$uname,$pwd,$relname,$idcard
        //验证
        if(!$this->valiRegDate($data)){
            $arr['code'] = -100;
            $arr['msg']  = "非法操作，请正确填写。";
        }else{
            $m['uname'] = $data['uname'];
            $user = new \UserModel();
            $udata = $user->checksameuser($m['uname']);
            if($udata){
                $arr['code'] = -2;
                $arr['msg']  = "该用户已注册，请直接登录";
            }else{
                $m['pwd'] = md5($data['pwd']);
                $m['realname'] = $data['realname'];
                $m['idcard'] = $data['idcard'];
                $m['regtime'] = time();
                $m['regip'] = $_SERVER["REMOTE_ADDR"];
                $m['lasttime'] = $m['regtime'];
                $m['lastip'] = $m['regip'];
                
                if($user->insertuserinfo($m)){
                    $arr['code'] = 1;
                    $arr['msg']  = "注册成功";
                    
                    $udata = $user->checkuserinfo($m['uname'],$m['pwd']);
                    /**注册免登陆**/
                    setSession('uname',$udata['uname']);
                    setSession('uid',$udata['id']);
                    putCookie("uid", $udata['id'], 3600*24*7);
                    //加密的token用作比较是否修改密码
                    $token_key = md5($udata['id'].'token');
                    $token_val = md5($udata['id'].''.$udata['pwd']);
                    putCookie($token_key, $token_val, 3600*24*7);
                    setmem($token_key, $token_val);
                    //记录登录ip以及时间
                    setmem($udata['id'].'lasttime',$udata['lasttime']);
                    setmem($udata['id'].'lastip',$udata['lastip']);
                    
                }else{
                    $arr['code'] = -1;
                    $arr['msg']  = "注册失败，请稍候再试";
                }
            }
            return json_encode($arr);
        }
    }
    //登录表单验证
    public function valiLogDate($data)
    {
        if(valiUsername($data['uname']) &&  valiPwd($data['pwd'])){
            return true;
        }
        return false;
    }
    //登录表单
    public function login($data)
    {
        if(!$this->valiLogDate($data)){
            $arr['code'] = -100;
            $arr['msg']  = "非法操作，请正确填写。";
        }else{
            $user = new \UserModel();
            $data['pwd'] = md5($data['pwd']);
            $udata = $user->checkuserinfo($data['uname'],$data['pwd']);
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
                    return json_encode($arr);
                    exit;
                }                
                //TODO....如果没有进行更新将error存入日志
                
            }else{
                $arr['code'] = -400;
                $arr['msg']  = "用户名或密码错误";
            }
        }
        return json_encode($arr);
    }
    //密码修改，用户id可以省略，找回密码的情况下不可省略
    public function updatapwd($pwd,$uid)
    {
        if(!$pwd || !$uid){
           exit; 
        }
        $user = new \UserModel();
        if(!$user->updatauserinfo($uid, md5($pwd)))
        {
            $arr['code'] = -500;
            $arr['msg']  = "系统异常，请稍候再试";
        }else{
            //更新cookie中的token与memcache中的token
            $token_key = md5($uid.'token');
            $token_val = md5($uid.''.$pwd);
            putCookie($token_key, $token_val, 3600*24*7);
            replacemem($token_key, $token_val);  
            $arr['code'] = 200;
            $arr['msg']  = "密码修改成功";
        }
        return json_encode($arr);
              
    }
    
}