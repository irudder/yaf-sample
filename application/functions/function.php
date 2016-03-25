<?php
    //print
    function hc($val)
    {
        echo "<pre>";
        var_dump($val);
        exit;
    }
    //检查用户名
    function valiUsername($username)
    {
        if(!$username && strlen($username)>20){
            return false;
        }
        return $username;
        //TODO 手机验证 邮箱认证。。。
    }
    //检查realname
    function valiRealname($realname)
    {
        if(!$realname && strlen($realname)>20){
            return false;
        }
        return $realname;
    }
    //检查pwd
    function valiPwd($pwd)
    {
        if(!$pwd && strlen($pwd)>20){
            return false;
        }
        return $pwd;
    }
    //检查idcard
    function valiIdcard($idcard)
    {
        if(strlen($idcard)!=18 && preg_match('/d{17}([0-9]|x)$/',$idcard)){
            return false;
        }
        return $idcard;
    }
        //php跳转
    function gotourl($t=0, $url='/')
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
    //设置memcache
    function getmem($key)
    {
        $mem = new Memcache;
        $mem->connect('127.0.0.1',11211);
        return $mem->get($key);
    }
    //获取memcache
    function setmem($key, $val, $flag=false, $t=86400)
    {
        $t = $t*7;//一周
        $mem = new Memcache;
        $mem->connect('127.0.0.1',11211);
        return $mem->set($key, $val, $flag,$t);
    }
    //替换memcache
    function replacemem($key, $val, $flag=false, $t=86400)
    {
        $t = $t*7;//一周
        $mem = new Memcache;
        $mem->connect('127.0.0.1',11211);
        return $mem->replace($key, $val, $flag,$t);
    }
    function getSession($key)
    {
        return Yaf_Session::getInstance()->__get($key);
    }

    function setSession($key, $val)
    {
        return Yaf_Session::getInstance()->__set($key, $val);
    }

    function unsetSession($key)
    {
        return Yaf_Session::getInstance()->__unset($key);
    }
    
    function clearCookie($key)
    {
        //echo $key."<br>";
        setcookie($key,'',time()-3600,'/');
    }

    function putCookie($key, $value, $expire = 3600, $path = '/', $domain = '', $httpOnly = FALSE)
    {
        setCookie($key, $value, time() + $expire, $path, $domain, $httpOnly);
    }

    function getCookie($key)
    {
        //echo $key;exit;
        return trim($_COOKIE[$key]);
    }
    /**
     * 对字符串等进行过滤
     */
    function stripHTML($content, $xss = true) 
    {
        $search = array("@<script(.*?)</script>@is",
            "@<iframe(.*?)</iframe>@is",
            "@<style(.*?)</style>@is",
            "@<(.*?)>@is"
        );

        $content = preg_replace($search, '', $content);

        if($xss)
        {
            $ra1 = array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 
            'style', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 
            'layer', 'bgsound', 'title', 'base');
                                    
            $ra2 = array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy',      'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');
            $ra = array_merge($ra1, $ra2);
            
            $content = str_ireplace($ra, '', $content);
        }

        return strip_tags($content);
    }
    function stripSQLChars($str) 
    {
        $replace = array('SELECT', 'INSERT', 'DELETE', 'UPDATE', 'CREATE', 'DROP', 'VERSION', 'DATABASES',
            'TRUNCATE', 'HEX', 'UNHEX', 'CAST', 'DECLARE', 'EXEC', 'SHOW', 'CONCAT', 'TABLES', 'CHAR', 'FILE',
            'SCHEMA', 'DESCRIBE', 'UNION', 'JOIN', 'ALTER', 'RENAME', 'LOAD', 'FROM', 'SOURCE', 'INTO', 'LIKE', 'PING', 'PASSWD');
        
        return str_ireplace($replace, '', $str);
    }
    function filter($content) 
    {
        if (!get_magic_quotes_gpc()) 
        {
            return addslashes($content);
        } else {
            return $content;
        }
    }
    function filterStr($arr) 
    {  
        if (!isset($arr)) {
            return null;
        }

        if (is_array($arr)) {
            foreach ($arr as $k => $v) {
                $arr[$k] = filter(stripSQLChars(stripHTML(trim($v), true)));
            }
        } else {
            $arr = filter(stripSQLChars(stripHTML(trim($arr), true)));
        }
        
        return $arr;
    }
    /**对字符串等进行过滤 end **/