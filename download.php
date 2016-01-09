<?php
error_reporting(E_ALL&~E_NOTICE);
header("Content-Type: text/html; charset=utf-8");
if(isset($_POST["tool"])){
	require('./include/config.php');
	//获取软件介绍的所有内容
	$tool=$_POST['tool'];
	$title=get_config("./download/".$tool."/$tool.php","title");
	$writer=get_config("./download/".$tool."/$tool.php","writer");
	$content=get_config("./download/$tool$tool.php","content");
	$link=get_config("./download/".$tool."/$tool.php","link");
	$message_num=get_config("./download/".$tool."/$tool.php","message_num");
	
	$message_num=intval($message_num);
	$update_time=get_config("./download/".$tool."/$tool.php","update_time");
	//获取评论内容
	$comment=file_get_contents("./download/".$tool."/comment.json");
	$comment=json_decode($comment,TRUE);
	$queue=array();
	print_r($comment);

	/*
	for($x=1;$x<=$message_num;$x++){
		$queue[$x]=1;

	}
	for($x=1;$x<=$message_num;$x++){
		//获取输出评论，先输出父评论，然后输出子评论
		if($queue[$x]==0){
			continue;
		}
		//echo $comment[$x]["content"]; 父评论
		//echo $comment[$x]["time"];
		//echo $comment[$x]["uid"];
		//echo $comment[$x]["child"];
		$queue[$x]=0;//评论已输出，队列中对应的校验值置0；
		$a=$x;
		for(;$comment[$a]["child"][1]!=0;){
			$num=count($comment[$a]["child"]);//获取数组长度
			for($y=1;$y<=$num;$y++){
				$a=$comment[$x]["child"][$y];
				//echo $comment[$a]["content"];子评论，循环直至该评论没有儿子;
				$queue[$a]=0;

			}
			
		}
	}
	*/
	
	function get_comment($comment,$comment_id){ 
		Global $queue;
		if($comment[$comment_id]['child'][0]==0){ //如果没有子节点，则打印出该节点，并从队列中将其置0
			$queue[$comment_id]=0;
			echo $comment[$comment_id]['content'];
		}else{  
			$num=count($comment[$comment_id]['child']);
			$comment_id_parent=$comment_id;
			for($y=0;$y<$num;$y++){//如果有子节点，先计算子节点数目，对于每一个子节点递归调用get—comment函数
				
				$comment_id=$comment[$comment_id_parent]['child'][$y];
				get_comment($comment,$comment_id);
				$queue[$comment_id] =0;//如果下级子节点遍历结束，则打印出出该根节点，并从队列中置0
			}
			echo $comment[$comment_id_parent]['content'];
		}
	return true;
	}
	for($x=1;$x<=$message_num;$x++){
		$queue[$x]=1;
		}
	for($x=1;$x<=$message_num;$x++){
		if($queue[$x]==0){
			continue;
		}
		get_comment($comment,$x);

		}

	

//评论模块,添加评论需要提交的参数uid，time，content，parent,tool
if(isset($_POST['uid'])&&isset($_POST['time'])&&isset($_POST['content'])&&isset($_POST['parent'])){

	if (isset($_COOKIE['token'])){

		if($_COOKIE['token']!=$_SESSION['token']){    //检验cookie中的token，以及token和session中的值的比较
		header("location:./log_in.php");
		die();
		}else{
		//写入comment.txt
			$parent=intval($_POST['parent']);
			$comment[$message_num+1]['uid']=$_POST['uid'];
			$comment[$message_num+1]['time']=$_POST['time'];
			$comment[$message_num+1]['content']=$_POST['content'];
			$comment[$_POST['parent']]['child']=$message_num+1;
			file_put_contents('./download/".$tool."/comments.txt', json_encode($comment));

		//刷新这个页面
			header("Location:http://security.bit.edu.cn/download.php?tool=$tool");

	}
	}

}
}



?>