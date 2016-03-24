<?php
    //print
    function hc($val)
    {
        echo "<pre>";
        var_dump($val);
        exit;
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