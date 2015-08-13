<?php
    include './includes/page-header.php';
    include './includes/functions.php';
    $host_url = host_url();

    $database_config = require __DIR__.'/config/database.php';
    require_once __DIR__.'/lib/Medoo.class.php';

    $medoo = @new Medoo($database_config);
    $medoo->query('set names utf8');

    $class_id = isset($_GET['class_id'])? $_GET['class_id'] : 2;//必须要有默认值
    $request_page    =isset( $_GET['page'])  ? $_GET['page']  : 1;

    $pagecount = 2;//每一页的条数
    $count = $medoo->count('article',[
                                      'AND'   => [
                                                    'pass'  =>  'true',
                                                    'article.class_id' =>  $class_id,
                                                  ],
                                     ]);//计算出一共有多少条帖子

    $pagenum = ceil($count / $pagecount);//一共的页数，其中ceil（）函数是进一法取整

    $classes  = $medoo->select('class', '*');

    $article_all    =   $medoo -> select('article', [
                                                        "[>]users"  =>  ['article.user_id'  => 'id'],   //多表查询
                                                        "[>]class"  =>  ['article.class_id' =>  'id'],
                                                    ],
                                                    [   'article.id','article.title','article.created_at','article.user_id','article.class_id','users.name(username)','class.name(classname)',],//查询内容
                                                    [
                                                        'AND'   => [
                                                                    'pass'  =>  'true',    //查询条件
                                                                    'article.class_id' =>  $class_id,
                                                                    ],
                                                        'ORDER' =>  'created_at desc',//按照创建时间来进行降序排序  其中desc是降序的符号
                                                        'LIMIT' =>  [($request_page - 1) * $pagecount, $pagecount]  //偏移量

                                                    ]
                                        );
   //$countarray = count($article_all);
    //echo "$countarray";
//var_dump($medoo->last_query());
 //var_dump($article_all);
// die;

?>

<body>
        <?php include './includes/nav.php'; ?>

        <div class="am-g am-container php-bg-white  php-box-shadow am-padding-bottom">
            <?php include './includes/error.php';?>
          
            <!--  <hr data-am-widget="divider" style="" class="am-divider am-divider-default"/> -->
            <section name="top_tips" class="am-margin-top">
                <div class="am-u-lg-4 am-u-md-4 am-u-sm-12">
                    <p class="am-text-sm am-margin-top-xs">时间：<?php echo date('Y-m-d'); ?></p>
                </div>
              <!--   <div class="am-u-lg-4 am-u-md-4 am-u-sm-12">
                    <p class="am-text-sm am-margin-top-xs">今日发帖：1条</p>
                </div> -->
                <div class="am-u-lg-4 am-u-md-4 am-u-sm-12 am-text-right">
                    <a class="am-btn am-btn-primary am-radius am-text-sm" href="<?php echo $host_url; ?>post_article.php">
                    <i class="am-icon-eyedropper"></i>&nbsp;快去发帖
                    </a>
                </div> 
            </section>
                    <ol class="am-breadcrumb">
                          
                          <?php 
                                foreach ($classes as $key => $class) {
                                    if ($class_id == $class['id']) {

                                        ?>
                                        <li class="am-active"><?php  echo $class['name'];?></li>
                                        <?php
                                       
                                    } else {
                                        ?>
                                            <li><a href="./index.php?class_id=<?php echo $class['id'];?>"><?php  echo $class['name'];?></a></li>
                                        <?php
                                    }
                                }
                          ?>
                    </ol>
           <section name="read_article">
                

                <div class="php-topform-left">
                    <ul class="am-list">
                      <?php 
                        foreach ($article_all as $key => $article) {
                            ?>
                                <li><a href="./read_article.php?aid=<?php echo $article['id']; ?>"><?php echo $article['title']; ?></a></li>
                            <?php
                        }
                      ?>
                    </ul>
                </div>
                <div class="php-topform-left">
                    <ul class="am-pagination">
                      <li class="<?php  echo $request_page - 1 <= 0 ? 'am-disabled' : '';?>"><a href="./index.php?class_id=<?php echo $class_id; ?>&page=<?php echo $request_page - 1 > 0 ? $request_page - 1 : 1;?>">&laquo;</a></li>
                        <?php 
                            for ($i = 1; $i <= $pagenum; $i++) { 
                                ?>
                                    <li class="<?php  echo return_via_para($request_page, $i, 'am-active');?>"><a href="./index.php?class_id=<?php echo $class_id; ?>&page=<?php echo $i;?>"><?php echo $i; ?></a></li>
                                <?php
                            }
                        ?>
                      <li class="<?php  echo $request_page + 1 <= $pagenum ?  $request_page + 1 : 'am-disabled';?>"><a href="./index.php?class_id=<?php echo $class_id; ?>&page=<?php echo $request_page + 1 > $pagenum ? $request_page : $request_page + 1;?>">&raquo;</a></li>
                    </ul>
                </div>
            </section>
           
            <div class="am-u-md-2 am-u-lg-2 am-u-sm-2"></div>

        </div>  


 
           

        <?php include './includes/footer.php';?>
</body>

<?php
include './includes/page-end.php';
?>