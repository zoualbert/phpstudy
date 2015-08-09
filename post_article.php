<?php
include './includes/page-header.php';
include './includes/functions.php';
$host_url = host_url();

    $database_config = require __DIR__.'/config/database.php';
	require_once __DIR__.'/lib/Medoo.class.php';
	$medoo = @new Medoo($database_config);
	$medoo->query('set names utf8');

    $classes = $medoo->select('class', '*');
    
if (!isset($_SESSION['user']))
{
	$_SESSION['errors']['state'] = 'am-alert-warning';
    $_SESSION['errors']['details'] = ['请您先登录！'];
	header('Location:'.$host_url.'login.php');
	exit;
}
if ($_POST)
{

	$title = handle_illegal_string($_POST['title']);

	$content =  handle_illegal_string($_POST['content']);

	if (!$medoo->has('article',['title' => $title]) and strlen($content) > 10)
	{
		if ($medoo->insert('article',['title' => $title, 'content' => $content,'class_id' =>$_POST['class_id'], 'user_id' => $_SESSION['user']['id'], 'created_at' => date('Y-m-d H:i:s')]))
		{      
		
		   
			$_SESSION['errors']['state'] = 'am-alert-success';
			$_SESSION['errors']['details'] = ['发帖成功啦！'];
		    header('Location:'.$host_url.'index.php');
		    exit;
			
		} else {
			$_SESSION['post']['title'] = $_POST['title'];
			$_SESSION['post']['content'] = $_POST['content'];
			$_SESSION['errors']['state'] = 'am-alert-warning';
			$_SESSION['errors']['details'] = ['Sorry,@~_~@，我们的数据库出问题啦，稍后再试'];
		}

	} else {
		$_SESSION['errors']['state'] = 'am-alert-warning';
		$_SESSION['errors']['details'] = ['已经存在同名的帖子或者您的帖子内容太少'];
		$_SESSION['post']['title'] = $_POST['title'];
		$_SESSION['post']['content'] = $_POST['content'];
	}
}

?>

<body>
	<?php include './includes/nav.php'; ?>
		<div class="am-g am-container php-bg-white  php-box-shadow am-padding-bottom">
			<?php include './includes/error.php';?>
			<div class="am-u-lg-offset-1 am-u-lg-10 am-u-md-offset-1 am-u-md-10 am-u-sm-12 am-margin-top-xl">
				<form class="am-form" method="post" action="<?php echo $host_url;?>post_article.php">
					 <div class="am-form-group am-form-icon">
					      <label for="title">主题：</label>
					      <input type="text" class="am-radius php-input" name="title" placeholder="输入帖子主题" value="<?php echo session_read_post('title');?>" required>
				    </div>
                    <div class="am-form-group am-form-icon">
                       <select name="class_id",size="1">
                          <?php
                          		foreach ($classes as  $class) {
                          			?>
                          			<option value="<?php echo $class['id']; ?>"><?php echo $class['name']; ?></option><!--value表示值-->
                          			<?php
                          		}
                          ?>	
                       </select>

				    </div>
				    <div class="am-form-group">
				         <label for="doc-ta-1">内容：</label>
				         <textarea class="am-text-sm am-radius php-textarea" rows="5" name="content"><?php echo session_read_post('content'); ?></textarea>
				    </div>
				    <p><button type="submit" class="am-btn am-btn-primary am-radius am-text-sm">发布</button></p>
				</form> 
			</div>
			<div class="am-u-lg-1 am-u-md-1"></div>
		</div>
	<?php include './includes/footer.php';?>
	<?php 
	 if (isset($_SESSION['post']))
	 {
	 	unset($_SESSION['post']);
	 }
	?>
</body>

<?php
include './includes/page-end.php';
?>