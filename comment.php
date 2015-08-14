<!--  <?php 
    include './includes/page-header.php';
    include './includes/functions.php';
    $host_url = host_url();

    if($_POST){
		$database_config = require __DIR__.'/config/database.php';
		require_once __DIR__.'/lib/Medoo.class.php';

		$medoo = @new Medoo($database_config);
		$medoo->query('set names utf8');
	    $contents = $_POST['contents'];
	    // $user_id = $article[''];
	   // $article_id =  $_SESSION['article']['id'];
	    $comments = $medoo -> insert('comments', [  'contents'=> $contents 
	    //                                               'user_id'=> $user_id,
	                                             // 'article_id' =>$article_id,
	                                             ]
	                                 );


	   $_SESSION['errors']['state'] = 'am-alert-success';
	   $_SESSION['errors']['details'] = ['评论成功'];
	   header("Location:{$host_url}read_article.php");
	   exit;
    }
?>
<?php include './includes/footer.php';
?>
<?php
include './includes/page-end.php';
?> -->