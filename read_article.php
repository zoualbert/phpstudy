<?php
include './includes/page-header.php';
include './includes/functions.php';
$host_url = host_url();

$database_config = require __DIR__.'/config/database.php';
require_once __DIR__.'/lib/Medoo.class.php';

$medoo = @new Medoo($database_config);
$medoo->query('set names utf8');

if (!empty($_GET['aid']))
{	
   $article = $medoo->select('article',[
                                            '[>]users' => ['user_id' => 'id']
                                       ],
                                       [
                                            'article.id',
                                            'article.title',
                                            'article.created_at',
                                            'article.user_id',
                                            'article.content',
                                            'users.name',
                                        ],
                                        [
                                          'article.id' => $_GET['aid']
                                        ])[0];
  
} else {
	$_SESSION['errors']['state'] = 'am-alert-warning';
    $_SESSION['errors']['details'] = ['请您通过正确的方式进入读帖页面！'];
	header('Location:'.$host_url.'index.php');
	exit;
}
?>
<body>
	<?php include './includes/nav.php'; ?>
    <div class="am-g am-container php-bg-white  php-box-shadow am-padding-bottom">
        <?php include './includes/error.php';?>
    	<section name="topic">
    		<div class="am-u-lg-12 am-u-md-12 am-u-sm-12 am-margin-top-xl">
    			<section class="am-panel am-panel-primary">
					  <header class="am-panel-hd">
					  		<h3 class="am-panel-title"><?php echo $article['title']; ?></h3>
					  </header>
					  <div class="am-panel-bd">
					   		<pre class="php-text-indent"><?php echo $article['content']; ?></pre>
					   		<p class="php-text-gray am-margin-xs">
					   			<a href="<?php echo $host_url; ?>user.php?uid=<?php echo $article['user_id']; ?>"><?php echo $article['name']; ?></a>
                                &nbsp;于&nbsp;<?php echo $article['created_at']; ?>&nbsp;时发布
					   		</p>
					  </div>
				</section>
    		</div>
    	</section>
    </div>
	<?php include './includes/footer.php';?>
</body>
<?php
include './includes/page-end.php';
?>