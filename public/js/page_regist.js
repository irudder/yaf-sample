$(document).ready(function(){
    
    //获取JS传递的语言参数
    var utils = new Utils();
    var args = utils.getScriptArgs();    
    
    
    //隐藏Loading/注册失败 DIV
    $(".loading").hide();
    $(".login-error").hide();
    registError = $("<label class='error repeated'></label>");
    
    //加载国际化语言包资源
    utils.loadProperties(args.lang);
    
    //输入框激活焦点、移除焦点
    jQuery.focusblur = function(focusid) {
        var focusblurid = $(focusid);
        var defval = focusblurid.val();
        focusblurid.focus(function(){
            var thisval = $(this).val();
            if(thisval==defval){
                $(this).val("");
            }
        });
        focusblurid.blur(function(){
            var thisval = $(this).val();
            if(thisval==""){
                $(this).val(defval);
            }
        });
     
    };
    /*下面是调用方法*/
    $.focusblur("#uname");
    
    //获取表单验证对象[填写验证规则]
    var validate = $("#signupForm").validate({
        rules: {
            uname: {
                required: true,
                minlength: 4,
                maxlength: 16,
            },
            password: {
                required: true,
                minlength: 4,
                maxlength: 16
            },
            passwordAgain: {
                required: true,
                minlength: 4,
                maxlength: 16,
                equalTo: "#password"
            },
            realname: {
                required: true
            },
            idcard: {
                required: true,
                minlength: 18,
                maxlength: 18,
            }
        },
        messages: {
            uname: {
                required: $.i18n.prop("Form.请输入用户名"),
                uname: $.i18n.prop("Form.PleaseInputCorrectuname")
            },
            password: {
                required: $.i18n.prop("Form.请输入密码"),
                minlength: jQuery.format($.i18n.prop("Form.请输入指定长度密码")),
                maxlength: jQuery.format($.i18n.prop("Form.PasswordFormatMax"))
            },
            passwordAgain: {
                required: $.i18n.prop("Form.PasswordAgain"),
                minlength: jQuery.format($.i18n.prop("Form.PasswordFormat")),
                maxlength: jQuery.format($.i18n.prop("Form.PasswordFormatMax")),
                equalTo: jQuery.format($.i18n.prop("Form.PasswordDifferent"))
            },
            realname: {
                required: $.i18n.prop("Form.PleaseInputrealname")
            },
            idcard: {
                required: $.i18n.prop("Form.PleaseInputidcard")
            }
        }
    });
    
    
    //输入框激活焦点、溢出焦点的渐变特效
    if($("#uname").val()){
        $("#uname").prev().fadeOut();
    };
    $("#uname").focus(function(){
        $(this).prev().fadeOut();
    });
    $("#uname").blur(function(){
        if(!$("#uname").val()){
            $(this).prev().fadeIn();
        };        
    });
    if($("#password").val()){
        $("#password").prev().fadeOut();
    };
    $("#password").focus(function(){
        $(this).prev().fadeOut();
    });
    $("#password").blur(function(){
        if(!$("#password").val()){
            $(this).prev().fadeIn();
        };        
    });
    if($("#passwordAgain").val()){
        $("#passwordAgain").prev().fadeOut();
    };
    $("#passwordAgain").focus(function(){
        $(this).prev().fadeOut();
    });
    $("#passwordAgain").blur(function(){
        if(!$("#passwordAgain").val()){
            $(this).prev().fadeIn();
        };        
    });
    if($("#realname").val()){
        $("#realname").prev().fadeOut();
    };
    $("#realname").focus(function(){
        $(this).prev().fadeOut();
    });
    $("#realname").blur(function(){
        if(!$("#realname").val()){
            $(this).prev().fadeIn();
        };        
    });
    if($("#idcard").val()){
        $("#idcard").prev().fadeOut();
    };
    $("#idcard").focus(function(){
        $(this).prev().fadeOut();
    });
    $("#idcard").blur(function(){
        if(!$("#idcard").val()){
            $(this).prev().fadeIn();
        };        
    });
    
    
    //ajax提交注册信息
    $("#submit").bind("click", function(){
        regist(validate);
    });
    
    $("body").each(function(){
        $(this).keydown(function(){
            if(event.keyCode == 13){
                regist(validate);
            }
        });
    });
    
});

function regist(validate){    
    //校验uname, password，校验如果失败的话不提交
    if(validate.form()){
        if($("#checkBox").attr("checked")){
            var md5 = new MD5();
            $.ajax({
                url: "/register/doreg",
                type: "post",
                data: {
                    username: $("#uname").val(),
                    password: $("#password").val(),
                    realname: $("#realname").val(),
                    idcard: $("#idcard").val(),
                    
                },
                dataType: "json",
                beforeSend: function(){
                    //$('.loading').show();
                },
                success: function(data){
                    //alert(data.code);
                    $('.loading').hide();
                    if(data.hasOwnProperty("code")){
                        if(data.code == 1){
                            //注册成功
                            window.location.href = "/user/";
                        }else{
                            alert(data.msg);
                        }
                    }
                }
            });
        }else{
            //勾选隐私政策和服务条款
            $(".login-error").show();
            $(".login-error").html($.i18n.prop("请勾选已阅读并同意隐私政策、服务条款"));
        }
    }
}

var Utils = function(){};

Utils.prototype.loadProperties = function(lang){
    jQuery.i18n.properties({// 加载资浏览器语言对应的资源文件
        name:'ApplicationResources',
        language: lang,
        path:'resources/i18n/',
        mode:'map',
        callback: function() {// 加载成功后设置显示内容
        } 
    });    
};

Utils.prototype.getScriptArgs = function(){//获取多个参数
    var scripts=document.getElementsByTagName("script"),
    //因为当前dom加载时后面的script标签还未加载，所以最后一个就是当前的script
    script=scripts[scripts.length-1],
    src=script.src,
    reg=/(?:\?|&)(.*?)=(.*?)(?=&|$)/g,
    temp,res={};
    while((temp=reg.exec(src))!=null) res[temp[1]]=decodeURIComponent(temp[2]);
    return res;
};
