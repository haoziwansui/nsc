<?php
require('./include/config.php');
if($_POST){
	//session_start();
	if (isset($_COOKIE[session_name()])&&$_COOKIE[session_name()]!==$_SESSION[session_name()]){ //检验是否post了token，以及token和session中的值的比较
		header("location:./log_in.php");
	}
	
    $username=$_POST["username"];
    $password=$_POST["password"];
    $flag=log_in($username,$password);//检验用户名，密码，如果正确，生成cookie;
    if($flag!=0){
    	session_start();
    	$_SESSION["username"] = $username;
        setcookie(session_name(), $username,time()+600);
        $userinfo3=file_get_contents("./user/extension.json");
   		$user3=json_decode($userinfo3,True);
   		$extension=$user3[$flag];
        header('Location:./self.php?flag=$flag&extension=$extension');
        //载入用户的消息及通知

    }
    
}else{
	if(isset($_SESSION)){
			session_destroy();//如果重新回到log页面但没有提交token或用户参数，则销毁之前的session,
		}
	//session_start();
    $token = md5(session_id());
    $_SESSION[session_name()] = $token;
}
    
	function log_in($username,$password){
    	$config=get_config("./user/user_config.php","user_num"); //it should be protected 
	    $user_num=intval($config);
	    $flag=0;
	    $userinfo1=file_get_contents("./user/username.json");
    	$user1=json_decode($userinfo1,True);
    	$userinfo2=file_get_contents("./user/password.json");
    	$user2=json_decode($userinfo2,True);
    	
    	for($x=1;$x<=$user_num;$x++){
	    	if ($user1[$x]==$username){
	    		$flag=$x;
	    	}
	    }
	    
	    if($flag==0){
	    	echo "<script> alert('user does not exisits!')</script>";
	        header("Location:http://security.bit.edu.cn/register.html"); //跳转到用户注册的界面
	        return $flag;
	        die();
	    }
	   	if($user2[$flag]==$password){
	   		$_SESSION["username"] = $username;
	   		setcookie("username", $username, time()+600);
	   		header("Location:introduction.php");//跳转到介绍页面或者主页
	   		return $flag;
		}else{
			echo "<script> alert('password error!')</script>";
		}



		
	}
?>
