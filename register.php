<?php
require('./include/config.php');
header("Content-Type: text/html; charset=utf-8");
if(isset($_POST["username"]) && isset($_POST["password"])){
	$username=$_POST["username"];
	$password=$_POST["password"];
	if(strlen($username)>20||strlen($password)>20){
		die('e100');//username or password is too long.
		//do something
}
$config=get_config("./user/user_config.php","user_num"); //it should be protected 
$user_num=intval($config);
$json_string1=file_get_contents("./user/username.json");
$json_string2=file_get_contents("./user/password.json");
$json_string3=file_get_contents("./user/extension.json");
$usernames=json_decode($json_string1,TRUE);
$passwords=json_decode($json_string2,TRUE);
$extensions=json_decode($json_string3,TRUE);  //get username,password,extension
$flag=0;
for ($x=1;$x<=$user_num;$x++){
	if($username==$usernames[$x]){
		$flag=1;
		break;
	}
}

if ($flag==1){
	//用户已经存在
  echo "a";
	//header("Location:http://127.0.0.1/project4/log_in.php?username=$username&password=$password");
	die();
}else{
    $usernames[$user_num+1]=$username;
    file_put_contents('./user/username.json',json_encode($usernames));
    $passwords[$user_num+1]=$password;
	file_put_contents('./user/password.json',json_encode($passwords));
	$extensions[$user_num+1]="welcome to nsc!";
	file_put_contents('./user/extension.json',json_encode($extensions));
    update_config('./user/user_config.php','user_num',$user_num+1);
    echo"c";

    die();
    //header("Location:http://127.0.0.1/project4/log_in.php");
}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/signin.css" rel="stylesheet">
    <link href="jQueryAssets/jquery.ui.core.min.css" rel="stylesheet" type="text/css" />
    <link href="jQueryAssets/jquery.ui.theme.min.css" rel="stylesheet" type="text/css" />
    <link href="jQueryAssets/jquery.ui.tabs.min.css" rel="stylesheet" type="text/css" />
    <link href="jQueryAssets/jquery.ui.dialog.min.css" rel="stylesheet" type="text/css" />
    <link href="jQueryAssets/jquery.ui.resizable.min.css" rel="stylesheet" type="text/css" />
    <link href="jQueryAssets/jquery.ui.button.min.css" rel="stylesheet" type="text/css" />
    <title>登录</title>
<script src="jQueryAssets/jquery-1.8.3.min.js" type="text/javascript"></script>
<script src="jQueryAssets/jquery-ui-1.9.2.tabs.custom.min.js" type="text/javascript"></script>
<script src="jQueryAssets/jquery-ui-1.9.2.dialog.custom.min.js" type="text/javascript"></script>
<script src="jQueryAssets/jquery-ui-1.9.2.button.custom.min.js" type="text/javascript"></script>
</head>
<body>
<div id="Tabs1">
      <ul>
        <li><a href="#tabs-1">Tab 1</a>
          <div id="Dialog3">Content for New Dialog Goes Here</div>
        </li>
        <li><a href="#tabs-2">Tab 2</a>
          <div id="Dialog1">Content for
            <button id="Button1">Button</button>
          </div>
        </li>
        <li><a href="#tabs-3">Tab 3</a>
          <div id="Dialog2">Content for New Dialog Goes Here</div>
        </li>
      </ul>
      <div id="tabs-1">
        <p>内容 1</p>
      </div>
      <div id="tabs-2">
        <p>内容 2</p>
      </div>
      <div id="tabs-3">
        <p>内容 3</p>
      </div>
    </div>
    <div class='container'>
        <form class="form-signin" action='' method='post' role="form">
            <h2 class="form-signin-heading text-center">登陆</h2>
            <input type="text" class="form-control" name="username" placeholder="Username" required autofocus>
            <input type="password" class="form-control" name="password" placeholder="Password" required>
            <!--input type="hidden" class="form-control" name="token" value="<?=$token ?>"-->
            <button class="btn btn-lg btn-primary btn-block" type="submit">登陆</button>
        </form>
    </div>
<script type="text/javascript">
$(function() {
	$( "#Tabs1" ).tabs(); 
});
$(function() {
	$( "#Dialog1" ).dialog(); 
});
$(function() {
	$( "#Dialog2" ).dialog(); 
});
$(function() {
	$( "#Dialog3" ).dialog(); 
});
$(function() {
	$( "#Button1" ).button(); 
});
</script>
</body>
</html>