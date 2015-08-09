<?php
	include './includes/page-header.php';
	include './includes/functions.php';
	$host_url = host_url();


	if ($_POST)//判断是否提交数据
	{
		if (($_POST['verifycode'] == $_SESSION['verifycode']['code']) and (time() - $_SESSION['verifycode']['time'] < 5 * 60))
		{
			$database_config = require __DIR__.'/config/database.php';
			require_once __DIR__.'/lib/Medoo.class.php';
			$medoo = @new Medoo($database_config);
			$medoo->query('set names utf8');

			$name = handle_user_post_string($_POST['name']);
			$password = trim($_POST['password']);//去除字符串结尾的空白字符（或其他字符）
			$password_again = trim($_POST['password_again']);
			$mobile = trim($_POST['mobile']);
			$email =  handle_user_post_string($_POST['email']);

			$has_error = FALSE;
			$errors = [];//空的数组

			//check name
			$check_user_name_result = check_user_name($name,$medoo); 
			if ($check_user_name_result[0])
			{
				$has_error = TRUE;
				array_push($errors, $check_user_name_result[1]);
			}
			//check password
			$check_user_password_result = check_user_password($password,$password_again);
			if ($check_user_password_result[0])
			{
				$has_error = TRUE;
				array_push($errors, $check_user_password_result[1]);
			}
			//check mobile
			$check_user_mobile_result = check_user_mobile($mobile,$medoo);
			if ($check_user_mobile_result[0])
			{
				$has_error = TRUE;
				array_push($errors, $check_user_mobile_result[1]);
			}
			//check email
			$chekc_user_email_result = check_user_email($mobile,$medoo); 
			if (!$chekc_user_email_result[0])
			{
				$has_error = TRUE;
				array_push($errors,$chekc_user_email_result[1]);
			}

			if (!$has_error)
			{
				$insert_result = $medoo->insert('users',
						[
							'name' => $name,
							'password' => md5($password),
							'email' => $email,
							'mobile' => $mobile,
							'created_at' => date('Y-m-d H:i:s')//date — 格式化一个本地时间／日期,将后面的返回给
						]);
				if ($insert_result)
				{
					$_SESSION['errors']['state'] = 'am-alert-success';
					$_SESSION['errors']['details'] = ['恭喜您，注册成功！'];
					$_SESSION['user'] = $medoo->select('users','*',['id' => $insert_result])[0];
					header("Location:index.php");
					exit;//exit — 输出一个消息并且退出当前脚本 

				} else {
					$_SESSION['errors']['state'] = 'am-alert-warning';
					$_SESSION['errors']['details'] = ['Sorry,@~_~@，我们的数据库出问题啦，稍后再试'];
				}

			} else {
				$_SESSION['post']['name'] = $_POST['name'];
				$_SESSION['post']['email'] = $_POST['email'];
				$_SESSION['post']['mobile'] = $_POST['mobile'];
				$_SESSION['errors']['state'] = 'am-alert-warning';
				$_SESSION['errors']['details'] = $errors;
			}

		} else {

				$_SESSION['post']['name'] = $_POST['name'];
				$_SESSION['post']['email'] = $_POST['email'];
				$_SESSION['post']['mobile'] = $_POST['mobile'];
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
				 <form action="<?php echo $host_url."regist.php"; ?>" class="am-form am-form-horizontal" method="post">
				 		<div class="am-form-group am-form-icon">
						    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">用户名：</label>
						    <div class="am-u-sm-10">
						      <i class="am-icon-user php-input-icon"></i>
						      <input type="text" name="name" placeholder="用户名 8 ~ 24位字符" class="php-input am-radius" required value="<?php echo session_read_post('name');?>">
						    </div>
						</div>
						<div class="am-form-group am-form-icon">
						    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">密码：</label>
						    <div class="am-u-sm-10">
						      <i class="am-icon-key php-input-icon"></i>
						      <input type="password" name="password" placeholder="密码 8 ~ 24 位字符" class="php-input am-radius" required>
						    </div>
						</div>
						<div class="am-form-group am-form-icon">
						    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">确认密码：</label>
						    <div class="am-u-sm-10">
						      <i class="am-icon-key php-input-icon"></i>
						      <input type="password" name="password_again" placeholder="确认密码" class="php-input am-radius" required>
						    </div>
						</div>
						<div class="am-form-group am-form-icon">
						    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">移动电话：</label>
						    <div class="am-u-sm-10">
						      <i class="am-icon-phone php-input-icon"></i>
						      <input type="text" name="mobile" placeholder="11位移动电话号码" class="php-input am-radius" required value="<?php echo session_read_post('mobile');?>">
						    </div>
						</div>
						<div class="am-form-group am-form-icon">
						    <label for="doc-ipt-3" class="am-u-sm-2 am-form-label">邮箱：</label>
						    <div class="am-u-sm-10">
						      <i class="am-icon-envelope php-input-icon"></i>
						      <input type="email" name="email" placeholder="您的常用邮箱" class="php-input am-radius" id="js-email" required value="<?php echo session_read_post('email');?>">
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
						      	<button type="submit" class="am-btn am-btn-primary am-radius php-button" >注册</button>
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