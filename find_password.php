<?php
include './includes/page-header.php';
include './includes/functions.php';
 $host_url = host_url();
 if($_POST){
    if (($_POST['verifycode'] == $_SESSION['verifycode']['code']) and (time() - $_SESSION['verifycode']['time'] < 5 * 60))
    {
	   	$database_config = require __DIR__ . '/config/database.php';  //包含配置文件
	    require_once __DIR__ . '/lib/Medoo.class.php';  //包含数据库
	    $medoo = @new Medoo($database_config);    //连接数据库
	    $medoo->query('set names utf8');      //设置字符编码
	    $email =  handle_user_post_string($_POST['email']);
	    $name = handle_user_post_string($_POST['name']);
	    $user = $medoo->select('users','*',['And' => [
	                                                   'name' => $name,
	                                                   'email' => $email,
	                                                 ]
                                           ]
                              );
	  
	    if(count($user)){//count 计算数组中的单元数目或对象中的属性个数
		     $_SESSION['user'] = $user[0];
		}
		if(isset($_SESSION['user'])){//isset — 检测变量是否设置 
		
           echo $_SESSION['user']['password'];
		}
		     
	 // 	//check email
		// $chekc_user_email_result = check_user_email($mobile,$medoo); 
		// if (!$chekc_user_email_result[0])
		// {
		// 	$has_error = TRUE;
		// 	array_push($errors,$chekc_user_email_result[1]);
		// }

    }else{
    	$_SESSION['post']['email'] = $_POST['email'];
    	$_SESSION['errors']['state'] = 'am-alert-warning';
	    $_SESSION['errors']['details'] = ['您提交的验证码有误或者您的验证码已经失效'];
    }
}



?>






<body>   
	<?php include './includes/nav.php'; ?>
		<div class="am-g am-container php-bg-white  php-box-shadow">
			<?php include './includes/error.php';?>
			<div class="am-u-lg-offset-2 am-u-md-offset-2 am-u-md-8 am-u-lg-8 am-u-sm-12  am-padding-top am-margin-top-xl ">
				 <form action="<?php echo $host_url."find_password.php"; ?>" class="am-form am-form-horizontal" method="post">
			 	    <div class="am-form-group am-form-icon">
					    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">用户名：</label>
					    <div class="am-u-sm-10">
						    <i class="am-icon-user php-input-icon"></i>
						    <input type="text" name="name" placeholder="您忘记的用户名" class="php-input am-radius" required>
					    </div>
					</div>
			 	    <div class="am-form-group am-form-icon">
					    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">邮箱：</label>
					    <div class="am-u-sm-10">
						    <i class="am-icon-envelope php-input-icon"></i>
						    <input type="email" name="email" placeholder="您注册时使用的邮箱" class="php-input am-radius" required>
					    </div>
					</div>
					<div class="am-form-group am-form-icon">
						    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">验证码：</label>
					    <div class="am-u-sm-10">
					        <i class="am-icon-code php-input-icon"></i>
					        <input type="text" name="verifycode" placeholder="验证码" class="php-input am-radius" required style="width:78%;display:inline-block">

					        <span class="am-btn am-btn-success am-radius php-button" id="js-get-verify-code">获取验证码</span>
				        </div>
					</div>
					<div class="am-form-group ">
					    <div class="am-u-sm-offset-2 am-u-sm-10">
					      	<button type="submit" class="am-btn am-btn-primary am-radius php-button" >重置密码</button>
					      	<p class="am-text-sm php-text-gray am-kai">温馨提示：如果您的邮箱没有收到邮件，请查看您的垃圾箱；</p>
					    </div>
				    </div>
				</form>
		</div>
			<div class="am-u-md-2 am-u-lg-2 am-u-sm-2"></div>
		</div>

		<div class="am-modal am-modal-no-btn am-radius" tabindex="-1" id="my-modal">
		    <div class="am-modal-dialog am-radius">
			    <div class="am-modal-bd">
			       <span class="am-text-default">验证码发送成功！</span>
			    </div>
		    </div>
		</div>

		<script type="text/javascript">
			jQuery(document).ready(function(){
				jQuery("#js-get-verify-code").click(function(event){
					event.preventDefault();
					var email = jQuery("#js-email").val();
					 if (!jQuery.trim(email)) {
					 	jQuery("#my-modal").find('span').text('请您输入邮箱').end().modal('open');
					 } else {
					 	var url = './verify_mailer.php?email=' + email;
					 	jQuery.get(url,function(response,status){
					 		console.log(response);
					 		console.log(status);
					 		if (response == 200 && status == 'success') {
					 			jQuery("#my-modal").find('span').text('验证码发送成功,请去您的邮箱查看').end().modal('open');
					 		} else {
					 			jQuery("#my-modal").find('span').text('验证码发送失败').end().modal('open');
					 		}
					 	});
					 }
				});
			});
		</script>
		   
    <?php include './includes/footer.php';?>
</body>
<?php
	include './includes/page-end.php';
?>

