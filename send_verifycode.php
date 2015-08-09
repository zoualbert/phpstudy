<?php
session_start();//使用session_start()这个函数的前面不能有任何的输出，
header("Content-type:text/html;charset=utf-8");
if ($_GET)//$_GET -- $HTTP_GET_VARS [已弃用] — HTTP GET 变量 
{
	$to = $_GET['email'];
	include "./lib/SimpleMailer.php";
    $config = include './config/email.php';

    $smailer = new SimpleMailer($config['host'], $config['port'], $config['user'], $config['pass']);
    if ($smailer)
    {
    	$subject = "PHP study 注册验证码";
    	$_SESSION['verifycode']['code'] = mt_rand(0, pow(10, 6) - 1);///pow(n,m)  表示n的m次幂
    	$content = "请使用验证码:{$_SESSION['verifycode']['code']}在十分钟之内完成注册";
    	if ($smailer->send_email($config['from'], $to, $subject, $content))
    	{
    		$_SESSION['verifycode']['time'] = time();
    		echo 200; //邮件发送成功
    	} else {
    		unset($_SESSION['verifycode']);//unset — 释放给定的变量 
    		 // $smailer->show_debug();
       //       die;
    		echo 111; //邮件发送失败
    	}
    } else {
    	echo 222; //初始化错误
    }
} else {
	echo 333; //没有提交邮箱
}


