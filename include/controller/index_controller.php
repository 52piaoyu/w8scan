<?php
/*
 * 首页显示方法
 */
class Index_Controller {

    function __construct(){
        $this->Model_user = new User_Model();
    }
    function display($params = ''){
        $plugin_info = new Splugins_Controller();
        $plugin_count = $plugin_info->getCount();
        $plugin_data = $plugin_info->DisplayOnHome();
        include View::getView("header");
        include View::getview("home");  //首页
    }
    function login($params = ''){
        if(!empty($_POST["username"])){
            $username = addslashes($_POST["username"]);
            $password = addslashes($_POST["password"]);
            if($this->Model_user->checkUser($username,$password)){
                $userData = $this->Model_user->getUser($username,$password);
                $_SESSION["user"] = $userData["user"];
                $_SESSION["uid"] = $userData["id"];
                $_SESSION["admin"] = $userData["vip"]==1?true:false;
                emDirect("./");
            }else{
                emMsg("用户名或密码错误");
            }
        }
        include View::getView("header");
        include View::getview("login");  
    }
    function reg($params = ''){
        if(!empty($_POST["secode"])){
            $logData = array();
            $logData["user"] = addslashes($_POST["username"]);
            $logData["password"] = addslashes($_POST["password"]);
            $logData["email"] = addslashes($_POST["email"]);
            $logData["vip"] = 0;
            $secode = addslashes($_POST["secode"]);
            if($secode === REG_CODE){
                // 检测用户名是否已被注册
                if($this->Model_user->isUserExist($logData["user"])){
                    emMsg("已有重复的用户名");
                    exit();
                }

                if($this->Model_user->insertData($logData)){
                    $return_msg = "注册成功！";
                }else{
                    emMsg("注册失败");
                    exit();
                }
            }else{
                emMsg("注册邀请码错误");
                exit();
            }
            
        }
        include View::getView("header");
        include View::getview("register"); 
    }

    function logout($params = ''){
        $_SESSION = array();
        emDirect(BLOG_URL);
    }
}