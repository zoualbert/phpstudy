<?php
include './includes/page-header.php';
include './includes/functions.php';
$host_url = host_url();

$database_config = require __DIR__.'/config/database.php';
require_once __DIR__.'/lib/Medoo.class.php';

$medoo = @new Medoo($database_config);
$medoo->query('set names utf8');

$aid = isset($_GET['aid']) ? $_GET['aid'] : '';

if (!($aid == ''))
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
                                          'article.id' => $aid
                                        ])[0];
  //var_dump($article);
 // die;

   $article_id =  $article['id'];
   $show_comments = $medoo ->select('comments','*',[ 'article_id' => $aid,
                                                    ]);
   //var_dump($show_comments);
   if($_POST){
        $database_config = require __DIR__.'/config/database.php';
        require_once __DIR__.'/lib/Medoo.class.php';

        $medoo = @new Medoo($database_config);
        $medoo->query('set names utf8');
        $contents = $_POST['contents'];
        $user_id = $article['user_id'];
        $username = $_SESSION['user']['name'];
        //$article_id =  $article['id'];
       //var_dump($article_id);
        // die;
        $comments = $medoo -> insert('comments', [  'contents'=> $contents,
                                                     'user_id'=> $user_id,
                                                     'article_id' =>$article_id,
                                                     'created_at' =>  date('Y-m-d H:i:s'),
                                                     'username' => $username,
                                                 ]
                                    );
      
        $_SESSION['errors']['state'] = 'am-alert-success';
        $_SESSION['errors']['details'] = ['评论成功'];
        $show_comments = $medoo ->select('comments','*',[ 'article_id' => $aid,
                                                    ]);
       // header('Location:'.$host_url.'read_article.php?aid='.$aid);
       
    }
    
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

                        <div class="php-topform-left">
                            <ul class="am-list">
                              <?php 
                                foreach ($show_comments as $key => $show_coms) {
                                    ?>
                                    <pre class="am-panel-title"><?php echo $show_coms['contents'];?></pre>
                                    <p class="php-text-gray am-margin-xs">
                                        <a href="<?php echo $host_url; ?>user.php?uid=<?php echo $show_coms['user_id']; ?>"><?php echo $show_coms['username']; ?></a>
                                        &nbsp;于&nbsp;<?php echo $show_coms['created_at']; ?>&nbsp;时发布
                                    </p> 
                                    <?php
                                }
                              ?>
                            </ul>
                        </div>

                       <form action="<?php echo $host_url; ?>read_article.php?aid=<?php echo $aid; ?>" class="am-form am-form-horizontal" method="post" name="contents">
                            <div class="am-form-group">
                                <label for="doc-ta-1">评论：</label>
                                <textarea name="contents" rows="5" cols="100"></textarea>
                            </div>

                            <p><button type="submit" class="am-btn am-btn-default">评论</button></p>
        				  
                      </form>



				</section>
    		</div>
    	</section>
    </div>
	<?php include './includes/footer.php';?>
</body>
<?php
include './includes/page-end.php';
?>